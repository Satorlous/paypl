<?php

use Illuminate\Database\Seeder;
use App\MediaType;
use Illuminate\Support\Facades\DB;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table((new MediaType())->getTable())->insert([
            'name'        => 'http',
            'extensions'  => '',
        ]);
    }
}
