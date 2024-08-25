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
//        $this->authorizeResource(ProductLog::class);
    }

    public function index(): View
    {
        $productLogsArray = [];

        ProductLog::byCreator(Auth::user())->get()->sortByDesc('date')->map(function (ProductLog $productLog) use (&$productLogsArray) {
            return $productLogsArray[] = [
                'id'            => $productLog->id,
                'name' => $productLog->product->name,
                'grams' => $productLog->grams,
                'ww' => round($productLog->nutritionalValue->carbohydrates / 10, 1),
                'date' => $productLog->date->format(config('app.date_format')),
                'insulin_quantity' => $productLog->insulinLog->quantity,
                'sugar_before' => $productLog->sugarBefore->level,
                'sugar_after' => $productLog->sugarAfter->level
            ];
        });

        return $this->indexGeneral($productLogsArray);
    }

    public function indexGeneral(array $productLogsArray)
    {
        $actionIcons = [
            "icon:arrow-right-circle | color:green | click:redirect('/product-logs/{id}') | tip:Podgląd",
            "icon:pencil | click:redirect('/product-logs/{id}/edit') | tip:Edycja",
            "icon:trash | color:red | click:deleteProductLog('{id}') | tip:Usuń",
        ];
        $columnAliases = [
            'name' => 'Produkt',
            'grams' => 'Gramy',
            'ww' => 'WW',
            'date' => 'Data',
            'insulin_quantity' => 'Insulina (j.)',
            'sugar_before' => 'Cukier przed',
            'sugar_after' => 'Cukier po'
        ];

        return view('system.product_log.index')
            ->with('productLogs', $productLogsArray)
            ->with('actionIcons', $actionIcons)
            ->with('columnAliases', $columnAliases);
    }

    public function create(): View
    {
        return $this->form();

    }

    private function form(ProductLog $productLog = null): View
    {
        $insulinsArray = [];
        Insulin::byCreator(Auth::user())->get()->map(function (Insulin $insulin) use (&$insulinsArray) {
            return $insulinsArray[] = [
                'id' => $insulin->id,
                'name' => $insulin->name,
            ];
        });

        $productsArray = [];
        Product::all()->filter(function (Product $product) {
            return $product->created_by === Auth::user()->id || $product->created_by === null;
        })->map(function (Product $product) use (&$productsArray) {
            return $productsArray[] = [
                'id'            => $product->id,
                'name' => $product->name,
            ];
        });

        return view('system.product_log.form')
            ->with('productLog', $productLog)
            ->with('insulins', empty($insulinsArray) ? [['id' => '', 'name' => '']] : $insulinsArray)
            ->with('products', empty($productsArray) ? [['id' => '', 'name' => '']] : $productsArray);
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
        $productLogsArray = [];

        ProductLog::byCreator(Auth::user())->where('product_id', $product->id)->get()->sortByDesc('date')->map(function (ProductLog $productLog) use (&$productLogsArray) {
            return $productLogsArray[] = [
                'id'            => $productLog->id,
                'name' => $productLog->product->name,
                'grams' => $productLog->grams,
                'ww' => round($productLog->nutritionalValue->carbohydrates / 10, 1),
                'date' => $productLog->date->format(config('app.date_format')),
                'insulin_quantity' => $productLog->insulinLog->quantity,
                'sugar_before' => $productLog->sugarBefore->level,
                'sugar_after' => $productLog->sugarAfter->level
            ];
        });

        return $this->indexGeneral($productLogsArray);
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

    public function destroy(ProductLog $productLog, Request $request)
    {
        if ($productLog->delete()) {
            if ($request->ajax()) {
                return ['success' => true];
            }
        }

        return redirect(route('product-logs.index'));
    }
}
