@extends('layouts.app')

@section('title', $testpage->name)

@section('content')

    <div>
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    {{ $testpage->name }}-测试结果
                </h2>

                <hr>

                @include('common.error')

                <form action="{{ route('testpages.testhandle', $testpage->id) }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="userid" value="{{ Auth::id() }}">
                    <input type="hidden" name="updated_at" value="{{ $testpage->updated_at }}">
              
                @foreach($testpage->questions as $question)
				<div class="form-group" style="margin-bottom: 50px;">
					<div class="row">
  						<div class="col-md-7">
题目{{ $loop->index + 1 }}： {{ $question['title'] }}<br><br>
  @switch($question['type'])
    @case('radio')
      	  选项：
      	  	@foreach($question['content'] as $choice)
      	 <div class="radio">
		  	{{ $loop->index + 1 }}.&nbsp;<label>
      	  		<input class="" type="radio" name="{{$question->id}}" value="{{ $loop->index + 1 }}" @if($user_choice[$question->id]['choice'] == ($loop->index + 1)) checked @endif />
      	  		{{ $choice }}
      	  	</label>
      	  	@if($user_choice[$question->id]['choice'] == ($loop->index + 1))
      	  		@if($user_choice[$question->id]['choice'] == $question->answer)
      	  		<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;">回答正确</span>
      	  		@else
      	  		<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: red;">回答错误</span>
      	  		@endif
      	  	@endif

      	  	@if(($loop->index + 1) == $question->answer)
      	  	<span class="glyphicon glyphicon-star" aria-hidden="true" style="color: blue;margin-left: 100px;">正确答案</span>
      	  	@endif
      	  </div>
      	  	@endforeach
      
      @break
    @case('checkbox')
  	  选项：
  	  	@foreach($question['content'] as $choice)
  	  	<div class="checkbox">
		  {{ $loop->index + 1 }}.&nbsp;<label>
		    <input class="" type="checkbox" name="{{$question->id}}[]" value="{{ $loop->index + 1 }}" @foreach($user_choice[$question->id]['choice'] as $questionchoice)
			    @if($questionchoice == ($loop->parent->index + 1)) checked @endif
		    @endforeach />
		    {{ $choice }}
		  </label>
		  @php
		  $is_true = 0;
		  @endphp
		  
		  @foreach($user_choice[$question->id]['choice'] as $questionchoice)
		      @if($questionchoice == ($loop->parent->index + 1))
		      	@foreach($user_choice[$question->id]['answer'] as $answer)
				  	@if($answer == ($loop->parent->index + 1))
				  		<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;">回答正确</span>
		  				  @php
						  $is_true = 1;
						  @endphp
				  	@endif
				@endforeach
				@if($is_true == 0)
					<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: red;">回答错误</span>
				@endif
		      @endif
	      @endforeach

		  @foreach($user_choice[$question->id]['answer'] as $answer)
		  	@if($answer == ($loop->parent->index + 1))
		  		<span class="glyphicon glyphicon-star" aria-hidden="true" style="color: blue;margin-left: 100px;">正确答案</span>
		  	@endif
		  @endforeach
		</div>
  	  	@endforeach
      @break
    @case('textarea')
  	  请作答：
  	  		<textarea  class="" name="{{$question->id}}" rows="10" cols="50">{{ $user_choice[$question->id]['choice'] }}</textarea>
  	  		<span class="glyphicon glyphicon-star" aria-hidden="true" style="color: blue;">请参考答案</span>
      @break
    @default
    	请填写：
      	<input class="" type="text" name="{{$question->id}}" value="{{ $user_choice[$question->id]['choice'] }}" />
      	@if ($user_choice[$question->id]['choice'] == $user_choice[$question->id]['answer'])
      		<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;">回答正确</span>
      	@else
      		<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color: red;">回答错误</span>
      	@endif
  @endswitch
				  		</div>
				  		<div class="col-md-5">
				  			正确答案：
				  			  @switch($question['type'])
							    @case('radio')
							      	{{ $question->answer }}
							      @break
							    @case('checkbox')
							  	  	{{ implode('，', $question->answer) }}
							      @break
							    @case('textarea')
							  	  	{{ $question->answer }}
							      @break
							    @default
							    	{{ $question->answer }}
							  @endswitch
				  		</div>
				    </div>
				</div>
				<hr>
				@endforeach

                    
                    <!-- <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>

@endsection