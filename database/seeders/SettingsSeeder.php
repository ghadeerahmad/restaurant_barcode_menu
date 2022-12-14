<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            0 =>
            array(
                'key' => 'IsStripePaymentEnabled',
                'value' => '1',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            2 =>
            array(
                'key' => 'StripePublishableKey',
                'value' => 'pk_test_FkQvi0DNueKlNnVwNoJktg2W',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            3 =>
            array(
                'key' => 'StripeSecretKey',
                'value' => 'sk_test_hPRNV2gZ6gcIV99ndFejwEHT',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            4 =>
            array(
                'key' => 'IsSandBoxEnabled',
                'value' => '1',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),

            5 =>
            array(
                'key' => 'PhoneCode',
                'value' => '+14155238886',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            6 =>
            array(
                'key' => 'SandBoxID',
                'value' => 'AC6122b6aa2b2e8e1145fd160a5b33a897',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            7 =>
            array(
                'key' => 'SandBoxToken',
                'value' => 'a2159a513c58ba5101496a8192b3c959',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            8 =>
            array(
                'key' => 'IsStoreEnabled',
                'value' => '1',
                'created_at' => '2020-10-06 21:52:30',
                'updated_at' => '2020-10-06 21:52:30',
            ),
            9 =>
            array(
                'key' => 'SandboxTrialText',
                'value' => 'join tongue-getting',
                'created_at' => '2020-10-06 21:52:30',
                'updated_at' => '2020-10-06 21:52:30',
            ),
            10 =>
            array(
                'key' => 'PrivacyPolicy',
                'value' => 'sample privacy policy text',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            11 =>
            array(
                'key' => 'IsPaypalPaymentEnabled',
                'value' => '0',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),

            12 =>
            array(
                'key' => 'PaypalMode',
                'value' => 'sandbox',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            13 =>
            array(
                'key' => 'PaypalKeyId',
                'value' => 'ATdi05eky96suWs5N89MQJRe_2zLXbD23bqe8nRW9CHp2vsgjKOZyRMnX2GEchcW1kintCP3qcZlT1Kg',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            14 =>
            array(
                'key' => 'PaypalKeySecret',
                'value' => 'EELzZmGlv2l8veRcQCDac59uRI8xhGjeKfXgjY_URpt0HaoEjHmjAceUxMO83F8M5MSu-D4DqZrTmF9X',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            15 => array(
                'key' => 'BranchCost',
                'value' => '10',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            16 => array(
                'key' => 'currency_id',
                'value' => '1',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            17 => array(
                'key' => 'whatsappToken',
                'value' => 'txRulzo44xJDAFW6cY8Jll8Z44T22q4AvRgOM0IW',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            18 => array(
                'key' => 'privacy_ar',
                'value' => '',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ), 
            19 => array(
                'key' => 'privacy_en',
                'value' => '',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            20 => array(
                'key' => 'terms_ar',
                'value' => '',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            ),
            21 => array(
                'key' => 'terms_en',
                'value' => '',
                'created_at' => '2019-09-06 21:52:30',
                'updated_at' => '2019-09-06 21:52:30',
            )
        ]);
    }
}
