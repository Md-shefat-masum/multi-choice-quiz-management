<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestionOption;
use App\Models\QuizSubmission;
use App\Models\QuizSubmissionUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if(auth()->user()->status == 'deleted'){
            return "
                <div style='background:gray;height:98vh;display:flex;justify-content:center;align-items:center'>
                    <img src=\"/images/dactivated.png\"/>
                </div>
            ";
        }
        $quizes = Quiz::where('status', 1)->get();
        foreach ($quizes as $item) {
            $item->questions = $item->related_quesions()->count();
            $item->obtained_mark = $this->user_quiz_correct_answer(auth()->user()->id, $item->id);
            $item->attend = User::find(auth()->user()->id)->submitted_quiz()
                ->where('quiz_id', $item->id)->exists();
        }
        return view('user.dashboard', compact('quizes'));
    }

    public function get_quiz(Quiz $quiz)
    {
        return view('user.quiz', compact('quiz'));
    }

    public function get_quiz_result($quiz_id, $render_html = false, $user_id = null)
    {
        $quiz = Quiz::find($quiz_id);
        $quiz = $this->user_quiz_submission($user_id ? $user_id : auth()->user()->id, $quiz->id);

        if ($render_html) {
            return view('user.quiz_result', compact('quiz'))->render();
        } else {
            return view('user.quiz_result', compact('quiz'));
        }
    }

    public function submit_quiz()
    {
        // checking for empty requests
        $validator = Validator::make(request()->all(), [
            'qa' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        // processing and submission of quizzes
        $quiz_submission = [];
        $correct_answers = 0;
        $quiz = null;
        foreach (request()->qa as $quiz_id => $questions) {

            // check the quiz already submitted
            $check_exist_user_quiz = QuizSubmissionUser::where('quiz_id', $quiz_id)->where('user_id', auth()->user()->id)->exists();
            // if ($check_exist_user_quiz) {
            //     return response()->json([
            //         'status' => 406, // not acceptable
            //         'error_message' => 'this quiz has already been submitted in.',
            //     ], 406);
            // }

            // total the number of quiz questions and submitted questions.
            // if not no equeal then return 406 error

            $quiz = Quiz::where('id', $quiz_id)->select('id')->first();
            if ($quiz->related_quesions()->count() != count($questions)) {
                $not_answered_questions = $this->check_not_answered_questions($quiz, $questions);
                return response()->json([
                    'status' => 406, // not acceptable
                    'error_message' => 'Please check the list of questions you must respond to.',
                    'data' => [
                        'message' => 'unanswered questions',
                        'items' => $not_answered_questions,
                    ]
                ], 406);
            }

            // keep track of who submitted the quiz.
            $submission = QuizSubmissionUser::create([
                'user_id' => auth()->user()->id,
                'quiz_id' => $quiz_id,
            ]);

            // design an array for submitting quiz answers

            foreach ($questions as $question_id => $options) {
                // submission table common fields
                $temp_submission = [
                    'submission_id' => $submission->id,
                    'quiz_id' => $quiz_id,
                    'question_id' => $question_id,
                ];

                foreach ($options as $option_slug) {
                    // Find the perfect answers from each question
                    $correct_options = QuizQuestionOption::where('quiz_question_id', $question_id)
                        ->where('is_correct', 1)->get()->map(function ($i) {
                            return $i->slug;
                        })->toArray();
                    $is_correct = 0;

                    // check the given answer is correct or not
                    // All legitimate answers are contained in $correct_options array.
                    if (in_array((int) $option_slug, $correct_options)) {
                        $correct_answers++;
                        $is_correct = 1;
                    }

                    // merge option_id and check_correct with temp submission.
                    $temp_submission = array_merge($temp_submission, [
                        'option_slug' => $option_slug,
                        'is_correct' => $is_correct,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                        // 'correct_options' => $correct_options,
                    ]);

                    $quiz_submission[] = $temp_submission;
                }
            }
        }

        // database saving submitted information
        QuizSubmission::insert($quiz_submission);

        return  response()->json([
            // $quiz_submission,
            'status' => 200, // success
            'success_message' => 'The quiz was successfully submitted.',
            'data' => [
                'quiz_id' => $quiz->id,
                'correct_answers' => $this->user_quiz_correct_answer(auth()->user()->id, $quiz_id),
                'preview_correct_answers' => $this->get_quiz_result($quiz->id, true),
            ]
        ], 200);
    }

    public function check_not_answered_questions($quiz, $submitted_questions)
    {
        $submitted_question_id = [];
        foreach ($submitted_questions as $id => $data) {
            $submitted_question_id[] = $id;
        }
        $data = $quiz->related_quesions()->get()
            ->where('status', 1)
            ->whereNotIn('id', $submitted_question_id)
            ->map(function ($i) {
                return $i->slug;
            });
        return $data;
    }

    public function user_quiz_correct_answer($user_id, $quiz_id)
    {
        $user = User::where('id', $user_id)->first();

        if (!$user->submitted_quiz()->where('quiz_id', $quiz_id)->exists()) {
            return 0;
        }

        $submitted_quiz = $user->submitted_quiz()->where('quiz_id', $quiz_id)->first();
        $quiz = $submitted_quiz->quiz()->first();
        $questions = $quiz->related_quesions()
            ->withCount([
                'quizQuestionOption' => function ($q) {
                    return $q->where('is_correct', 1)->where('status', 1);
                }
            ])
            ->with(['quizQuestionOption'])
            ->get();

        $correct_answer = 0;
        foreach ($questions as $question) {
            $correct_option_ids = [];
            foreach ($question->quizQuestionOption as $option) {
                if ($option->is_correct) {
                    $correct_option_ids[] = $option->slug;
                }
            }

            $user_submitted_option_ids = $submitted_quiz->quiz_submission()
                ->where('question_id', $question->id)
                ->get()->map(function ($i) {
                    return $i->option_slug;
                })->toArray();

            sort($user_submitted_option_ids);
            sort($correct_option_ids);
            if ($user_submitted_option_ids == $correct_option_ids) {
                $correct_answer++;
            }
        }
        return $correct_answer;
    }

    public function user_quiz_submission($user_id, $quiz_id)
    {
        $user = User::where('id', $user_id)->first();
        $submitted_quiz = $user->submitted_quiz()->where('quiz_id', $quiz_id)->first();
        $quiz = $submitted_quiz->quiz()
            ->withCount(['related_quesions'])
            ->with([
                'related_quesions' => function ($q) {
                    $q->with([
                        'quizQuestionOption'
                    ]);
                }
            ])
            ->first();

        $correct_answer = 0;

        foreach ($quiz->related_quesions as $question) {
            $correct_option_ids = [];
            foreach ($question->quizQuestionOption as $option) {
                if ($option->is_correct) {
                    $correct_option_ids[] = $option->slug;
                }

                $check_user_submited_option = $submitted_quiz->quiz_submission()
                    ->where('question_id', $question->id)
                    ->where('option_slug', $option->slug)
                    ->first();

                if ($check_user_submited_option) {
                    $option->user_selected = 1;
                    $option->user_selected_correct = $check_user_submited_option->is_correct;
                } else {
                    $option->user_selected = 0;
                    $option->user_selected_correct = 0;
                }
            }

            $user_submitted_option_ids = $submitted_quiz->quiz_submission()
                ->where('question_id', $question->id)
                ->get()->map(function ($i) {
                    return $i->option_slug;
                })->toArray();

            sort($user_submitted_option_ids);
            sort($correct_option_ids);

            if ($user_submitted_option_ids == $correct_option_ids) {
                $correct_answer++;
                $question->correct_answer = 1;
            } else {
                $question->correct_answer = 0;
            }
        }

        $quiz->correct_answer = $correct_answer;
        if (request()->has('test')) {
            return dd(
                $quiz->toArray()
            );
        }
        return $quiz;
    }

    public function user_details_modal(Request $request,User $user)
    {
        return view('user.details',compact('user'));
    }

    public function user_information_get(Request $request,User $user)
    {
        return view('user.edit',compact('user'));
    }

    public function user_information_update(Request $request,User $user)
    {
        $user->fill($request->all())->save();
        return redirect()->back()->with('success','data updated successfully');
    }
}
