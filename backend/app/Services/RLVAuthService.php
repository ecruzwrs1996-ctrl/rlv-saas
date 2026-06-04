<?php

namespace App\Services;

use App\Repositories\RLVUsersRepository;
use App\Models\RLVUsersSessionsModel;

class RLVAuthService
{
    protected RLVUsersRepository $usersRepository;

    protected RLVUsersSessionsModel $sessionsModel;

    public function __construct()
    {
        $this->usersRepository = new RLVUsersRepository();

        $this->sessionsModel = new RLVUsersSessionsModel();
    }

    /**
     * Login usuario
     */
    public function login(string $username, string $password): array
    {
        $user = $this->usersRepository->findByUsername($username);

        if (!$user) {

            return [
                'success' => false,
                'message' => 'Usuario no encontrado'
            ];
        }

        if ($user['status'] !== 'ACTIVE') {

            return [
                'success' => false,
                'message' => 'Usuario inactivo o bloqueado'
            ];
        }

        if (!password_verify($password, $user['password'])) {

            return [
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ];
        }

        /**
         * Generar JWT
         */
        $token = generateJWT($user);

        /**
         * Guardar sesión
         */
        
$this->sessionsModel->insert([

    'Id_user'   => $user['Id_user'],

    'token'     => $token,

    'login_at'  => date('Y-m-d H:i:s'),

    'is_active' => true
]);

/**
 * Obtener ID sesión creada
 */
$sessionId = $this->sessionsModel->getInsertID();

/**
 * Registrar audit log LOGIN
 */
$auditLogsModel = new \App\Models\RLVAuditLogsModel();

$auditLogsModel->insert([

    'Id_user' => $user['Id_user'],

    'Id_usr_session' => $sessionId,

    'login_at' => date('Y-m-d H:i:s'),

    'logout_at' => null,

    'created_at' => date('Y-m-d H:i:s')
]);

        /**
         * Limpiar password
         */
        unset($user['password']);

        return [
            'success' => true,
            'message' => 'Login exitoso',
            'token'   => $token,
            'user'    => $user
        ];
    }


/**
 * Logout usuario
 */
public function logout(string $token): bool
{
    /**
     * Buscar sesión activa
     */
    $session = $this->sessionsModel

        ->where('token', $token)

        ->where('is_active', 1)

        ->first();

    if (!$session) {

        return false;
    }

    /**
     * Cerrar sesión
     */
    $this->sessionsModel->update(

        $session['Id_usr_session'],

        [

            'logout_at' => date('Y-m-d H:i:s'),

            'is_active' => 0
        ]
    );

    /**
     * Actualizar audit log
     */
    $auditLogsModel = new \App\Models\RLVAuditLogsModel();

    $auditLog = $auditLogsModel

        ->where(
            'Id_usr_session',
            $session['Id_usr_session']
        )

        ->first();

    if ($auditLog) {

        $auditLogsModel->update(

            $auditLog['Id_log'],

            [

                'logout_at' => date('Y-m-d H:i:s')
            ]
        );
    }

    return true;
}





}