<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

if (! function_exists('handleResponse')) {
    function handleResponse($request, string $message, string $redirectRoute, $statusCode = 200, array $extra = []): JsonResponse|RedirectResponse
    {
        if ($request->ajax()) {
            return response()->json(array_merge([
                'status' => $statusCode,
                'message' => $message,
                'redirect_url' => route($redirectRoute),
            ], $extra))->setEncodingOptions(JSON_NUMERIC_CHECK)->setStatusCode($statusCode);
        }

        if ($statusCode !== 200) {
            // Send errors via session for redirect
            return redirect($redirectRoute)->with('error', $message)->withErrors($extra['errors'] ?? []);
        }

        return redirect($redirectRoute)->with('success', $message);
    }
}  