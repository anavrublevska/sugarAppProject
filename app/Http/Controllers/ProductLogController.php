<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductLogRequest;
use App\Models\Insulin;
use App\Models\Product;
use App\Models\ProductLog;
use App\Services\ProductLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductLogController extends Controller
{
    public function __construct(private ProductLogService $productLogService)
    {
        $this->authorizeResource(ProductLog::class);
    }

    public function index(): View
    {
        return view('system.product_log.index')
            ->with('productLogs', ProductLog::byCreator(Auth::user())->get()->sortByDesc('created_at'));
    }

    public function create(): View
    {
        return $this->form();

    }

    private function form(ProductLog $productLog = null): View
    {
        $insulins = Insulin::byCreator(Auth::user())->get()->mapWithKeys(function ($item) {
            return [['id' => $item['id'], 'name' => $item['name']]];
        })->toArray();

        $products =  Product::byCreator(Auth::user())->get()->mapWithKeys(function ($item) {
            return [['id' => $item['id'], 'name' => $item['name']]];
        })->toArray();

        return view('system.product_log.form')
            ->with('productLog', $productLog)
            ->with('insulins', empty($insulins) ? [['id' => '', 'name' => '']] : $insulins)
            ->with('products', empty($products) ? [['id' => '', 'name' => '']] : $products);
    }

    public function calculateNutritionValue(Request $request): JsonResponse
    {
        $product = Product::find($request->input('productId'));
        $grams = (int) $request->input('grams');

        return response()->json([
            'carbohydrates' => (int) ($product->nutritionalValue->carbohydrates * $grams) / 100,
            'proteins' => (int) ($product->nutritionalValue->proteins * $grams) / 100,
            'fats' => (int) ($product->nutritionalValue->fats * $grams) / 100,
        ]);
    }
    public function productHistory(Product $product)
    {
        return 'a';
    }

    public function store(Request $request): RedirectResponse
    {
        $this->productLogService->storeProductLog($request->all(), Auth::user());

        return redirect(route('product-logs.index'));
    }

    public function show(ProductLog $productLog)
    {
        return view('system.product_log.show')
            ->with('productLog', $productLog);
    }

    public function edit(ProductLog $productLog): View
    {
        return $this->form($productLog);

    }

    public function update(ProductLogRequest $request, ProductLog $productLog): RedirectResponse
    {
        $this->productLogService->updateProductLog($request->all(), $productLog);

        return redirect(route('product-logs.index'));
    }

    public function delete(ProductLog $productLog): RedirectResponse
    {
        $productLog->delete();

        return redirect(route('product-logs.index'));
    }
}
