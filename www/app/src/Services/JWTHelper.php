<?php

namespace App\Services;

use App\Model\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{
    public static function buildJWT(User $user): string
    {
        $payload = [
            "username" => $user->getUsername(),
            "id" => $user->getId(),
            "exp" => (new \DateTime("+ 20 minutes"))->getTimestamp()
        ];

        return JWT::encode($payload, "n7hyqyvo3h8z3v60vtxz", "HS256");
    }

    public static function decodeJWT(string $jwt): ?object
    {
        try {
            return JWT::decode($jwt, new Key("n7hyqyvo3h8z3v60vtxz", "HS256"));
        } catch (\Exception $exception) {
            return null;
        }
    }
}
