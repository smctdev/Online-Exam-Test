<?php

namespace App\Helper;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Topic;
use App\Models\User;
use App\Models\Result;
use App\Models\Exam;
use App\Models\TempAnswer;
use Illuminate\Support\Facades\DB;
use Session;

class Helper
{
    public static function splitname($name)
    {

        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));
        return array($first_name, $last_name);
    }
    public static function maxChoices($array)
    {
        $max = 0;
        $choicesArr = array();
        foreach ($array as $key => $values) {
            $choices = array();
            $choices[] = json_decode($values->choices);
            $choicesArr[] = json_decode($values->choices);
            if (count((array)$choices[0]) > $max) {
                $max = count((array)$choices[0]);
            }
        }
        for ($i = 0; $i < count((array)$choicesArr); $i++) {
            if (count((array)$choicesArr[$i]) < $max) {
                $choices[$i] = '';
            }
        }
        return array($max, $choicesArr);
    }

    public static function calculateResult($token)
    {
        $eArray = array();
        $computed = array();
        $user = User::where('token', $token)->select('id')->get();
        $user = $user[0];
        $exam = Exam::where('user_id', '=', $user->id)->select('exam')->get();
        $exam = $exam[0]['exam'];
        $exam = explode(",", $exam);
        $topics = Topic::all();

        foreach ($topics as $topic) {

            for ($i = 0; $i < count($exam); $i++) {
                if ($topic->id == $exam[$i]) {
                    $correct = 0;
                    $match = ['topic_id' => $topic->id, 'user_id' => $user->id];
                    $question = Question::where('topic_id', $topic->id)->select('id', 'question', 'answer')->get();
                    $answer = Answer::where($match)->get();
                    if (empty($answer)) {
                        break;
                    } else {
                        foreach ($answer as $anskey => $ansVal) {
                            foreach ($question as $quesKey => $quesVal) {
                                if (!is_null($ansVal->answer_exp)) {
                                    if (!is_null($quesVal->answer)) {
                                        if ($quesVal->id == $ansVal->question_id && strtolower($quesVal->answer) == strtolower($ansVal->answer_exp)) {
                                            $correct++;
                                        }
                                    } else {
                                        if ($quesVal->id == $ansVal->question_id) {
                                            $eArray[] = ['topic_id' => $topic->id, 'user_id' => $user->id, 'situation' => ($ansVal->user_answer != null) ? $ansVal->user_answer : $quesVal->question, 'answer' => $ansVal->answer_exp];
                                            break;
                                        }
                                    }
                                } else {
                                    if ($quesVal->id == $ansVal->question_id && strtolower($quesVal->answer) == strtolower($ansVal->user_answer)) {
                                        $correct++;
                                    }
                                }
                            }
                        }
                    }
                    if (!strcasecmp($topic->title, 'Reading Comprehension') == 0) {
                        $computed[$topic->title] = ['score' => $correct, 'max' => count($question)];
                    }
                }
            }
        }
        if (!empty($computed)) {
            $arr[] = ['user_id' => $user->id, 'score' => json_encode($computed)];
            DB::table('result')->insert($arr);
        }
        if (!empty($eArray)) {
            DB::table('essay')->insert($eArray);
        }
        Answer::where('user_id', $user->id)->delete();
        TempAnswer::where('user_id', $user->id)->delete();
        Exam::where('user_id', $user->id)->update(['end_at' => date('Y-m-d H:i:s')]);
        User::where('token', $token)->update(['status' => 'finish']);
    }
    public static function countSheet($data)
    {
        $counter = 0;
        $data->each(function ($sheet) use (&$counter) {
            $counter++;
        });
        return $counter;
    }

    public static function hasResult($token)
    {
        $user = User::where('token', $token)->select('id')->get();
        $user = $user[0];
        $result = DB::table('result')->where('user_id', $user->id)->first();
        if ($result)
            return true;
        else
            return false;
    }

    public static function convertSet($set)
    {

        $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
        $cSet = 0;
        for ($i = 0; $i < count($alpha); $i++) {
            if ($set - 1 == $i) {
                $cSet = 'SET ' . $alpha[$i];
            }
        }
        return $cSet;
    }
}
