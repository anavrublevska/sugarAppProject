<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductLogRequest;
use App\Models\Insulin;
use App\Models\Product;
use App\Models\ProductLog;
use App\Services\ProductLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductLogController extends Controller
{
    public function __construct(private ProductLogService $productLogService)
    {
//        $this->authorizeResource(ProductLog::class);
    }

    public function index(): View
    {
        return view('system.product_log.index')
            ->with('productLogs', ProductLog::byCreator(Auth::user())->sortByDesc('created_at')->get());
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
            ->with('insulins', $insulins)
            ->with('products', $products);
    }

    public function store(ProductLogRequest $request): RedirectResponse
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
        $productLog->update($request->all());

        return redirect(route('products.index'));
    }

    public function delete(ProductLog $productLog): RedirectResponse
    {
        $productLog->delete();

        return redirect(route('products.index'));
    }
}
