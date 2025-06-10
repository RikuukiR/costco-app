<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function index()
    {
        return view('destroys.index');
    }

    public function create()
    {
        return view('destroys.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('destroys.index');
    }

    public function show($id)
    {
        return view('destroys.show');
    }

    public function edit($id)
    {
        return view('destroys.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('destroys.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('destroys.index');
    }
}
