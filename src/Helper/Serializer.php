<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;


class Serializer
{
    /**
     * Success response method
     */
    public static function success(mixed $result, string $message, int $code = 200) : JsonResponse
    {
        $reponse = [
            'data'      => $result,
            'message'   => $message,
        ];

        return new JsonResponse($reponse, $code);
    }
    
    /**
     * Error response method
     */
    public static function error(string $error, mixed $errorMessages = [], int $code = 404) : JsonResponse
    {
        $reponse = [
            'message'   => $error,
        ];

        if ($errorMessages) {
            $reponse['data'] = $errorMessages;
        }

        return new JsonResponse($reponse, $code);
    }
}