<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Events\ExamSubmitted;
use App\Models\Result;
use App\Models\User;
use App\Models\Verification;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicApiController extends Controller
{

    public function getUserDetails(Request $request)
    {
        $id = $request->id;
        $data = User::where('id', '=', $id)->get();
        $color = Color::where('user_id', $id)->select('profile_color')->get();
        $data = $data[0] ?? "";
        $color = $color[0] ?? "";
        $fl = substr($data->name, 0, 1);
        $array = compact('data', 'color', 'fl');
        return response()->json($array);
    }

    public function ChangePassword(Request $request)
    {

        $current = User::where('id', '=', $request->user_id)->select('password')->get();
        $current = $current[0];
        $request->validate([
            'current_password' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ]);
        if (Hash::check($request->current_password, $current->password)) {
            User::find($request->user_id)->update(['password' => Hash::make($request->password)]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function resultData(Request $request)
    {
        $user = User::where('id', '=', $request->data0)->get();
        $result = DB::table('result')->where('user_id', $request->data0)->select('score')->get();
        $array = compact('result', 'user');
        return response()->json($array);
    }

    public function checkCode(Request $request)
    {

        $code = Verification::where('user_token', $request->input('id'))->select('code')->get();
        $token = bin2hex(random_bytes(20));

        if ($code[0]->code === $request->code) {

            User::where('id', $request->input('id'))->update(['token' => $token]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
