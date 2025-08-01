<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;
use App\Http\Requests\StoreStockEntryRequest;
use App\Http\Requests\StoreStockExitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function createEntrada()
    {
        $products = Product::all(); // Ou apenas produtos simples, dependendo da sua lógica
        return view('admin.stock_movements.entrada', compact('products'));
    }

    public function storeEntrada(StoreStockEntryRequest $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        // Atualiza o estoque
        $stock = Stock::firstOrCreate(['product_id' => $product_id]);
        $stock->quantity += $quantity;
        $stock->save();

        // Registra a movimentação
        StockMovement::create([
            'product_id' => $product_id,
            'user_id' => Auth::id(),
            'type' => 'entrada',
            'quantity' => $quantity,
        ]);

        return redirect()->route('stock_movements.historico')->with('success', 'Entrada de estoque registrada com sucesso!');
    }

    public function createSaida()
    {
        $products = Product::all(); // Ou apenas produtos simples
        return view('admin.stock_movements.saida', compact('products'));
    }

    public function storeSaida(StoreStockExitRequest $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $stock = Stock::where('product_id', $product_id)->first();

        // A validação de estoque suficiente já é feita no StoreStockExitRequest
        $stock->quantity -= $quantity;
        $stock->save();

        // Registra a movimentação
        StockMovement::create([
            'product_id' => $product_id,
            'user_id' => Auth::id(),
            'type' => 'saida',
            'quantity' => $quantity,
        ]);

        return redirect()->route('stock_movements.historico')->with('success', 'Saída de estoque registrada com sucesso!');
    }

    public function historico(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $stockMovements = $query->orderBy('created_at', 'desc')->get();
        $products = Product::all(); // Para o filtro

        return view('admin.stock_movements.historico', compact('stockMovements', 'products'));
    }
}
