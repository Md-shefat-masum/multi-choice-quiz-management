<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $data = QuizQuestion::orderBy('id', 'DESC')->where('status', 1)->paginate(10);
        return view('admin.question.index', compact('data'));
    }

    public function create()
    {
        $quizes = Quiz::select('id', 'title')->where('status', 1)->orderBy('title', 'ASC')->get();
        return view('admin.question.create', compact('quizes'));
    }

    public function check_valid_input($questions = [])
    {
        $is_error = false;
        foreach ($questions as $item) {
            $item->title_error = '';
            if (!strlen($item->title)) {
                $is_error = true;
                $item->title_error = 'the title field is required';
            }

            $check_count = 0;
            foreach ($item->options as $option) {
                $option->title_error = '';
                if (!strlen($option->title)) {
                    $is_error = true;
                    $option->title_error = 'the title field is required';
                }
                if ($option->is_correct) {
                    $check_count++;
                }
            }
            if (!$check_count) {
                $is_error = true;
                $item->title_error = 'There is no checked correct.';
            }
        }

        if ($is_error) {
            return (object) [
                'status' => 422,
                'message' => 'validation error',
                'data' => $questions,
            ];
        } else {
            return (object) [
                'status' => 200,
                'message' => 'ok',
                'data' => $questions,
            ];
        }
    }

    public function store(Request $request)
    {
        $questions = json_decode(request()->questions);

        $check = $this->check_valid_input($questions);
        if ($check->status == 422) {
            return response()->json($check, 422);
        }

        foreach ($questions as $item) {
            $question = QuizQuestion::create([
                'title' => $item->title,
            ]);
            $question->slug = rand(100000, 999999) . $question->id;
            $question->creator = auth()->user()->id;
            $question->save();

            foreach ($item->options as $option) {
                $option = QuizQuestionOption::create([
                    'quiz_question_id' => $question->id,
                    'title' => $option->title,
                    'is_correct' => $option->is_correct ? 1 : 0,
                ]);
                $option->slug = rand(1000000000, 9999999999) . $option->id;
                $option->save();
            }
        }

        return response(json_encode('success'), 200);
    }

    public function find_single_question($id)
    {
        $question = QuizQuestion::find($id);
        $question->options = $question->quizQuestionOption()->select('quiz_question_id', 'title', 'is_correct', 'slug')->get();
        return response()->json($question);
    }

    public function edit(QuizQuestion $question)
    {
        return view('admin.question.edit', compact('question'));
    }

    public function update()
    {
        $questions = json_decode(request()->questions);

        $check = $this->check_valid_input($questions);
        if ($check->status == 422) {
            return response()->json($check, 422);
        }

        foreach ($questions as $item) {
            $question = QuizQuestion::find($item->id);
            $question->title = $item->title;
            $question->creator = auth()->user()->id;
            $question->save();

            QuizQuestionOption::where('quiz_question_id',$item->id)->delete();
            foreach ($item->options as $option) {
                $new_option = QuizQuestionOption::create(
                    [
                        'quiz_question_id' => $question->id,
                        'title' => $option->title,
                        'is_correct' => $option->is_correct ? 1 : 0,
                        'slug' => '',
                    ]
                );
                $slug = '';
                if(isset($option->slug) && strlen($option->slug)>5){
                    $slug = $option->slug;
                }else{
                    $slug = rand(1000000000, 9999999999) . $option->id;
                }
                $new_option->slug = $slug;
                $new_option->save();
            }
        }

        return response(json_encode('success'), 200);
    }

    public function soft_delete(Request $request)
    {
        $question = QuizQuestion::find($request->id);
        $question->status = 0;
        $question->save();
        return redirect()->back()->with('success', 'Question soft deleted successfully.');
    }

    public function delete(Request $request)
    {
        $question = QuizQuestion::find($request->id);
        $question->status = 0;
        $question->delete();

        QuizQuestion::where('quiz_id', $request->id)->update([
            'quiz_id' => null,
        ]);

        return redirect()->back()->with('success', 'Question deleted successfully.');
    }

    public function json(Request $request)
    {
        $paginate = $request->paginate;
        $key = $request->key;
        $orderBy = $request->orderBy;
        $orderByColumn = $request->orderByColumn;
        $query = QuizQuestion::orderBy($orderByColumn, $orderBy)
            ->where('status', 1)
            ->withCount('related_quiz');

        if ($key && strlen($key) > 0) {
            $quiz_name_check = Quiz::where('title', 'LIKE', "%$key%")->where('status', 1)->first();
            if ($quiz_name_check) {
                $key = (string) $quiz_name_check->id;
            }

            $db_col = [
                // 'id',
                // 'quiz_id',
                'title',
                'message',
                'slug',
                'created_at',
                'updated_at',
            ];
            $query->where(function ($q) use ($key, $db_col) {
                foreach ($db_col as $sl => $col) {
                    if ($col == 'created_at' || $col == 'updatd_at') {
                        if (QuizQuestion::orWhereDate($col, 'LIKE', "%$key%")->exists()) {
                            $q->whereDate($col, "$key");
                            break;
                        }
                    } else if (QuizQuestion::where($col, 'LIKE', "%$key%")->exists()) {
                        $q->where($col, 'LIKE', "%$key%");
                        break;
                    } else {
                    }
                }
            });
        }

        return $query->paginate($paginate);
    }

    public function json_by_id(Request $request)
    {
        $question = QuizQuestion::whereIn('id', json_decode($request->id))->where('status', 1)->get();
        return $question;
    }
}
