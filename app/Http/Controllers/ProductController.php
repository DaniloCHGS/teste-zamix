<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Listagem de produtos simples
    public function simpleIndex()
    {
        $products = Product::where('type', 'simple')->paginate(10);
        return view('admin.products.simple.index', compact('products'));
    }

    // Formulário de cadastro
    public function simpleCreate()
    {
        return view('admin.products.simple.create');
    }

    // Armazena novo produto
    public function simpleStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            'cost_price.required' => 'O preço de custo é obrigatório.',
            'cost_price.numeric' => 'O preço de custo deve ser um número.',
            'cost_price.min' => 'O preço de custo deve ser zero ou maior.',
            'sale_price.required' => 'O preço de venda é obrigatório.',
            'sale_price.numeric' => 'O preço de venda deve ser um número.',
            'sale_price.min' => 'O preço de venda deve ser zero ou maior.',
        ]);

        Product::create([
            'name' => $request->name,
            'type' => 'simple',
            'cost_price' => $request->cost_price,
            'sale_price' => $request->sale_price,
        ]);

        return redirect()->route('products.simple.index')->with('success', 'Produto criado com sucesso!');
    }

    // Formulário de edição
    public function simpleEdit(Product $product)
    {
        return view('admin.products.simple.edit', compact('product'));
    }

    // Atualiza produto
    public function simpleUpdate(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            'cost_price.required' => 'O preço de custo é obrigatório.',
            'cost_price.numeric' => 'O preço de custo deve ser um número.',
            'cost_price.min' => 'O preço de custo deve ser zero ou maior.',
            'sale_price.required' => 'O preço de venda é obrigatório.',
            'sale_price.numeric' => 'O preço de venda deve ser um número.',
            'sale_price.min' => 'O preço de venda deve ser zero ou maior.',
        ]);

        $product->update([
            'name' => $request->name,
            'cost_price' => $request->cost_price,
            'sale_price' => $request->sale_price,
        ]);

        return redirect()->route('products.simple.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Formulário de exclusão
    public function simpleDelete(Product $product)
    {
        return view('admin.products.simple.delete', compact('product'));
    }

    // Exclui produto
    public function simpleDestroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.simple.index')->with('success', 'Produto excluído com sucesso!');
    }
}
