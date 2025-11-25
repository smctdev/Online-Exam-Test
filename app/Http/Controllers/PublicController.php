<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ExamSubmitted;
use Notification;
use App\Notifications\StatusNotification;
use Hash;
use App\Models\User;
use App\Answer;
use App\Helper\Helper;
use App\Topic;
use App\TempAnswer;
use App\Question;
use App\Models\Exam;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PublicController extends Controller
{
    public function index()
    {
        if (Auth::user()?->status !== "finish") {
            return view('errors.expired');
        }
        return view('finish');
    }
    public function clear()
    {
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('route:cache');
        $exitCode = Artisan::call('route:clear');
        $exitCode = Artisan::call('view:clear');
        $exitCode = Artisan::call('config:cache');
        return '<h1>Cleared</h1>';
    }
    public function expired()
    {
        return view('errors.expired');
    }
    public function notify()
    {

        $token = Auth::user()?->token;
        if (!Helper::hasResult($token)) {
            User::where('token', $token)->update(['notify' => 1]);
            Helper::calculateResult($token);
            $notify = DB::table('users')->where('notify', 1)->select('name', 'id')->get();
            $notify = $notify->toArray();
            $admins = User::where('role', 'A')->get();
            //event(new ExamSubmitted($notify));
            //Notification::send($admins, new StatusNotification($notify));
            return response()->json(['success' => true]);
        }
        return view('errors.expired');
    }
    public function violation()
    {
        $token = Auth::user()?->token;
        $user = User::where('token', $token)->get();
        $user = $user[0];
        User::where('id', $user->id)->update(['status' => 'violator']);
        User::where('id', $user->id)->update([
            'token' => bin2hex(random_bytes(20)),
        ]);
        return response()->json(['success' => true]);
    }
}
