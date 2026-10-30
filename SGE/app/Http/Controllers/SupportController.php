<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        return redirect()->route('support.index')->with('success', 'Chamado registrado com sucesso! Nossa equipe técnica responderá em breve.');
    }
}
