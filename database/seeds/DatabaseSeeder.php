<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $this->call(MediaTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
        $count = 0;
        factory(\App\Category::class, 40)->create()->each(function ($category) {
            if($category->id > 7) {
                $category->parent()->associate(\App\Category::all()->where('id','>', '5')->random())->save();
            }
        });
        factory(\App\ContactService::class, 10)->create();
        factory(\App\User::class, 20)->create(['role_id' => 2])->each(
            function ($user) use ($faker) {
                $user->contactServices()->attach(
                    \App\ContactService::all('id as contact_service_id')->random(rand(1, 4))->each(
                        function ($service) use ($faker) {
                            $service['link'] = $faker->url();
                        })->toArray());
                factory(\App\Good::class, rand(1, 10))->create(['user_id' => $user->id])->each(
                    function ($good) use ($user) {
                        factory(\App\Media::class, rand(3, 40))->create(['good_id' => $good->id]);
                    });
            });
        factory(\App\User::class, 20)->create(['role_id' => 3])->each(
            function ($user) {
                $user->orders()->saveMany(
                    factory(\App\Order::class, rand(1, 5))->create(
                        [
                            'user_id' => $user->id, 'status_id' => 3,
                        ]
                    )->each(
                        function ($order) {
                            $goods = [];
                            foreach (\App\Good::all()->random(rand(1, 4)) as $good) {
                                $goods[] = [
                                    'good_id' => $good['id'],
                                    'quantity' => rand(1, $good->quantity),
                                    'price_current' => $good->price,
                                    'tax_current' => $good->category['tax'],
                                ];
                            }
                            $order->goods()->attach($goods);
                        }));
            });
    }
}
