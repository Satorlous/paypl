<?php

namespace App\Http\Controllers;

use App\Good;
use App\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function test()
    {
        $good = Good::whereName('TEST_TEST_TESTqwe');
        $good->delete();
        $data = [
            "user_id"=> 2,
            "name"=> "TEST_TEST_TESTqwe",
            "price"=> "5521.38",
            "quantity"=> 1,
            "discount"=> "1091.91",
            "status_id"=> 1,
            "description"=> "Some of the cupboards as she could. 'The game's going on shrinking rapidly=> she soon found herself in Wonderland, though she looked up eagerly, half hoping that they were gardeners, or soldiers, or.",
            "category_id"=> 10,
        ];

        $good = Good::create($data);
        dd($good);
    }
}
