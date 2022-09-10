<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $data = Quiz::orderBy('title', 'ASC')
            ->where('status', 1)
            ->withCount('related_quesions')
            ->paginate(10);
        return view('admin.quiz.index', compact('data'));
    }

    public function details(Quiz $quiz)
    {
        $quiz->related_quesions = $quiz->related_quesions()
            ->with(['quizQuestionOption'])
            ->get();
        return view('admin.quiz.quiz_details',compact('quiz'));
    }

    public function create()
    {
        return view('admin.quiz.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
        ]);

        $quiz = Quiz::create($request->all());
        $quiz->slug = str_replace(' ', '-', $quiz->title);
        $quiz->creator = auth()->user()->id;
        $quiz->save();

        return redirect()->back()->with('success', 'New quiz inserted successfully.');
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quiz.edit', compact('quiz'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
        ]);

        $quiz = Quiz::find($request->id);
        $quiz->title = $request->title;
        $quiz->creator = auth()->user()->id;
        $quiz->save();

        return redirect()->back()->with('success', 'Quiz updated successfully.');
    }

    public function soft_delete(Request $request)
    {
        $quiz = Quiz::find($request->id);
        $quiz->status = 0;
        $quiz->save();
        return redirect()->back()->with('success', 'Quiz soft deleted successfully.');
    }

    public function delete(Request $request)
    {
        $quiz = Quiz::find($request->id);
        $quiz->status = 0;
        $quiz->delete();

        QuizQuestion::where('quiz_id', $request->id)->update([
            'quiz_id' => null,
        ]);

        return redirect()->back()->with('success', 'Quiz deleted successfully.');
    }

    public function question_append(Quiz $quiz)
    {
        $related_quesions = [];
        foreach ($quiz->related_quesions()->get() as $item) {
            $related_quesions[] = (string) $item->id;
        }
        $related_quesions = json_encode($related_quesions);
        return view('admin.quiz.question_append', compact('quiz', 'related_quesions'));
    }

    public function attach_quiz_question_store(Request $request)
    {
        $quiz_id = $request->id;
        $question_ids = json_decode($request->question_ids);

        DB::table('quiz_quiz_question')->where('quiz_id', $quiz_id)->delete();
        foreach ($question_ids as $quiz_question_id) {
            DB::table('quiz_quiz_question')->insert([
                'quiz_id' => $quiz_id,
                'quiz_question_id' => $quiz_question_id,
            ]);
        }
        return response()->json('success', 200);
    }
}
