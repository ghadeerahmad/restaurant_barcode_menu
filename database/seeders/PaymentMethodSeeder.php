<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->truncate();
        DB::table('payment_methods')->insert([
            [
                'title_ar'=>'حوالة بالهرم',
                'title_en'=>'Haram transfere',
                'description_ar'=>'يرجى إرفاق صورة الإشعار',
                'description_en'=>'Please attach the transfere notice image',
            ]
        ]);
    }
}
