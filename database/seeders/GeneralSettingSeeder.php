<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GeneralSetting;
class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [
            [
                'key'   => 'app_name',
                'value' => 'Application Name'
            ],
            [
                'key'   => 'company_name',
                'value' => 'Company Name'
            ],
            [
                'key'   => 'copy_right',
                'value' => 'Copyright © 2014-2021 aplikasi.io. All rights resersved.'
            ],
        ];

        foreach ($insert as $i) {
            $model = new GeneralSetting;
            $model->key = $i['key'];
            $model->value = $i['value'];
            $model->save();

        }


        // GeneralSetting::create($insert);
    }
}