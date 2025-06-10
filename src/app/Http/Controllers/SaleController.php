<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('sales.index');
    }

    public function show($id)
    {
        return view('sales.show');
    }

    public function edit($id)
    {
        return view('sales.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('sales.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('sales.index');
    }
}
