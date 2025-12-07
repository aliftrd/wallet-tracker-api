<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;

class EnsureApiKeyIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payload = $request->header('X-API-KEY');
        abort_if(!$payload, 400, 'Missing API Key');

        $apiKey = ApiKey::findActiveKey($payload)->first();
        abort_if(!$apiKey, 400, 'Invalid API Key');

        return $next($request);
    }
}
