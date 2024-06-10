<?php

if (!function_exists("toResponseApi")) {
    function toResponseApi(bool $status, string $message, array $data = []): array
    {
        return [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
    }
}
