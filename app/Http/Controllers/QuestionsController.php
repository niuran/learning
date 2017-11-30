<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use Auth;

class QuestionsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', ['except' => ['index']]);
  }

    public function index(Questions $question)
    {
        $questions = $question->orderBy('sort')->paginate(20);
        return view('questions.index', compact('questions'));
    }

  public function create(Questions $question)
  {
    return view('questions.create_and_edit', compact('question'));
  }

  public function store(Request $request, Questions $question)
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

        return redirect()->route('questions.index')->with('message', '成功创建测试！');
  }

  public function edit(Questions $question)
  {
      if($question->type == 'text' || $question->type == 'textarea') {
        $question->textanswer = $question->answer;
      }
        return view('questions.create_and_edit', compact('question'));
  }

  public function update(Request $request, Questions $question)
  {
    $question->update($request->all());

    return redirect()->route('questions.index')->with('message', '更新成功！');
  }

  public function destroy(Questions $question)
  {
    $question->delete();

    return redirect()->route('questions.index')->with('message', '成功删除！');
  }
}
