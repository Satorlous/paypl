<?php

use App\Category;
use App\Chat;
use App\ContactService;
use App\Good;
use App\Media;
use App\Message;
use App\Order;
use App\PayService;
use App\User;
use App\Request;
use Faker\Factory;
use Illuminate\Database\Seeder;

/** @var App\User $user */

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $this->call(MediaTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);

        /**
         * Seeding 40 Categories and SubCategories
         */
        factory(Category::class, 40)->create()->each(function ($category) {
            if($category->id > 7) {
                $category->parent()->associate(Category::all()->where('id','>', '5')->random())->save();
            }
        });

        /**
         * Seeding 10 contactServices
         */
        factory(ContactService::class, 10)->create();

        /**
         * Seeding 10 payServices
         */
        factory(PayService::class, 10)->create();

        /**
         * Seeding 20 sellers (User),
         */
        factory(User::class, 20)->create(['role_id' => 2])->each(
            function ($user) use ($faker) {
                /**
                 * Seeding contact_service_user,
                 */
                $user->contactServices()->attach(
                    ContactService::all('id as contact_service_id')->random(rand(1, 4))->each(
                        function ($service) use ($faker) {
                            $service['link'] = $faker->url();
                        })->toArray());

                /**
                 * Seeding pay_service_user,
                 */
                $user->payServices()->attach(
                    PayService::all('id as pay_service_id')->random(rand(1, 4))->each(
                        function ($service) use ($faker) {
                            $service['link'] = $faker->url();
                        })->toArray());
                /**
                 * Seeding 1-10 goods for each existing seller
                 */
                factory(Good::class, rand(1, 10))->create(['user_id' => $user->id])->each(
                    function ($good) use ($user) {
                        /**
                         * Seedign 3-40 media files for each existing good
                         */
                        factory(Media::class, rand(3, 40))->create(['good_id' => $good->id]);
                    });
                factory(Request::class, rand(0, 2))->create(['user_id' => $user->id]);
            }
        );

        /**
         * Seeding 20 byuers (User)
         */
        factory(User::class, 20)->create(['role_id' => 3])->each(
            function ($user) {
                /**
                 * Seeding 1-5 orders with 1-4 goods for each existing buyer
                 */
                $user->orders()->saveMany(
                    factory(Order::class, rand(1, 5))->create(
                        [
                            'user_id' => $user->id, 'status_id' => 3,
                        ]
                    )->each(function ($order) {
                            $goods = [];
                            foreach (Good::all()->random(rand(1, 4)) as $good) {
                                $goods[] = [
                                    'good_id' => $good['id'],
                                    'quantity' => rand(1, $good->quantity),
                                    'price_current' => $good->price,
                                    'tax_current' => $good->category['tax'],
                                ];
                            }
                            $order->goods()->attach($goods);
                        }
                    )
                );
            }
        );
        /**
         * Seeding 15 chats each contains 2 users (buyer and seller) that has written 3-7 messages
         */
        factory(Chat::class, 15)->create()->each(
            function ($chat) use ($faker)
            {
                $users = [
                    User::where('role_id', '2')->get('id as user_id')->random(1)->first()->toArray(),
                    User::where('role_id', '3')->get('id as user_id')->random(1)->first()->toArray()
                ];
                $chat->users()->attach($users);
                foreach($chat->users()->allRelatedIds()->toArray() as $user_id)
                {
                    factory(Message::class, rand(3,7))->create([
                        'chat_id' => $chat->id,
                        'user_id' => $user_id
                    ]);
                }
            }
        );
    }
}
