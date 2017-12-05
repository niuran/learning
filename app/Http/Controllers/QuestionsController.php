<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Http\Requests\QuestionRequest;
use Auth;

class QuestionsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', ['except' => ['index']]);
  }

    public function index(Questions $question)
    {
        $questions = $question->where('userid', Auth::id())->orderBy('sort')->paginate(20);
        return view('questions.index', compact('questions'));
    }

  public function create(Questions $question)
  {
    return view('questions.create_and_edit', compact('question'));
  }

  public function store(QuestionRequest $request, Questions $question)
  {
        $question->fill($request->all());
        $question->content = json_encode($request->content);
        if($question->type == 'checkbox'){
          $question->answer = json_encode($request->answer);
        }
        if($question->type == 'text' || $question->type == 'textarea') {
          if ($request->testanswer){
            $question->answer = $request->textanswer;
          } else {
            $question->answer = '无';
          }
          
        }
        // dd($question);
        $question->save();

        return redirect()->route('questions.index')->with('message', '成功创建测试！');
  }

  public function edit(Questions $question)
  {
      if($question->type == 'text' || $question->type == 'textarea') {
        $question->textanswer = $question->answer;
      }
      if($question->type == 'radio') {
        $question->content = json_decode($question->content, true);
      }
      if($question->type == 'checkbox') {
        $question->content = json_decode($question->content, true);
        $question->answer = json_decode($question->answer, true);
      }
      // dd($question);
      return view('questions.create_and_edit', compact('question'));
  }

  public function update(QuestionRequest $request, Questions $question)
  {
        $question->fill($request->all());
        $question->content = json_encode($request->content);
        if($question->type == 'checkbox'){
          $question->answer = json_encode($request->answer);
        }
        if($question->type == 'text' || $question->type == 'textarea') {
          $question->answer = $request->textanswer;
        }
        // dd($question);
        $question->save();
    return redirect()->route('questions.index')->with('message', '更新成功！');
  }

  public function destroy(Questions $question)
  {
    $question->delete();

    return redirect()->route('questions.index')->with('message', '成功删除！');
  }
}
