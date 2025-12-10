<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ExamSubmitted;
use App\Models\User;
use App\Models\Exam;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Essay;
use App\Models\copyrighttext;
use App\Models\Question;
use App\Models\Result;
use App\Models\Color;
use App\Helper\Helper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use View;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        $topics = Topic::count();
        $admin_count = User::where('role', '=', 'A')->count();
        $examinee_count = User::where('role', '=', 'E')->count();
        $completed_count = Result::count();
        $pending_count = User::where('status', '=', 'sent')->count();
        if ($request->ajax()) {
            return view('admin.dashboard', compact('topics', 'notify', 'admin_count', 'examinee_count', 'completed_count', 'pending_count'))->renderSections()['content'];
        }
        return view('admin.dashboard', compact('topics', 'notify', 'admin_count', 'examinee_count', 'completed_count', 'pending_count'));
    }

    public function apptitude($slug)
    {
        $topic = Topic::where('slug', $slug)->first();

        $auth = Auth::user()?->token;

        $user = Auth::user();

        if ($user?->status === 'violator' || $user?->exam?->violation > 5) {
            abort(403);
        }

        if (!Helper::hasResult($auth)) {
            $answers = Answer::where('topic_id', '=', $topic->topic_id)->first();
            User::where('token', $auth)->update(['status' => 'progress']);
            return view('main_quiz', compact('topic', 'answers'));
        }
        return view('errors.expired');
    }

    public function startquiz()
    {
        $auth = Auth::user()?->token;

        if (!$auth) {
            return redirect()->route('login');
        }

        if (!Helper::hasResult($auth)) {
            $exam_user = User::where('token', $auth)->select('id')->get();
            $exam_user = $exam_user[0];
            $topics = DB::select('select * from topics');
            $topic = array();
            $exam = Exam::where('user_id', '=', $exam_user->id)->select('exam')->get();
            // dd($exam);
            $exam = $exam[0]['exam'] ?? null;
            $exam = explode(",", $exam);
            for ($i = 0; $i < count($exam); $i++) {
                foreach ($topics as $sub) {
                    if ($sub->id == $exam[$i])
                        $topic[$i] = ['title' => $sub->title, 'slug' => $sub->slug];
                }
            }

            return view('front', compact('topic', 'exam'));
        }
        return view('errors.expired');
    }

    public function category($slug)
    {
        $auth = Auth::user()?->token;

        $user = Auth::user();

        if ($user?->status === 'violator' || $user?->exam?->violation > 5) {
            abort(403);
        }

        if (!Helper::hasResult($auth)) {
            $topic = Topic::withCount('question')->where('slug', $slug)->first();
            $user_id = User::where('token', $auth)->select('id')->get();
            $started = Exam::where('user_id', $user_id[0]['id'])->select('started_at')->get();
            if (empty($started[0]['started_at'])) {
                Exam::where('user_id', $user_id[0]['id'])->update(['started_at' => date('Y-m-d H:i:s')]);
            }
            return view('cover')->with('topic', $topic);
        }
        return view('errors.expired');
    }

    public function examinee($id)
    {
        $user_token = DB::select('select token from users');
        $user_token = array_column($user_token, 'token');
        if (in_array($id, $user_token)) {
            if (!Helper::hasResult($id)) {
                $user = DB::select('select * from users where token = ?', [$id]);
                $user = $user[0];
                return view('home', compact('user'));
            } else {
                return view('errors.expired');
            }
        }
        return view('errors.404');
    }

    public function uploadImages(Request $request)
    {
        $this->validate($request, [
            'img.*' => 'mimes:jpeg,png,bmp,tiff|required |max:4096',
        ]);
        $topic_id = $request->topic_id;
        $image_get = $request->img;
        $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $set = '';
        $images = array();
        $index = 0;

        foreach ($image_get as $image) {
            $set = substr($image->getClientOriginalName(), 0, 1);
            $fileOriginalName = time() . '-' . $image->getClientOriginalName();
            $image->move('storage/question_img/', $fileOriginalName);
            $images[$index] = $fileOriginalName;
            $index++;
        }
        $i = 0;
        $set = array_search($set, $alpha) + 1;
        $param = ['topic_id' => $topic_id, 'code_snippet' => $set];
        $question = DB::table('questions')->where($param)->select('id')->get();
        foreach ($question as $quesID => $id) {

            if ($i < count($images)) {
                Question::where(['topic_id' => $topic_id, 'id' => $id->id])->update(['question_img' => $images[$i]]);
                $i++;
            }
        }
        return back()->with('added', 'Images has been uploaded');
    }

    public function applicants(Request $request)
    {
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        $users = User::where('role', '!=', 'S')->orderBy('created_at', 'desc')->paginate(10);
        $topics = Topic::whereHas('question')->get();
        if ($request->ajax()) {
            return view('admin.examinees', compact('users', 'notify', 'topics'))->renderSections()['content'];
        }
        return view('admin.examinees', compact('users', 'notify', 'topics'));
    }

    public function adminlist(Request $request)
    {
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        $users = User::where('role', '=', 'S')->orderBy('created_at', 'asc')->get();
        $userInfo = User::where('id', '=', 1)->get();
        if ($request->ajax()) {
            return view('admin.adminlist', compact('users', 'userInfo', 'notify'))->renderSections()['content'];
        }
        return view('admin.adminlist', compact('users', 'userInfo', 'notify'));
    }

    public function exportTemplate()
    {
        return Storage::disk('public')->download('Question Template.xlsx');
    }

    public function getResult(Request $request, $id)
    {

        $user = User::where('id', $id)->get();
        $user = $user[0];
        $essay = DB::table('essay')->where('user_id', $id)->get();
        $result = DB::table('result')->where('user_id', $id)->select('score')->get();
        $users = User::where('status', 'finish')->get();
        User::where('id', $id)->update(['notify' => 0]);
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        if ($request->ajax()) {
            return view('partial.result', compact('result', 'user', 'notify', 'users', 'essay'))->renderSections()['content'];
        }
        return view('partial.result', compact('result', 'user', 'notify', 'users', 'essay'));
    }

    public function exportPDF(Request $request)
    {
        $essay = DB::table('essay')->where('user_id', $request->id)->get();
        $user = User::where('id', $request->id)->get();
        $user = $user[0];
        $data = compact('essay', 'user');
        $pdf = Pdf::loadView('partial.situationpdf', $data);
        return $pdf->download(ucwords(str_replace(' ', '', $user->name)) . 'SE-.pdf');
    }
    public function exportResultPDF(Request $request)
    {
        $result = DB::table('result')->where('user_id', $request->id)->select('score')->get();
        $user = User::where('id', $request->id)->get();
        $user = $user[0];
        $data = compact('result', 'user');
        $pdf = Pdf::loadView('partial.resultpdf', $data);
        return $pdf->download(ucwords(str_replace(' ', '', $user->name)) . 'ExamResult-.pdf');
    }
}
