<?php 
namespace App\Services\Common;
class JWTToken
{
    private static $secretKey = '3c9b320d02d1e65bc4159606e374b57c94c366cc';

    public static function generateToken($data, $expiration)
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $payload = [
            'data' => $data,
            'exp' => $expiration,
        ];

        $headerBase64 = base64_encode(json_encode($header));
        $payloadBase64 = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headerBase64.$payloadBase64", self::$secretKey, true);
        $signatureBase64 = base64_encode($signature);

        return "$headerBase64.$payloadBase64.$signatureBase64";
    }

    public static function verifyToken($token)
    {
        list($headerBase64, $payloadBase64, $signatureProvided) = explode('.', $token);

        $signature = hash_hmac('sha256', "$headerBase64.$payloadBase64", self::$secretKey, true);
        $signatureBase64 = base64_encode($signature);

        return hash_equals($signatureBase64, $signatureProvided);
    }

    public static function decodeToken($token)
    {
        list(, $payloadBase64,) = explode('.', $token);
        $payload = base64_decode($payloadBase64);
        return json_decode($payload, true);
    }
}

