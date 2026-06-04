<?php

namespace App\Validators;

class RLVUsersValidator
{
    /**
     * Reglas create
     */
    public static function create(): array
    {
        return [

            'username' => [
                'rules' => 'required|min_length[3]|is_unique[RLV_Users.username]',
                'errors' => [
                    'required' => 'Username requerido',
                    'is_unique' => 'Username ya existe'
                ]
            ],

            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password requerido'
                ]
            ],

            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nombre requerido'
                ]
            ],

            'email' => [
                'rules' => 'required|valid_email|is_unique[RLV_Users.email]',
                'errors' => [
                    'required' => 'Email requerido',
                    'valid_email' => 'Email inválido',
                    'is_unique' => 'Email ya existe'
                ]
            ],

            'Role_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Rol requerido'
                ]
            ]

        ];
    }

    /**
     * Reglas update
     */
    public static function update(int $id): array
    {
        return [

            'username' => [
                'rules' => "required|min_length[3]",
            ],

            'name' => [
                'rules' => 'required',
            ],

            'email' => [
                'rules' => "required|valid_email",
            ],

            'Role_id' => [
                'rules' => 'required|integer',
            ]

        ];
    }
}