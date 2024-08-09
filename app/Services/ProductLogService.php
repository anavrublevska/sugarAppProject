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
            'date'     => $data['product_log_date']->format(config('app.hour_format')),
            'hour'     => $data['insulin_hour']->format(config('app.hour_format')),
        ]);
        $insulinLog->insulin()->associate($data['insulin_id']);
        $insulinLog->creator()->associate($user);
        $insulinLog->save();

        $sugarBeforeLog = new SugarLog([
            'level' => $data['sugar_before'],
            'date'  => $data['product_log_date']->format(config('app.hour_format')),
            'hour'  => $data['sugar_before_hour']->format(config('app.hour_format')),
        ]);
        $sugarBeforeLog->creator()->associate($user);
        $sugarBeforeLog->save();

        $sugarAfterLog = new SugarLog([
            'level' => $data['sugar_after'],
            'date'  => $data['product_log_date']->format(config('app.hour_format')),
            'hour'  => $data['sugar_after_hour']->format(config('app.hour_format')),
        ]);
        $sugarAfterLog->creator()->associate($user);
        $sugarAfterLog->save();

        $productLog = new ProductLog([
            'grams'         => $data['grams'],
            'carbohydrates' => $data['carbohydrates'],
            'proteins'      => $data['proteins'],
            'fats'          => $data['fats'],
            'date'          => $data['product_log_date']->format(config('app.hour_format')),
            'hour'          => $data['product_log_hour']->format(config('app.hour_format')),
            'comment'       => $data['comment']
        ]);
        $productLog->product()->associate($data['product_id']);
        $productLog->insulinLog()->associate($insulinLog);
        $productLog->sugarBefore()->associate($sugarBeforeLog);
        $productLog->sugarAfter()->associate($sugarAfterLog);
        $productLog->creator()->associate($user);
        $productLog->save();
    }
}
