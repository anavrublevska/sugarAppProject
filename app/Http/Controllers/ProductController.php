<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        $this->authorizeResource(Product::class);
    }
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

    public function store(ProductRequest $request): RedirectResponse
    {
        $this->productService->storeProduct($request->all(), Auth::user());

        return redirect(route('products.index'));
    }

    public function show()
    {

    }

    public function edit(Product $product): View
    {
        return $this->form($product);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProduct($request->all(), $product);

        return redirect(route('products.index'));
    }

    public function delete(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect(route('products.index'));
    }
}
