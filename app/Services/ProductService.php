<?php

namespace App\Services;

use App\Models\NutritionalValue;
use App\Models\Product;
use App\Models\User;

class ProductService
{
    public function storeProduct(array $data, User $user): void
    {
        $nutritionalValue = resolve(NutritionalValueService::class)->storeOrUpdateNutritionalValue($data);
        $product = new Product(['name' => $data['name']]);
        $product->nutritionalValue()->associate($nutritionalValue);
        $product->creator()->associate($user);
        $product->save();
    }

    public function updateProduct(array $data, Product $product): void
    {
        resolve(NutritionalValueService::class)->storeOrUpdateNutritionalValue($data, $product->nutritionalValue);
        $product->update(['name' => $data['name']]);
    }
}
