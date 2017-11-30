<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testpages;
use Auth;

class TestpagesController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', ['except' => ['index']]);
  }

    public function index(Testpages $testpage)
    {
        $testpages = $testpage->orderBy('sort')->paginate(20);
        return view('testpages.index', compact('testpages'));
    }

  public function create(Testpages $testpage)
  {
    return view('testpages.create_and_edit', compact('testpage'));
  }

  public function store(Request $request, Testpages $testpage)
  {
        $testpage->fill($request->all());
        // dd($testpage);
        $testpage->save();

        return redirect()->route('testpages.index')->with('message', '成功创建测试！');
  }

  public function edit(Testpages $testpage)
  {
        return view('testpages.create_and_edit', compact('testpage'));
  }

  public function update(Request $request, Testpages $testpage)
  {
    $testpage->update($request->all());

    return redirect()->route('testpages.index')->with('message', '更新成功！');
  }

  public function destroy(Testpages $testpages)
  {
    $testpages->delete();

    return redirect()->route('testpages.index')->with('message', '成功删除！');
  }

}
