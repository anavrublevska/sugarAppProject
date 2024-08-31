<?php

namespace App\Services;

use App\Models\InsulinLog;
use App\Models\ProductLog;
use App\Models\SugarLog;
use App\Models\User;

class ProductLogService
{
    public function storeProductLog(array $data, User $user): void
    {
        $insulinLog = new InsulinLog([
            'quantity' => $data['quantity'],
            'date'     => $data['product_log_date'],
            'hour'     => $data['insulin_hour'],
        ]);
        $insulinLog->insulin()->associate($data['insulin_id']);
        $insulinLog->creator()->associate($user);
        $insulinLog->save();

        $sugarBeforeLog = new SugarLog([
            'level' => $data['sugar_before'],
            'date'  => $data['product_log_date'],
            'hour'  => $data['sugar_before_hour'],
        ]);
        $sugarBeforeLog->creator()->associate($user);
        $sugarBeforeLog->save();

        $sugarAfterLog = new SugarLog([
            'level' => $data['sugar_after'],
            'date'  => $data['product_log_date'],
            'hour'  => $data['sugar_after_hour'],
        ]);
        $sugarAfterLog->creator()->associate($user);
        $sugarAfterLog->save();

        $productLog = new ProductLog([
            'grams'         => $data['grams'],
            'carbohydrates' => $data['carbohydrates'],
            'proteins'      => $data['proteins'],
            'fats'          => $data['fats'],
            'date'          => $data['product_log_date'],
            'hour'          => $data['product_log_hour'],
            'comment'       => $data['comment']
        ]);
        $productLog->product()->associate($data['product_id']);
        $productLog->insulinLog()->associate($insulinLog);
        $productLog->sugarBefore()->associate($sugarBeforeLog);
        $productLog->sugarAfter()->associate($sugarAfterLog);
        $productLog->creator()->associate($user);
        $productLog->save();
    }

    public function updateProductLog(array $data, ProductLog $productLog): void
    {
        $productLog->insulinLog->update([
            'quantity' => $data['quantity'],
            'date'     => $data['product_log_date'],
            'hour'     => $data['insulin_hour']]);

        $productLog->sugarBefore->update([
            'level' => $data['sugar_before'],
            'date'  => $data['product_log_date'],
            'hour'  => $data['sugar_before_hour'],
        ]);

        $productLog->sugarAfter->update([
            'level' => $data['sugar_after'],
            'date'  => $data['product_log_date'],
            'hour'  => $data['sugar_after_hour'],
        ]);

        $productLog->update([
            'grams'         => $data['grams'],
            'carbohydrates' => $data['carbohydrates'],
            'proteins'      => $data['proteins'],
            'fats'          => $data['fats'],
            'date'          => $data['product_log_date'],
            'hour'          => $data['product_log_hour'],
            'comment'       => $data['comment']
        ]);
    }
}
