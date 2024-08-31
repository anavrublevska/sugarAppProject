<?php

namespace App\Services;

use App\Models\NutritionalValue;
use App\Models\Product;
use App\Models\User;

class ProductService
{
    public function storeProduct(array $data, User $user): void
    {
        $product = new Product([
            'name'          => $data['name'],
            'carbohydrates' => $data['carbohydrates'],
            'proteins'      => $data['proteins'],
            'fats'          => $data['fats']
        ]);
        $product->creator()->associate($user);
        $product->save();
    }

    public function updateProduct(array $data, Product $product): void
    {
        $product->update([
            'name'          => $data['name'],
            'carbohydrates' => $data['carbohydrates'],
            'proteins'      => $data['proteins'],
            'fats'          => $data['fats']
        ]);
    }
}
