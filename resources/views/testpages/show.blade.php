@extends('layouts.app')

@section('title', $testpage->name)

@section('content')

    <div>
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    {{ $testpage->name }}
                </h2>

                <hr>

                @include('common.error')

                <form action="{{ route('testpages.testhandle', $testpage->id) }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="userid" value="{{ Auth::id() }}">
                    <input type="hidden" name="updated_at" value="{{ $testpage->updated_at }}">
              
                    @foreach($testpage->questions as $question)
				<div class="form-group" style="margin-bottom: 50px;">
					题目{{ $loop->index + 1 }}： {{ $question['title'] }}<br><br>
				      @switch($question['type'])
				        @case('radio')
				          	  选项：
				          	  	@foreach($question['content'] as $choice)
				          	 <div class="radio">
							  	{{ $loop->index + 1 }}.&nbsp;<label>
				          	  		<input class="" type="radio" name="{{$question->id}}" value="{{ $loop->index + 1 }}" />
				          	  		{{ $choice }}
				          	  	</label>
				          	  </div>
				          	  	@endforeach
	                      
				          @break
				        @case('checkbox')
			          	  选项：
			          	  	@foreach($question['content'] as $choice)
			          	  	<div class="checkbox">
							  {{ $loop->index + 1 }}.&nbsp;<label>
							    <input class="" type="checkbox" name="{{$question->id}}[]" value="{{ $loop->index + 1 }}" />
							    {{ $choice }}
							  </label>
							</div>
			          	  	@endforeach
				          @break
				        @case('textarea')
			          	  请作答：
			          	  		<textarea  class="" name="{{$question->id}}" rows="10" cols="30">
								</textarea>
				          @break
				        @default
				        	请填写：
				          	<input class="" type="text" name="{{$question->id}}"/>
				      @endswitch
				      </div>
				      <hr>
				    @endforeach

                    
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection