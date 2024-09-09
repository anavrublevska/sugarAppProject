<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $actionIcons = [
            "icon:calendar-days | color:green | click:productHistory('{id}') | tip:Zobacz historię produktu",
            "icon:pencil | click:editProduct('{id}') | tip:Edycja",
            "icon:trash | color:red | click:deleteProduct('{id}', '{name}') | tip:Usuń",
        ];
        $columnAliases = [
            'name' => 'Nazwa',
            'carbohydrates' => 'Węglowodany',
            'proteins' => 'Białko',
            'fats' => 'Tłuszcz'
        ];

        $productsArray = [];

         Product::byCreator(Auth::user())->get()->map(function (Product $product) use (&$productsArray) {
            return $productsArray[] = [
                'id'            => $product->id,
                'name'          => $product->name,
                'carbohydrates' => $product->carbohydrates,
                'proteins'      => $product->proteins,
                'fats'          => $product->fats
            ];
        });

        return view('system.product.index')
            ->with('products', $productsArray)
            ->with('actionIcons', $actionIcons)
            ->with('columnAliases', $columnAliases);
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

    public function edit(Product $product): View
    {
        return $this->form($product);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProduct($request->all(), $product);

        return redirect(route('products.index'));
    }

    public function destroy(Product $product, Request $request)
    {
        if ($product->delete()) {
            if ($request->ajax()) {
                return ['success' => true];
            }
        }

        return redirect(route('products.index'));
    }
}
