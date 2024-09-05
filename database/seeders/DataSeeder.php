<?php

namespace Database\Seeders;

use App\Models\Insulin;
use App\Models\Traits\CreatorTrait;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    use CreatorTrait;

    public function run(): void
    {

        $products = [
            [
                'id' => 1,
                'name' => 'Kasza gryczana',
                'carbohydrates' => 56,
                'proteins' => 8.3,
                'fats' => 2.5
            ],
            [
                'id' => 2,
                'name' => 'Pizza margherita',
                'carbohydrates' => 33,
                'proteins' => 11,
                'fats' => 10
            ],
            [
                'id' => 3,
                'name' => 'Kajzerka',
                'carbohydrates' => 56,
                'proteins' => 8.3,
                'fats' => 2.5
            ],
            [
                'id' => 4,
                'name' => 'Sałatka Cezar z kurczakiem',
                'carbohydrates' => 4.4,
                'proteins' => 12.6,
                'fats' => 8.2
            ],
            [
                'id' => 5,
                'name' => 'Mleko 3.2%',
                'carbohydrates' => 4.7,
                'proteins' => 3.2,
                'fats' => 3.2
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }

        $user1 = new User([
            'name' => 'Użytkownik',
            'email' => 'test@gmail.com',
            'password' => '11pU8ki0',
        ]);
        $user1->save();


        $user2 = new User([
            'name' => 'Anastazja',
            'email' => 'anastazjatest@gmail.com',
            'password' => 'to6D3br3',
        ]);
        $user2->save();

        $insulins =[
            [
                'id' => 1,
                'name' => 'Novorapid',
                'created_by' => 1
            ],
            [
                'id' => 2,
                'name' => 'Novorapid',
                'created_by' => 2
            ],
        ];

        foreach ($insulins as $insulin) {
            DB::table('insulins')->insert($insulin);
        }

        $sugarLogs = [
            [
                'id' => 1,
                'level' => 123,
                'date' => '2024-08-04',
                'hour' => '12:00',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'level' => 128,
                'date' => '2024-08-04',
                'hour' => '14:00',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'level' => 105,
                'date' => '2024-08-05',
                'hour' => '13:15',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'level' => 167,
                'date' => '2024-08-05',
                'hour' => '15:00',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ]
        ];

        foreach ($sugarLogs as $sugarLog) {
            DB::table('sugar_logs')->insert($sugarLog);
        }

        $insulinLogs = [
            [
                'id' => 1,
                'insulin_id' => 1,
                'quantity' => 2,
                'date' => '2024-08-04',
                'hour' => '12:00',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'insulin_id' => 1,
                'quantity' => 7,
                'date' => '2024-08-05',
                'hour' => '13:30',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ]
        ];

        foreach ($insulinLogs as $insulinLog) {
            DB::table('insulin_logs')->insert($insulinLog);
        }

        $productLogs = [
            [
                'id' => 1,
                'product_id' => 4,
                'sugar_before_id' => 1,
                'sugar_after_id' => 2,
                'insulin_log_id' => 1,
                'grams' => 150,
                'carbohydrates' => 6.6,
                'proteins' => 18.9,
                'fats' => 12.3,
                'date' => '2024-08-04',
                'hour' => '12:10',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'sugar_before_id' => 3,
                'sugar_after_id' => 4,
                'insulin_log_id' => 2,
                'grams' => 150,
                'carbohydrates' => 49.5,
                'proteins' => 16.5,
                'fats' => 15,
                'date' => '2024-08-05',
                'hour' => '13:30',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ]
        ];

        foreach ($productLogs as $productLog) {
            DB::table('product_logs')->insert($productLog);
        }
    }
}
