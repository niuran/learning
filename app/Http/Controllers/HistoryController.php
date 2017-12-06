<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usertests;
use App\Models\Testpages;
use App\Models\Questions;
use Auth;

class HistoryController extends Controller
{
	public function index(Usertests $usertests){
		$usertests = $usertests->where('userid', Auth::id())->orderBy('updated_at')->paginate(20);
		foreach ($usertests as $key => $usertest) {
			$result = json_decode($usertest['result'], true);
			$radio_num = $result['radio_num'];
			$radio_correct_num = $result['radio_correct_num'];
			$checkbox_num = $result['checkbox_num'];
			$checkbox_correct_num = $result['checkbox_correct_num'];
			$text_num = $result['text_num'];
			$text_correct_num = $result['text_correct_num'];
			$textarea_num = $result['textarea_num'];
			$usertests[$key]['result'] = '共'.($radio_num+$checkbox_num+$text_num+$textarea_num).'题，单项选择题：共'.$radio_num.'道，正确'.$radio_correct_num.'道，多项选择题：共'.$checkbox_num.'道，正确'.$checkbox_correct_num.'道，填空题：共'.$text_num.'道，正确'.$text_correct_num.'道，解答题：共'.$textarea_num.'道';
		}
		return view('history.index', compact('usertests'));
	}

	public function show($id) {
		$usertest = Usertests::where('id', $id)->first();
		$testpage = testpages::where('id', $usertest->testpageid)->first();

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

		$user_choice = json_decode($usertest->user_choice, true);
		// dd($user_choice);
		return view('history.show', compact('user_choice','testpage'));
		}

		public function destroy(Usertests $usertests,$id)
		{
			$usertests->where('id', $id)->delete();
			return redirect()->route('history.index')->with('message', '成功删除！');
		}

}
