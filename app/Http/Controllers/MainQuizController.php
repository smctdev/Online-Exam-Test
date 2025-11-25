<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\TempAnswer;
use App\Models\User;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;
use Session;


class MainQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $auth = Auth::user()->token;

        $user = User::where('token', $auth)->select('id')->get();
        $user = $user[0];
        $input = $request->all();
        $input['user_id'] = $user->id;
        $match = ['question_id' => $input['question_id'], 'user_id' => $user->id, 'topic_id' => $input['topic_id']];
        $x = Answer::where($match)->first();

        if (is_null($input['user_answer']) && is_null($input['answer_exp'])) {
            TempAnswer::where($match)->update(['status' => $input['status']]);
            $newdata = collect();
            $newdata = TempAnswer::where($match)->get();
            $smatch = ['topic_id' => $input['topic_id'], 'user_id' => $user->id];
            $status = TempAnswer::where($smatch)->select('index', 'status')->orderBy('index', 'ASC')->get();
            $status = $status->flatten();
            return response()->json(["newdata" => $newdata, 'status' => $status, "message" => "No Answer Selected"]);
        }
        if ($input['user_answer'] != null || $input['answer_exp'] != null) {
            if ($x != null) {

                Answer::where($match)->update(['user_answer' => $input['user_answer'], 'answer_exp' => ($input['answer_exp'] != null) ? $input['answer_exp'] : null]);
            } else {
                Answer::create($input);
            }

            $answers = Answer::where('user_id', $user->id)->select('question_id', 'user_answer')->get();
            TempAnswer::where($match)->update(['user_answer' => $input['user_answer'], 'answer_exp' => ($input['answer_exp'] != null) ? $input['answer_exp'] : null, 'status' => $input['status']]);
            $newdata = collect();
            $newdata = TempAnswer::where($match)->get();
            $smatch = ['topic_id' => $input['topic_id'], 'user_id' => $user->id];
            $status = TempAnswer::where($smatch)->select('index', 'status')->orderBy('index', 'ASC')->get();
            $status = $status->flatten();

            return response()->json(["answers" => $answers, "newdata" => $newdata, 'status' => $status, "message" => "Data Updated Successfuly"]);
        }
    }

    public function show($id)
    {
        $auth = Auth::user()?->token;

        if (!Helper::hasResult($auth)) {
            $topic = Topic::findOrFail($id);
            $slug = Topic::where('id', $id)->select('slug')->get();
            $slug = $slug[0];
            $user = User::where('token', $auth)->select('id')->get();
            $user = $user[0];
            $questions = collect();
            $count = Exam::where('user_id', '=', $user->id)->select('exam')->get();
            $count = explode(",", $count[0]['exam']);
            $questions = Question::with('topic')->where('topic_id', $topic->id)->select('topic_id', 'id', 'question', 'choices', 'question_img', 'underline', 'type', 'code_snippet')->get();
            foreach ($questions as $key => $value) {
                $quesTitle = $value->question;

                if (!empty($value->underline)) {
                    if (strpos($value->underline, ',')) {
                        $words = explode(',', $value->underline);
                        foreach ($words as $word) {

                            $quesTitle = str_replace($word, "<span class='underline'>" . $word . "</span>", $quesTitle);
                        }
                    } else {
                        if (strpos($quesTitle, $value->underline)) {
                            $quesTitle = str_replace($value->underline, "<span class='underline'>" . $value->underline . "</span>", $quesTitle);
                        }
                    }
                }
                $arr[] = ['topic_id' => $value->topic_id, 'question_id' => $value->id, 'question' => $quesTitle, 'choices' => $value->choices, 'question_img' => $value->question_img, 'user_id' => $user->id, 'type' => $value->type, 'set' => Helper::convertSet($value->code_snippet), 'status' => 'blank'];
            }
            $match = ['topic_id' => $topic->id, 'user_id' => $user->id];
            DB::table('answers')->where($match)->delete();
            DB::table('temp_answers')->where('user_id', $user->id)->delete();
            DB::table('temp_answers')->insert($arr);
            $temp = collect();
            $temp = TempAnswer::where($match)->get();
            $temp = $temp->flatten();
            /* if($topic->set <= 1 ){             \\shuffle exam
                    $temp = $temp->shuffle();
                } */
            $i = 0;
            foreach ($temp as $row) {
                $m = ['topic_id' => $topic->id, 'user_id' => $user->id, 'question_id' => $row['question_id']];
                TempAnswer::where($m)->update(['index' => $i]);
                $i++;
            }
            $finalCollect = collect();
            $finalCollect = TempAnswer::where($match)->orderBy('index', 'ASC')->get();
            $finalCollect = $finalCollect->flatten();
            $status = TempAnswer::where($match)->select('index', 'status')->orderBy('index', 'ASC')->get();
            $status = $status->flatten();
            return response()->json(["questions" => $finalCollect, "topic" => $topic->id, "set" => $topic->set, "auth" => $auth, "count" => $count, "title" => $slug->slug, "status" => $status]);
        }
        return view('errors.expired');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return back()->with('deleted', 'Record has been deleted');
    }
}
