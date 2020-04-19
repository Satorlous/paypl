<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table((new Status())->getTable())->insert([
            [
                'id'      => 1,
                'name'    => 'Товар продается',
                'type'    => Status::TYPE_GOOD,
                'locked'  => false,
            ],
            [
                'id'      => 2,
                'name'    => 'Продажа приостановлена',
                'type'    => Status::TYPE_GOOD,
                'locked'  => true,
            ],
            [
                'id'      => 3,
                'name'    => 'Товар продан',
                'type'    => Status::TYPE_GOOD,
                'locked'  => true,
            ],

            [
                'id'      => 10,
                'name'    => 'Черновик',
                'type'    => Status::TYPE_ORDER,
                'locked'  => false,
            ],
            [
                'id'      => 11,
                'name'    => 'Сделка отменена',
                'type'    => Status::TYPE_ORDER,
                'locked'  => true,
            ],
            [
                'id'      => 12,
                'name'    => 'Сделка завершена',
                'type'    => Status::TYPE_ORDER,
                'locked'  => true,
            ],

            [
                'id'      => 100,
                'name'    => 'Черновик',
                'type'    => Status::TYPE_REQUEST,
                'locked'  => false,
            ],
            [
                'id'      => 101,
                'name'    => 'Обращение подано',
                'type'    => Status::TYPE_REQUEST,
                'locked'  => true,
            ],
            [
                'id'      => 102,
                'name'    => 'Обращение находится в обработке',
                'type'    => Status::TYPE_REQUEST,
                'locked'  => true,
            ],
            [
                'id'      => 103,
                'name'    => 'Отказ',
                'type'    => Status::TYPE_REQUEST,
                'locked'  => true,
            ],
            [
                'id'      => 104,
                'name'    => 'Успех',
                'type'    => Status::TYPE_REQUEST,
                'locked'  => true,
            ],
        ]);
    }
}
