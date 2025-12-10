<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Question;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $topics = Topic::all();
        $questions = Question::all();
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        if ($request->ajax()) {
            return view('admin.questions.index', compact('questions', 'topics', 'notify'))->renderSections()['content'];
        }
        return view('admin.questions.index', compact('questions', 'topics', 'notify'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Import a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importExcelToDB(Request $request)
    {
        $request->validate([
            'question_file' => 'required|mimes:xlsx,xls'
        ]);
        if ($request->hasFile('question_file')) {
            $file = $request->file('question_file');
            $filename = $file->getClientOriginalName();
            $file->move('questionfiles', $filename);
            $path = public_path() . '/assessment/questionfiles/' . $filename; //for online
            //$path=public_path().'/questionfiles/'.$filename;//for offline
            $data = Excel::load($path)->get();
            $countSheet = Helper::countSheet($data);
            $set = 1;
            foreach ($data as $sheet) {
                $arr = array();
                foreach ($sheet as $value) {
                    $choices = array();
                    $alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o'];
                    $c = count($alpha);
                    for ($i = 0; $i < $c; $i++) {
                        if (!empty($value[$alpha[$i]])) {
                            $choices[$i] = $value[$alpha[$i]];
                        } else {
                            break;
                        }
                    }
                    $arr[] = ['topic_id' => $request->topic_id, 'question' => $value->question, 'choices' => json_encode($choices), 'answer' => $value->answer, 'code_snippet' => $set, 'underline' => $value->underline, 'type' => $value->type];
                }
                try {
                    DB::table('questions')->insert($arr);
                    $set++;
                } catch (Exception $e) {
                    return back()->with('deleted', 'We encounter error in processing your request.Error:' . $e);
                }
            }
            return back()->with('added', 'Questions Successfully Imported');
        }
        return back()->with('deleted', 'Request data does not have any files to import');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required',
            'question' => 'required',
            'type' => 'required',
            'question_img' => 'image'
        ]);

        $input = $request->all();
        $input['choices'] = json_encode(explode(',', $input['choices']));

        if ($file = $request->file('question_img')) {

            $name = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('question_img', $name, 'public');
            $input['question_img'] = $name;
        }

        Question::create($input);
        return back()->with('added', 'Question has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        $questions = Question::where('topic_id', $topic->id)->get();
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        return view('admin.questions.show', compact('topic', 'questions', 'notify'));
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
        $question = Question::findOrFail($id);
        $request->validate([
            'topic_id' => 'required',
            'question' => 'required',
            'type' => 'required',
            'question_img' => 'image'
        ]);

        $input = $request->all();
        $array = explode(',', $input['choices']);
        $input['choices'] = json_encode($array);
        if ($input['type'] != 'essay') {

            for ($i = 0; $i < count($array); $i++) {
                if ($i == $input['answer']) {
                    $input['answer'] = $array[$i];
                    break;
                }
            }
        }
        if ($file = $request->file('question_img')) {

            $name = time() . '-' . $file->getClientOriginalName();

            if ($question->question_img != null) {
                Storage::disk('public')->delete("question_img/{$question->question_img}");
            }

            $file->storeAs('question_img', $name, 'public');

            $input['question_img'] = $name;
        }

        if ($request->remove_image) {
            $input['question_img'] = null;
            Storage::disk('public')->delete("question_img/{$question->question_img}");
        }

        $question->update($input);

        return back()->with('updated', 'Question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if ($question->question_img != null) {
            unlink(public_path() . '/assessment/storage/question_img/' . $question->question_img);
        }

        $question->delete();
        return back()->with('deleted', 'Question has been deleted');
    }
    public function destroyTopic($id)
    {
        $question = Question::findOrFail($id);

        if ($question->question_img != null) {
            unlink(public_path() . '/storage/question_img/' . $question->question_img);
        }

        $question->delete();
        return back()->with('deleted', 'Question has been deleted');
    }
}
