<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        $employees = User::whereNotNull('horario_entrada')
            ->orderBy('name')
            ->take(6)
            ->get();
            
        $alerts = Alert::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('movements', 'employees', 'alerts'));
    }
}
