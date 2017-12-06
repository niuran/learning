<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testpages;
use App\Models\Questions;
use App\Http\Requests\TestpageRequest;
use App\Models\Usertests;
use Auth;

class TestpagesController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', ['except' => ['index']]);
  }

    public function index(Testpages $testpage)
    {
        $testpages = $testpage->where('userid', Auth::id())->orderBy('sort')->paginate(20);
        return view('testpages.index', compact('testpages'));
    }

  public function create(Testpages $testpage)
  {
    return view('testpages.create_and_edit', compact('testpage'));
  }

  public function store(TestpageRequest $request, Testpages $testpage)
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

  public function update(TestpageRequest $request, Testpages $testpage)
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

  public function testhandle(Request $request, $id, Usertests $usertests)
  {
    

    $testpage = testpages::where('id', $id)->first();

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
    $testpage->questions = $questions;//数据库取出本试题所有问题，到该数组中

    /* ----- 表单验证 start ----- */
    $validate = array();
    foreach ($request->all() as $key => $value) {
      if(is_numeric($key)) {
        $validate[$key] = $value;
      }
    }

    $question_ids = array();
    foreach ($testpage->questions as $key => $value) {
      $question_ids[$value['id']] = $value['type'];
    }
    // dd($question_ids);

    $array_diff = array_diff_key($question_ids, $validate);
    // dd($question_ids, $validate, $array_diff);

    if (count($array_diff)){
      $message = '单选多选为必填项，题目';
      foreach ($array_diff as $key => $value) {
        session(['key' => 'value']);
        $message = $message . $key . ' ';
      }
      $message = $message . '未填写';
      return redirect()->route('testpages.show', $testpage->id)->with('danger', $message);
    }
    /* ----- 表单验证 end ----- */

    //testhandle
    $user_choice = array();
    foreach ($request->all() as $key => $value) {
      $question = Questions::where('id', $key)->first();
      if($question){
        $user_choice[$key]['choice'] = $value;
        $user_choice[$key]['type'] = $question['type'];
        if($question['type'] == 'checkbox') {
          $user_choice[$key]['answer'] = json_decode($question['answer'], true);
        } else {
          $user_choice[$key]['answer'] = $question['answer'];
        }
      }
    }
    // dd($user_choice);//用户选择与正确答案

    //处理测试情况
    $radio_correct_num = 0;
    $radio_num = 0;
    $checkbox_num = 0;
    $checkbox_correct_num = 0;
    $text_num = 0;
    $text_correct_num = 0;
    $textarea_num = 0;
    foreach ($user_choice as $key => $value) {
      switch ($value['type']) {
        case 'radio':
          $radio_num ++;
          if($value['choice'] == $value['answer']) {
            $radio_correct_num ++;
          }
          break;
        case 'checkbox':
          $checkbox_num ++;
          if(count(array_diff($value['choice'], $value['answer'])) == 0) {
            $checkbox_correct_num ++;
          }
          break;
        case 'text':
          $text_num ++;
          if($value['choice'] == $value['answer']) {
            $text_correct_num ++;
          }
          break;
        
        default:
          $textarea_num ++;
          break;
      }
    }
    $result = [
      'radio_num' => $radio_num,
      'radio_correct_num' => $radio_correct_num,
      'checkbox_num' => $checkbox_num,
      'checkbox_correct_num' => $checkbox_correct_num,
      'text_num' => $text_num,
      'text_correct_num' => $text_correct_num,
      'textarea_num' => $textarea_num,
    ];


    //store user choice
    $user_choice_db = array();
    $usertests->userid              = $request->userid;
    $usertests->testpage_updated_at = $request->updated_at;
    $usertests->testpageid          = $testpage->id;
    $usertests->user_choice         = json_encode($user_choice);
    $usertests->result = json_encode($result);
    $usertests->save();

    return redirect()->route('history.index')->with('message', '保存成功！');
    // return view('testpages.testresult', compact('user_choice','testpage'));
  }

}
