<?php

use App\Parameter;
use Illuminate\Database\Seeder;

class CreateDefaultSystemParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
                [
                    'description' => 'Cliente Demo',
                    'parameter' => 'CLIENT_NAME',
                    'value' => 1,
                    'eliminable' => 1,
                ],
                [
                    'description' => 'logoweb.jpg',
                    'parameter' => 'CLIENT_LOGO',
                    'value' => 1,
                    'eliminable' => 1,
                ],
                [
                    'description' => '0',
                    'parameter' => 'SITE_OFFLINE',
                    'value' => 1,
                    'eliminable' => 1,
                ],
                [
                    'description' => '1.1.0',
                    'parameter' => 'DB_VERSION',
                    'value' => 1,
                    'eliminable' => 1,
                ],
                [
                    'description' => '1.1.1',
                    'parameter' => 'FRONTEND_VERSION',
                    'value' => 1,
                    'eliminable' => 1,
                ],
                [
                    'description' => '1.1.2',
                    'parameter' => 'BACKEND_VERSION',
                    'value' => 1,
                    'eliminable' => 1,
                ]
        ];
        foreach ($data as $key => $value) {
            Parameter::create([
                'description' => $value['description'],
                'parameter' => $value['parameter'],
                'value' => $value['value'],
                'eliminable' => $value['eliminable'],
            ]);
        }
    }
}
