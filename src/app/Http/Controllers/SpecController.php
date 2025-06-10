<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecController extends Controller
{
    public function index()
    {
        return view('specs.index');
    }

    public function create()
    {
        return view('specs.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('specs.index');
    }

    public function show($id)
    {
        return view('specs.show');
    }

    public function edit($id)
    {
        return view('specs.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('specs.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('specs.index');
    }
}
