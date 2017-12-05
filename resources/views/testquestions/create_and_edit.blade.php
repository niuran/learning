@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    试题编辑
                </h2>

                <hr>

<form action="{{ route('testquestions.edithandle', $testpage->id) }}" method="POST" accept-charset="UTF-8">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $testpage->id }}">
<table class="table table-hover">
      <thead>
        <tr>
          <th>选择</th>
          <th>创建者</th>
          <th>类型</th>
          <th>题目</th>
          <th>选项</th>
          <th>答案</th>
          <th>排序</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($questions as $question)
        <tr>
          <th scope="row">
            {{ $loop->index }}
              @if($initial == 1)
              <input type="checkbox" name="choice[]" value="{{ $question->id }}" @if(in_array($question->id, $questions_choice)) checked @endif >
              @else
              <input type="checkbox" name="choice[]" value="{{ $question->id }}" >
              @endif
          </th>
          <td>{{ $question->userid }}</td>
          <td>
              @switch($question->type)
                @case('radio')
                  单选
                  @break
                @case('text')
                  填空
                  @break
                @case('checkbox')
                  多选
                  @break
                @case('textarea')
                  文章
                  @break
                @default
                  其他
              @endswitch
          </td>
          <td>{{ $question->title }}</td>
          <td>
            @if($question->content != 'null')
            {{ implode("， ", json_decode($question->content, true)) }}
            @else
            <span style="color:red;">无</span>
            @endif
          </td>
          <td>
            {{ $question->answer }}
          </td>
          <td>{{ $question->sort }}</td>

        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="well well-sm">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>

@endsection
