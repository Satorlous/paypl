<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    const TokenName = 'TestToken';

    /**
     * Authorization user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $aRequest =  $request->json()->all();
        $credential = [
            'email' => $aRequest['email'] ?? '',
            'password' => $aRequest['password'] ?? '',
        ];

        if(auth()->attempt($credential)) {
            $user = Auth::user();
            $token = [
                'token'  => $this->get_user_token($user, self::TokenName),
                'user'   => $user->getDataForFrontend()
            ];
            $response = Response::HTTP_OK;
            return $this->get_http_response( $response,'success', $token);
        } else {
            $error = 'Отказ в доступе';
            $response = Response::HTTP_UNAUTHORIZED;
            return $this->get_http_response($response,'error', $error);
        }
    }

    /**
     * Create a new user instance after a valid registration
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $data = $request->all();
        if (empty($data['login'])) {
            $data['login'] = User::getUniqueToken();
        }
        $validator = Validator::make($data, User::$validate);
        if ($validator->fails()) {
            return \response()->json(['status' => 'error', 'error' => $validator->errors()]);
        }
        $data['role_id'] = Role::ROLE_BUYER;
        $data['password'] = Hash::make($data['password']);
        if (!empty($data['avatar']) && $request->hasfile('avatar')) {
            if (!file_exists(public_path() . '/images/avatars/')) {
                mkdir(public_path() . '/images/avatars/');
            }

            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move(public_path() . '/images/avatars/', $filename);
            $data['avatar'] = asset('/images/avatars/'. $filename);
        } else {
            $data['avatar'] = asset('/images/user.png');
        }

        $user = User::create($data);

        $success = [
            'token'  => $this->get_user_token($user, self::TokenName),
            'user'   => $user->getDataForFrontend(),
        ];


        return $this->get_http_response(Response::HTTP_CREATED,"success", $success);

    }

    /**
     * Return details info about User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_users_details_info()
    {
        $user = Auth::user();
        $response = Response::HTTP_OK;
        return $user ? $this->get_http_response($response,"success", $user->with('role')->whereId($user->id)->first())
            : $this->get_http_response($response,"unauthenticated user", $user);
    }

    /**
     * Return token
     *
     * @param $user
     * @param string|null $token_name
     *
     * @return mixed
     */
    public function get_user_token($user, string $token_name = null)
    {
        return $user->createToken($token_name)->accessToken;
    }

    /**
     *  Return new response
     *
     * @param int $response
     * @param string|null $status
     * @param mixed $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_http_response( int $response, string $status = null, $data = null)
    {
        return \response()->json([
            'status' => $status,
            'data'   => $data
        ], $response);
    }


}
