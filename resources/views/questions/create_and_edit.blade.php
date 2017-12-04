@extends('layouts.app')

@section('script-include')
<script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
@endsection

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($question->id)
                        编辑题目
                    @else
                        新建题目
                    @endif
                </h2>

                <hr>

                @include('common.error')

                @if($question->id)
                    <form action="{{ route('questions.update', $question->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('questions.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="userid" value="{{ Auth::id() }}">

                    <div class="form-group">
                        <select class="form-control" name="type" id="type">
                            <option value="text" @if(old('type', $question->type) == 'text') selected @endif>填空</option>
                            <option value="radio" @if(old('type', $question->type) == 'radio') selected @endif>单选</option>
                            <option value="checkbox" @if(old('type', $question->type) == 'checkbox') selected @endif>多选</option>
                            <option value="textarea" @if(old('type', $question->type) == 'textarea') selected @endif>文章</option>
                        </select>
                    </div>

                    <div class="form-group">
                            <input class="form-control" type="text" name="title" value="{{ old('title', $question->title ) }}" placeholder="请填写题目内容" required/>
                    </div>

                    <div class="form-group operating">
            					<label for="answer" class="col-md-2 control-label">选项</label>
            					<div class="col-md-6" id="answer">

            					</div>
            					<div class="col-md-2">
            						<a href="javascript:void (0);" class="btn btn-sm btn-success item_add"><i
            									class="fa fa-plus"></i>
            							添加一项</a>
            						<a href="javascript:void (0);" class="btn btn-sm btn-danger item_remove"><i
            									class="fa fa-times"></i>
            							删除一项</a>

            					</div>
            				</div>




                    <div class="form-group" id="textanswer">
                        <input class="form-control" type="text" name="textanswer" value="{{ old('textanswer', $question->textanswer ) }}" placeholder="请填写答案"/>
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" name="sort" value="{{ old('sort', $question->sort ) }}" placeholder="请填写排序，越小越靠前"/>
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
		.input-group {
			margin-bottom: 10px;
		}
	</style>

@endsection


@section('script')
<script>
var type = 'text';
var count = 0;
$('#type').on('change', function () {
    type = $(this).val();
    answer_write();
});
answer_write();

// 写答案
function answer_write() {
    var str = '';
    if (type == 'radio') {
        str = '<div class="input-group"><div class="input-group-addon">选项1<\/div><input type="text" class="form-control form-filter" name="content[]" value="" ><input type="radio" name="answer" value="1">设为正确答案<\/div><div class="input-group"><div class="input-group-addon">选项2<\/div><input type="text" class="form-control form-filter" name="content[]" value="" ><input type="radio" name="answer" value="2">设为正确答案<\/div>'
        $('.operating').show();
        $('#textanswer').hide();
        count = 2;
    } else if (type == 'checkbox') {
        str = '<div class="input-group"><div class="input-group-addon">选项1<\/div><input type="text" class="form-control form-filter" name="content[]" value="" ><input type="checkbox" name="answer[]" value="1">设为正确答案<\/div><div class="input-group"><div class="input-group-addon">选项2<\/div><input type="text" class="form-control form-filter" name="content[]" value="" ><input type="checkbox" name="answer[]" value="2">设为正确答案<\/div>'
        $('.operating').show();
        $('#textanswer').hide();
        count = 2;
    } else {
        count = 0;
        $('.operating').hide();
        $('#textanswer').show();
    }
    $('#answer').html(str);
}

// 添加一项
$('.item_add').on('click', function () {
    if (type == 'radio') {
      $('#answer').append('<div class="input-group"><div class="input-group-addon">选项' + (count + 1) + '<\/div><input type="text" class="form-control form-filter" name="content[]" value="" ><input type="radio" name="answer" value="' + (count + 1) + '">设为正确答案<\/div>');
    } else{
      $('#answer').append('<div class="input-group"><div class="input-group-addon">选项' + (count + 1) + '<\/div><input type="text" class="form-control form-filter" name="content[]" value="" ><input type="checkbox" name="answer[]" value="' + (count + 1) + '">设为正确答案<\/div>');
    }
    count += 1;
});

$('.item_remove').on('click', function () {
    if (count > 2) {
      $('.input-group').eq(count - 1).remove();
      count --;
    } else {
      alert('最少保留两项');
    }


});

</script>
@endsection
