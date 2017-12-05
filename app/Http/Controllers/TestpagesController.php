<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testpages;
use App\Models\Questions;
use Auth;

class TestpagesController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', ['except' => ['index']]);
  }

    public function index(Testpages $testpage)
    {
        $testpages = $testpage->orderBy('sort')->paginate(20);
        return view('testpages.index', compact('testpages'));
    }

  public function create(Testpages $testpage)
  {
    return view('testpages.create_and_edit', compact('testpage'));
  }

  public function store(Request $request, Testpages $testpage)
  {
        $testpage->fill($request->all());
        // dd($testpage);
        $testpage->save();

        return redirect()->route('testpages.index')->with('message', '成功创建测试！');
  }

  public function edit(Testpages $testpage)
  {
        return view('testpages.create_and_edit', compact('testpage'));
  }

  public function update(Request $request, Testpages $testpage)
  {
    $testpage->update($request->all());

    return redirect()->route('testpages.index')->with('message', '更新成功！');
  }

  public function destroy(Testpages $testpage)
  {
    $testpage->delete();

    return redirect()->route('testpages.index')->with('message', '成功删除！');
  }

  public function show(Testpages $testpage)
  {
    $question_ids = json_decode($testpage->questions, true);
    $questions = array();
    foreach ($question_ids as $key => $value) {
      $question = Questions::where('id', $value)->first();
      if ($question->type == 'radio') {
        $question->content = json_decode($question->content, true);
      }
      if ($question->type == 'checkbox') {
        $question->content = json_decode($question->content, true);
        $question->answer = json_decode($question->answer, true);
      }
      $questions[] = $question;
    }
    $testpage->questions = $questions;
    // dd($testpage);
    return view('testpages.show', compact('testpage'));
  }

  public function testhandle(Request $request, $id)
  {
    $testpage = testpages::where('id', $id)->first();
    // dd($testpage);
    $question_ids = json_decode($testpage->questions, true);
    $questions = array();
    foreach ($question_ids as $key => $value) {
      $question = Questions::where('id', $value)->first();
      if ($question->type == 'radio') {
        $question->content = json_decode($question->content, true);
      }
      if ($question->type == 'checkbox') {
        $question->content = json_decode($question->content, true);
        $question->answer = json_decode($question->answer, true);
      }
      $questions[] = $question;
    }
    $testpage->questions = $questions;

    //testhandle
    $user_choice = array();
    $userid = $request->userid;
    $updated_at = $request->updated_at;
    foreach ($request->all() as $key => $value) {
      $question = Questions::where('id', $key)->first();
      if($question){
        $user_choice[$key]['choice'] = $value;
        if($question['type'] == 'checkbox') {
          $user_choice[$key]['answer'] = json_decode($question['answer'], true);
        } else {
          $user_choice[$key]['answer'] = $question['answer'];
        }
      }
    }
    // dd($user_choice);
    return view('testpages.testresult', compact('user_choice','testpage'));
  }

}
