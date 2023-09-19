<?php
class TokenTools
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateToken($username, $isValidUser, $expiration = 60 * 60)
    {

        if ($isValidUser) {
            $payload = [
                'username' => $username,
                'expires' => time() + $expiration,
            ];

            return $this->generateJwt($payload);
        }

        return null;
    }



    private function generateJwt($payload)
    {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }



    public function verifyToken($token)
    {
        try {
            $parts = explode('.', $token);
            $base64UrlHeader = $parts[0];
            $base64UrlPayload = $parts[1];
            $base64UrlSignature = $parts[2];

            $header = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlHeader)));
            $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)));
            $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));

            $isValidSignature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true) === $signature;

            $isValidExpiration = $payload->expires >= time();

            return $isValidSignature && $isValidExpiration;
        } catch (Exception $e) {
            return false;
        }
    }
}