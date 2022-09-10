<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserController;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $at_a_glance = (object) [
            'total_quiz' => Quiz::count(),
            'total_quiz_question' => QuizQuestion::count(),
            'total_candidate' => User::where('role_id', 2)->count(),
            'pending_candidate' => User::where('role_id', 2)->where('status', 'pending')->count(),
            'accepted_candidate' => User::where('role_id', 2)->where('status', 'approved')->count(),
            'rejected_candidate' => User::where('role_id', 2)->where('status', 'rejected')->count(),
        ];
        return view('admin.dashboard', compact('at_a_glance'));
    }

    public function accept(User $user)
    {
        $user->status = 'approved';
        $user->save();
        return redirect()->back();
    }

    public function reject(User $user)
    {
        $user->status = 'rejected';
        $user->save();
        return redirect()->back();
    }

    public function candidate_list()
    {
        return view('admin.candidates');
    }

    public function candidates(Request $request)
    {
        $paginate = $request->paginate;
        $key = $request->key;
        $orderBy = $request->orderBy;
        $orderByColumn = $request->orderByColumn;
        $query = User::orderBy($orderByColumn, $orderBy)
            ->with([
                'submitted_quiz' => function ($q) {
                    return $q->with('quiz');
                }
            ])
            ->where('role_id', 2)
            ->where('status', '!=', 'deleted');

        if ($key && strlen($key) > 0) {
            $db_col = [
                'id',
                'name',
                'email',
                'phone',
                'cv_link',
                'created_at',
                'updated_at',
            ];
            $query->where(function ($q) use ($key, $db_col) {
                foreach ($db_col as $sl => $col) {
                    if ($col == 'created_at' || $col == 'updatd_at') {
                        if (User::whereDate($col, 'LIKE', "%$key%")->exists()) {
                            $q->whereDate($col, "$key");
                            break;
                        }
                    } else if (User::where($col, 'LIKE', "%$key%")->exists()) {
                        $q->where($col, 'LIKE', "%$key%");
                        break;
                    } else {
                    }
                }
            });
        }
        $data = $query->paginate($paginate);

        $user_controller = new UserController();
        foreach ($data as $user) {
            $user->quiz_mark = 0;
            foreach ($user->submitted_quiz as $quiz) {
                $quiz->obtain_mark = 0;
                $quiz->obtain_mark = $user_controller->user_quiz_correct_answer($user->id, $quiz->id);
                $user->quiz_mark += $quiz->obtain_mark;
            }
        }
        return $data;
    }

    public function get_user_submission($quiz_id, $render_html = true, $user_id)
    {
        $user_controller = new UserController();
        return $user_controller->get_quiz_result($quiz_id, $render_html, $user_id);
    }

    public function delete(Request $request, User $user)
    {
        $user->status = 'deleted';
        $user->save();
        return redirect()->back()->with('success', 'user deleted successfully.');
    }
}
