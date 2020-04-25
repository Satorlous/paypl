<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $credential = [
           'email' => $request->email,
            'password' => $request->password,
        ];

        if(auth()->attempt($credential)) {
            $user = Auth::user();
            $token['token'] = $this->get_user_token($user, self::TokenName);
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
        $validator = Validator::make($request->all(), User::$validate);

        if ($validator->fails()) {
            return \response()->json(['error' => $validator->errors()]);
        }

        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $success = [
            'token' => $this->get_user_token($user, self::TokenName),
            'name' => $user->name
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
        return $user ? $this->get_http_response($response,"success", $user)
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
