<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT(array $user): string
{
    $key = env('JWT_SECRET');

    $payload = [

        'iss' => 'rlv-saas',
        'aud' => 'rlv-users',

        'iat' => time(),

        'exp' => time() + env('JWT_EXPIRE_TIME'),

        'data' => [
            'Id_user' => $user['Id_user'],
            'username' => $user['username'],
            'Role_id' => $user['Role_id']
        ]
    ];

    return JWT::encode(
        $payload,
        $key,
        env('JWT_ALGORITHM')
    );
}

function validateJWT(string $token)
{
    try {

        return JWT::decode(
            $token,
            new Key(
                env('JWT_SECRET'),
                env('JWT_ALGORITHM')
            )
        );

    } catch (Exception $e) {

        return null;
    }
}