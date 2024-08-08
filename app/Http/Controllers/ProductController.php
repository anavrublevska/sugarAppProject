<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('system.product.index')
            ->with('products', Product::byCreator(Auth::user())->get());
    }

    public function create(): View
    {
        return $this->form();
    }

    private function form(Product $product = null): View
    {
        return view('system.product.form')
            ->with('product', $product);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = new Product($request->all());
        $product->creator()->associate(Auth::user());
        $product->save();

        return redirect(route('products.index'));
    }

    public function show()
    {

    }

    public function edit(Product $product): View
    {
        return $this->form($product);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($request->all());

        return redirect(route('products.index'));
    }

    public function delete(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect(route('products.index'));
    }
}
