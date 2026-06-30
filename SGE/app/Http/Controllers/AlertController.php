<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'type' => 'required|in:danger,warning,info',
        ]);

        Alert::create($request->all());

        return back()->with('success', 'Aviso criado com sucesso.');
    }

    public function destroy(Alert $alert)
    {
        $alert->delete();

        return back()->with('success', 'Aviso removido com sucesso.');
    }
}
