<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('schedules.index');
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('schedules.index');
    }

    public function show($id)
    {
        return view('schedules.show');
    }

    public function edit($id)
    {
        return view('schedules.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('schedules.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('schedules.index');
    }
}
