<?php

if (!function_exists('not_found_response')) {
    function not_found_response($message = null)
    {
        return response()->json(['status' => 0, 'message' => $message ?? trans('response.Not found')], 404);
    }
}

if (!function_exists('success_response')) {
    function success_response($data = [])
    {
        return response()->json(['status' => 'success', 'data' => $data]);
    }
}

if (!function_exists('server_error_response')) {
    function server_error_response()
    {
        return response()->json(['status' => 0, 'message' => 'server error'], 500);
    }
}

if (!function_exists('error_response')) {
    function error_response($message = null)
    {
        return response()->json(['status' => 0, 'message' => $message ?? trans('response.error')], 500);
    }
}

if (!function_exists('forbidden_response')) {
    function forbidden_response($message = null)
    {
        return response()->json(['status' => 0, 'message' => $message ?? trans('response.forbidden')], 403);
    }
}

if (!function_exists('unAuthorized_response')) {
    function unAuthorized_response($message = null)
    {
        return response()->json(['status' => 'error', 'message' => $message ?? trans('response.unAuthorized')], 401);
    }
}
