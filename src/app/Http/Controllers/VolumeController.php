<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function index()
    {
        return view('volumes.index');
    }

    public function create()
    {
        return view('volumes.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('volumes.index');
    }

    public function show($id)
    {
        return view('volumes.show');
    }

    public function edit($id)
    {
        return view('volumes.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('volumes.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('volumes.index');
    }
}
