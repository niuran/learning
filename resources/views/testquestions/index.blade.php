@extends('layouts.app')

@section('title', '测试列表')

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-3 sidebar">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('testquestions.edit', $testpage->id) }}" class="btn btn-success btn-block" aria-label="Left Align">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 试题编辑
            </a>
        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 testpages-list">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h2 class="text-center"><i class="glyphicon glyphicon-edit"></i>{{ $testpage->name }}-试题管理</h2>
            </div>

            <div class="panel-body">
                {{-- 试题列表 --}}
                @include('testquestions._testquestions_list', ['questions' => $questions])
                {{-- 分页 --}}
                
                
            </div>
        </div>
    </div>


</div>

@endsection
