<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isManagerOrAdmin = in_array($user->nivel_acesso, ['Admin', 'Gerente'], true);

        $tickets = SupportTicket::with('user')
            ->when(!$isManagerOrAdmin, fn ($q) => $q->where('user_id', $user->id))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('support.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support', 'public');
        }

        SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'attachment_path' => $attachmentPath,
            'status' => 'aberto',
        ]);

        return redirect()->route('support.index')->with('success', 'Chamado registrado com sucesso! Nossa equipe técnica responderá em breve.');
    }

    public function resolve(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'resolvido']);

        return redirect()->route('support.index')->with('success', 'Chamado marcado como resolvido!');
    }
}
