@extends('layouts.app')

@section('title', '题目列表')

@section('content')

<div class="row">
    <div class="col-lg-9 col-md-9 questions-list">

        <div class="panel panel-default">

            <div class="panel-heading">
                题目列表
            </div>

            <div class="panel-body">
                {{-- 题目列表 --}}
                @include('questions._questions_list', ['questions' => $questions])
                {{-- 分页 --}}
                {!! $questions->render() !!}
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 sidebar">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('questions.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建题目
            </a>
        </div>
      </div>
    </div>
</div>

@endsection
