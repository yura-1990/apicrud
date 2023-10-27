<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\RequestBodies\UserLoginRequestBody;
use App\OpenApi\RequestBodies\UserRegisterRequestBody;
use App\OpenApi\Responses\UserListResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('auth')]
#[PathItem]
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[Post('/login')]
    #[Operation(tags: ['Auth'], method: 'POST')]
    #[RequestBody(factory: UserLoginRequestBody::class)]
    #[Response(factory: UserListResponse::class)]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->error('', 'Unauthorized',401);
        }

        $user = Auth::user();

        return $this->success([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[Post('/register')]
    #[Operation(tags: ['Auth'], method: 'POST')]
    #[RequestBody(factory: UserRegisterRequestBody::class)]
    #[Response(factory: UserListResponse::class)]
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::guard('api')->login($user);

        return $this->success([
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    #[Post('/logout')]
    #[Operation(tags: ['Auth'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[Response(factory: UserListResponse::class)]
    public function logout()
    {
        Auth::logout();
        return $this->success(['message' => 'Successfully logged out']);
    }

}
