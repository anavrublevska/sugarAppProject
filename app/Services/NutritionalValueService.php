<?php

namespace App\Services;

use App\Models\NutritionalValue;

class NutritionalValueService
{
    public function storeOrUpdateNutritionalValue(array $data, NutritionalValue $nutritionalValue = null): NutritionalValue
    {
        if (! $nutritionalValue) {
            $nutritionalValue = new NutritionalValue(['carbohydrates' => $data['carbohydrates'], 'proteins' => $data['proteins'], 'fats' => $data['fats']]);
            $nutritionalValue->save();
        } else {
           $nutritionalValue->update($data);
        }

        return $nutritionalValue;
    }
}
