<?php

namespace App\Http\Controllers;

use App\Models\Alert;
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
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sector', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('name')->paginate(15)->withQueryString();

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
            'min_quantity' => 'nullable|integer|min:0',
        ]);

        $quantity = $validated['quantity'] ?? 0;
        $minQuantity = $validated['min_quantity'] ?? 5;
        
        DB::transaction(function () use ($validated, $quantity, $minQuantity) {
            $product = Product::create([
                'name' => $validated['name'],
                'brand' => $validated['brand'],
                'sector' => $validated['sector'],
                'quantity' => $quantity,
                'min_quantity' => $minQuantity,
            ]);

            if ($quantity > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'in',
                    'quantity_changed' => $quantity,
                    'notes' => 'Estoque inicial no cadastro',
                ]);
            }
        });

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Product $product)
    {
        $movements = $product->stockMovements()->with('user')->orderBy('created_at', 'desc')->take(20)->get();
        return view('products.manage', compact('product', 'movements'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'min_quantity' => 'required|integer|min:0',
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
            'notes' => 'nullable|string|max:255',
        ]);

        $quantity = $validated['quantity'];
        $type = $validated['type'];
        $notes = $validated['notes'] ?? null;

        $insufficient = false;

        DB::transaction(function () use ($product, $quantity, $type, $notes, &$insufficient) {
            $lockedProduct = Product::where('id', $product->id)->lockForUpdate()->firstOrFail();

            if ($type === 'out' && $lockedProduct->quantity < $quantity) {
                $insufficient = true;
                return;
            }

            $lockedProduct->quantity = $type === 'in'
                ? $lockedProduct->quantity + $quantity
                : $lockedProduct->quantity - $quantity;
            $lockedProduct->save();

            StockMovement::create([
                'product_id' => $lockedProduct->id,
                'user_id' => auth()->id(),
                'type' => $type,
                'quantity_changed' => $quantity,
                'notes' => $notes,
            ]);

            if ($type === 'out' && $lockedProduct->quantity <= $lockedProduct->min_quantity) {
                $alertMessage = "Produto {$lockedProduct->name} está com estoque baixo ({$lockedProduct->quantity} un).";
                Alert::firstOrCreate(
                    ['message' => $alertMessage],
                    ['type' => 'warning']
                );
            }
        });

        if ($insufficient) {
            return back()->withErrors(['quantity' => 'Estoque insuficiente para esta saída.'])->with('error', 'Estoque insuficiente para esta saída.');
        }

        return back()->with('success', 'Estoque ajustado com sucesso!');
    }
}
