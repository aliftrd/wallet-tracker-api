<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                ...$request->validated(),
                'password' => bcrypt($request->validated()['password']),
            ]);
            $user->assignRole('user');

            foreach (Category::get() as $category) {
                $user->categories()->create([
                    'name' => $category->name,
                    'type' => $category->type,
                    'color' => $category->color,
                    'icon' => $category->icon,
                ]);
            }

            return $user;
        });

        return $this->resolveSuccessResponse(
            message: 'User registered successfully',
            data: $user->toResource(),
        );
    }
}
