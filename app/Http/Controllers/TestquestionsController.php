<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testpages;
use App\Models\Questions;
use Auth;

class TestquestionsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', ['except' => ['index']]);
  }

    public function index($id)
    {
        $testpage = Testpages::where('id', $id)->first();
        $question_ids = json_decode($testpage['questions'], true);
        $questions = array();
        foreach ($question_ids as $key => $value) {
          $questions[] = Questions::where('id', $value)->first();
        }
        // dd($questions);
        return view('testquestions.index', compact('testpage', 'questions'));
    }

  public function edit($id)
  {
        $testpage = Testpages::where('id', $id)->first();
        $questions_choice = json_decode($testpage['questions'], true);
        $questions = Questions::orderBy('sort')->get();
        return view('testquestions.create_and_edit', compact('testpage', 'questions', 'questions_choice'));
  }

  public function edithandle(Request $request)
  {
        // dd($request->all());
      $questions = json_encode($request->choice);
      $id = $request->id;
      $result = Testpages::where('id', $id)->update(['questions' => $questions]);
      if ($result){
        return redirect()->route('testquestions.index', $id)->with('message', '更新成功！');
      } else {
        return redirect()->route('testquestions.index', $id)->with('danger', '更新失败！');
      }
  }
}
