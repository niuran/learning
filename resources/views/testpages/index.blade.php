@extends('layouts.app')

@section('title', '测试列表')

@section('content')

<div class="row">
    <div class="col-lg-9 col-md-9 testpages-list">

        <div class="panel panel-default">

            <div class="panel-heading">
                测试列表
            </div>

            <div class="panel-body">
                {{-- 测试列表 --}}
                @include('testpages._testpages_list', ['testpages' => $testpages])
                {{-- 分页 --}}
                {!! $testpages->render() !!}
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 sidebar">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('testpages.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建测试
            </a>
        </div>
      </div>
    </div>
</div>

@endsection
