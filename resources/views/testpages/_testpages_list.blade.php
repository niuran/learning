@if (count($testpages))

<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>创建者</th>
          <th>测试名</th>
          <th>排序</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($testpages as $testpage)
        <tr>
          <th scope="row">{{ $testpage->id}}</th>
          <td>{{ $testpage->userid }}</td>
          <td>{{ $testpage->name }}</td>
          <td>{{ $testpage->sort }}</td>
          <td>
            <a href="{{ route('testpages.edit', $testpage->id) }}">编辑</a>
            <a href="{{ route('testpages.destroy', $testpage->id) }}">删除</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif
