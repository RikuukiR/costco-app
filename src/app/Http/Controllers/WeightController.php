<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeightController extends Controller
{
    public function index()
    {
        return view('weights.index');
    }

    public function create()
    {
        return view('weights.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('weights.index');
    }

    public function show($id)
    {
        return view('weights.show');
    }

    public function edit($id)
    {
        return view('weights.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('weights.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('weights.index');
    }
}
