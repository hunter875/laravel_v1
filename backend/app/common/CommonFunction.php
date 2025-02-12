<?php

namespace App\Common;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommonFunction{
    public static function responseMessageJsonData($data): JsonResponse
    {
        return response()->json(
            ['errors' => $data['errors'], 'message' => $data['message'], 'data' => $data['data'] ?? []],
            $data['status']
        );
    }

    public static function responseBaseJsonData(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }

    public static function responseJsonData($data): JsonResponse
    {
        if($data['errors'] ?? false){
            return self::responseMessageJsonData($data);
        }

        return self::responseBaseJsonData($data['data'], $data['status']);
    }

    public function response($status, $message, $data){
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }
}