@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($testpage->id)
                        编辑测试
                    @else
                        新建测试
                    @endif
                </h2>

                <hr>

                @include('common.error')

                @if($testpage->id)
                    <form action="{{ route('testpages.update', $testpage->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('testpages.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input class="form-control" type="text" name="name" value="{{ old('name', $testpage->name ) }}" placeholder="请填写测试名称" required/>
                    </div>

                    <input type="hidden" name="userid" value="{{ Auth::id() }}">

                    <div class="form-group">
                        <input class="form-control" type="text" name="sort" value="{{ old('sort', $testpage->sort ) }}" placeholder="整数，越小显示越靠前"/>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="comment" rows="3" placeholder="备注">{{ old('comment', $testpage->comment ) }}</textarea>
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
