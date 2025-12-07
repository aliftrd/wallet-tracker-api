<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends ApiController
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->validated();

        $customer = Customer::whereEmail($credentials['email'])->first();

        throw_if(!$customer || !Hash::check($credentials['password'], $customer->password), ValidationException::withMessages([
            'email' => 'Invalid credentials',
        ]));

        $token = $customer->createToken('auth_token');

        return $this->resolveSuccessResponse('Login successful', data: [
            'customer' => $customer->toResource(),
            'token' => $token->plainTextToken,
        ]);
    }
}
