<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sector', 'like', "%{$search}%");
        }

        $products = $query->orderBy('name')->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.manage');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $quantity = $validated['quantity'] ?? 0;
        
        DB::transaction(function () use ($validated, $quantity) {
            $product = Product::create([
                'name' => $validated['name'],
                'brand' => $validated['brand'],
                'sector' => $validated['sector'],
                'quantity' => $quantity,
            ]);

            if ($quantity > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity_changed' => $quantity,
                ]);
            }
        });

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Product $product)
    {
        $movements = $product->stockMovements()->orderBy('created_at', 'desc')->take(20)->get();
        return view('products.manage', compact('product', 'movements'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
        ]);

        $product->update($validated);

        return redirect()->route('products.edit', $product)->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $validated['quantity'];
        $type = $validated['type'];

        if ($type === 'out' && $product->quantity < $quantity) {
            return back()->withErrors(['quantity' => 'Estoque insuficiente para esta saída.']);
        }

        DB::transaction(function () use ($product, $quantity, $type) {
            $product->quantity = $type === 'in' ? $product->quantity + $quantity : $product->quantity - $quantity;
            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'type' => $type,
                'quantity_changed' => $quantity,
            ]);
        });

        return redirect()->route('products.edit', $product)->with('success', 'Estoque ajustado com sucesso!');
    }
}
