<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\CategoryTemplate;
use App\Models\Customer;
use App\Models\CustomerCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $customer = DB::transaction(function () use ($request) {
            $payload = $request->validated();
            $payload['password'] = Hash::make($payload['password']);

            $customer = Customer::create($payload);

            $categoryTemplates = CategoryTemplate::all();
            $categories = $categoryTemplates->map(function ($template) use ($customer) {
                return [
                    'customer_id' => $customer->id,
                    'name' => $template->name,
                    'type' => $template->type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });
            CustomerCategory::insert($categories->toArray());

            return $customer;
        });

        // TODO: Send welcome email

        return $this->resolveSuccessResponse('Customer registered successfully', data: $customer->toResource());
    }
}
