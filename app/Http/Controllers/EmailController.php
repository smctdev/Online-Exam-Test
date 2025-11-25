<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ExamEmail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Exam;
use App\Models\Verification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailController extends Controller
{


    public function sendmail(Request $request, $token, $name, $email, $userID)
    {
        $user = (object)['name' => $name, 'token' => $token];
        $input = $request->all();
        $exam = '';
        foreach ($input as $value) {
            if (is_numeric($value)) {
                if (!empty($exam))
                    $exam = $exam . ',' . $value;
                else
                    $exam = $value;
            }
        }
        Exam::create([
            'user_id' => $userID,
            'exam' => $exam,
            'sent_by' => $input['auth'],
        ]);
        /* $arr= array(['user_id'=>$userID,'exam' => $exam ],'created_at' => date("Y-m-d h:i:s") );
        \DB::table('exam')->insert($arr); */

        Mail::to($email)->send(new ExamEmail($user));

        return redirect()->back()->with('success', 'your message,here');
    }
    public function verifyEmail(Request $request)
    {
        $data = User::where('email', $request->input('email'))->get();
        $data = $data[0];
        $data['code'] = Str::upper(Str::random(6));
        $x = Verification::where('user_token', $data['id'])->first();
        if ($x != null) {

            Verification::where('user_token', $data['id'])->update(['code' => $data['code']]);
        } else {
            Verification::create([
                'user_token' => $data['id'],
                'code' => $data['code'],
            ]);
        }


        Mail::to($request->input('email'))->send(new VerifyEmail($data));

        return response()->json(['success' => true]);
    }
}
