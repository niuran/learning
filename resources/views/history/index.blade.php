@extends('layouts.app')

@section('title', '测试历史')

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-3 sidebar">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="" class="btn btn-success btn-block" aria-label="Left Align">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建测试
            </a>
        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 history-list">

        <div class="panel panel-default">

            <div class="panel-heading">
                测试列表
            </div>

            <div class="panel-body">
                {{-- 测试历史 列表 --}}
@if (count($usertests))

<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>试卷名</th>
          <th>测试者</th>
          <th>测试情况</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($usertests as $usertest)
        <tr>
          <th scope="row">{{ $usertest->id}}</th>
          <td>{{ $usertest->testpageid }}</td>
          <td>{{ $usertest->userid }}</td>
          <td>{{ $usertest->result }}</td>
          <td>
            <form action="{{ route('history.destroy', $usertest->id) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <a class="btn btn-primary" href="{{ route('history.show', $usertest->id) }}">查看</a>
                  <button onclick="return confirm('确定删除？')" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>删除</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif
                {{-- 分页 --}}
                {!! $usertests->render() !!}
            </div>
        </div>
    </div>


</div>

@endsection
