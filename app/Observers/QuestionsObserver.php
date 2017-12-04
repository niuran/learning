<?php

namespace App\Observers;

use App\Models\Questions;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class QuestionsObserver
{
    public function saving(Questions $question)
    {
    	dd($question);
		$question->content = json_encode($question->content);
		$question->answer = json_encode($question->answer);
}