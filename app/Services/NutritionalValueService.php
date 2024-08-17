<?php

namespace App\Services;

use App\Models\NutritionalValue;

class NutritionalValueService
{
    public function storeOrUpdateNutritionalValue(array $data, NutritionalValue $nutritionalValue = null): NutritionalValue
    {
        if (! $nutritionalValue) {
            $newNutritionalValue = new NutritionalValue(['carbohydrates' => $data['carbohydrates'], 'proteins' => $data['proteins'], 'fats' => $data['fats']]);
            $newNutritionalValue->save();
        } else {
            $newNutritionalValue = $nutritionalValue->update($data);
        }

        return $newNutritionalValue;
    }
}
