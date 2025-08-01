<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCompositeController extends Controller
{
    public function index()
    {
        $compositeProducts = Product::where('type', 'composite')->with('components')->get();
        return view('admin.products.composite.index', compact('compositeProducts'));
    }

    public function create()
    {
        $simpleProducts = Product::where('type', 'simple')->get();
        return view('admin.products.composite.create', compact('simpleProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sale_price' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id,type,simple',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Selecione ao menos um componente.',
        ]);

        // dd($request->all());

        DB::transaction(function () use ($request) {
            $compositeProduct = Product::create([
                'name' => $request->name,
                'sale_price' => $request->sale_price,
                'type' => 'composite',
            ]);

            // dd($compositeProduct->toarray());

            foreach ($request->items as $item) {
                if (isset($item['id'])) {
                    ProductComponent::create([
                        'product_id' => $compositeProduct->id,
                        'component_id' => $item['id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }
        });

        return redirect()->route('products.composite.index')->with('success', 'Produto composto cadastrado com sucesso!');
    }

    public function edit(Product $product)
    {
        $product->load('components');
        $simpleProducts = Product::where('type', 'simple')->get();

        // Cria um array associativo [component_id => quantity] para fácil acesso na view
        $selectedComponents = $product->components->pluck('pivot.quantity', 'id')->all();

        return view('admin.products.composite.edit', compact('product', 'simpleProducts', 'selectedComponents'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sale_price' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id,type,simple',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Selecione ao menos um componente.',
        ]);

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'name' => $request->name,
                'sale_price' => $request->sale_price,
            ]);

            $product->components()->sync(collect($request->items)->mapWithKeys(function ($item) {
                return [$item['id'] => ['quantity' => $item['quantity']]];
            }));
        });

        return redirect()->route('products.composite.index')->with('success', 'Produto composto atualizado com sucesso!');
    }

    public function delete(Product $product)
    {
        return view('admin.products.composite.delete', compact('product'));
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->components()->delete();
            $product->delete();
        });

        return redirect()->route('products.composite.index')->with('success', 'Produto composto excluído com sucesso!');
    }
}
