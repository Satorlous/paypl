<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table((new Role())->getTable())->insert(
            [
                [
                    'id'    => 1,
                    'name'  => 'Админ',
                ],
                [
                    'id'    => 2,
                    'name'  => 'Продавец',
                ],
                [
                    'id'    => 3,
                    'name'  => 'Покупатель',
                ]
            ]);
    }
}
