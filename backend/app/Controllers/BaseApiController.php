<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Traits\ApiResponseTrait;
use App\Services\RLVAuditService;

use App\Models\RLVUsersSessionsModel;
use App\Models\RLVAuditLogsModel;
use App\Repositories\RLVAuditRepository;

class BaseApiController extends ResourceController
{
    use ApiResponseTrait;

    /**
     * Usuario autenticado JWT
     */
    protected $authUser = null;

    /**
     * Pagination default
     */
    protected int $perPage = 10;

    /**
     * Constructor
     */
    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController(
            $request,
            $response,
            $logger
        );

        /**
         * JWT authenticated user
         */
        if (isset($request->user)) {

            $this->authUser = $request->user;
        }
    }

    /**
     * Get pagination params
     */
    protected function getPaginationParams(): array
    {
        $page = (int) ($this->request->getGet('page') ?? 1);

        $perPage = (int) ($this->request->getGet('perPage') ?? $this->perPage);

        return [

            'page'    => $page,
            'perPage' => $perPage

        ];
    }

    /**
     * Validation helper
     */
    protected function validateRequest(array $rules)
    {
        if (!$this->validate($rules)) {

            return $this->errorResponse(
                'Errores de validación',
                $this->validator->getErrors(),
                422
            );
        }

        return true;
    }

    /**
     * Audit helper placeholder
     */
 
protected function audit(
    string $action,
    string $table,
    ?string $description = null
) {

    /**
     * Usuario autenticado
     */
    $userId = $this->authUser->Id_user ?? null;

    if (!$userId) {

        return;
    }

    /**
     * Obtener bearer token
     */
    $authHeader = $this->request
        ->getHeaderLine('Authorization');

    $token = str_replace(
        'Bearer ',
        '',
        $authHeader
    );

    /**
     * Buscar sesión activa
     */
    $sessionsModel = new RLVUsersSessionsModel();

    $session = $sessionsModel

        ->where('token', $token)

        ->where('is_active', 1)

        ->first();

    if (!$session) {

        return;
    }

    /**
     * Buscar log activo
     */
    $auditRepository = new RLVAuditRepository();

    $activeLog = $auditRepository
        ->getActiveLogBySessionId(
            $session['Id_usr_session']
        );

    if (!$activeLog) {

        return;
    }

    /**
     * Registrar acción auditoría
     */
    $auditService = new RLVAuditService();

    $auditService->log(

        $activeLog['Id_log'],

        $table,

        $action,

        $description
    );
}


}