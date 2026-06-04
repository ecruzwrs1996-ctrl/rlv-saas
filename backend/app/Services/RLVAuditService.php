<?php

namespace App\Services;

use App\Repositories\RLVAuditActionsRepository;
use App\Repositories\RLVAuditRepository;
use App\Repositories\RLVSystemDebugRepository;

class RLVAuditService
{
    protected RLVAuditActionsRepository $actionsRepository;

    protected RLVAuditRepository $auditRepository;

    protected RLVSystemDebugRepository $debugRepository;

    public function __construct()
    {
        $this->actionsRepository =
            new RLVAuditActionsRepository();

        $this->auditRepository =
            new RLVAuditRepository();

        $this->debugRepository =
            new RLVSystemDebugRepository();
    }

    /**
     * Registrar acción auditoría
     */
    public function log(

        int $logId,

        string $tableName,

        string $actionType,

        ?string $description = null

    ) {

        return $this->actionsRepository->create([

            'Id_log' => $logId,

            'table_name' => $tableName,

            'action_type' => $actionType,

            'description' => $description,

            'created_at' => date(
                'Y-m-d H:i:s'
            )

        ]);
    }

    /**
     * Obtener auditoría
     */
    public function getAuditLogs(

        array $filters = [],

        int $page = 1,

        int $perPage = 10

    ): array {

        return $this->auditRepository
            ->getAuditLogs(

                $filters,

                $page,

                $perPage
            );
    }

    /**
     * Exportar auditoría
     */
    public function exportAuditData(): array
    {
        return $this->auditRepository
            ->exportAuditData();
    }

    /**
     * Obtener datos export Excel
     */
    public function getAuditExportData(): array
    {
        return $this->auditRepository
            ->getAuditExportData();
    }

    /**
     * Obtener backup completo auditoría
     */
    public function getFullAuditBackupData(): array
    {
        return $this->auditRepository
            ->getFullAuditBackupData();
    }

    /**
     * Purgar auditoría
     */
    public function purgeAudit(): bool
    {
        return $this->auditRepository
            ->purgeAuditTables();
    }

    /**
     * Registrar debug purge
     */
    public function registerPurgeDebug(

        int $userId,

        string $zipFile

    ): bool {

        return $this->debugRepository
            ->create([

                'Id_user' => $userId,

                'ZipFile' => $zipFile,

                'email_sent' => 0,

                'created_at' => date(
                    'Y-m-d H:i:s'
                )
            ]);
    }

    /**
     * Obtener log activo por sesión
     */
    public function getActiveLogBySessionId(
        int $sessionId
    ): ?array {

        return $this->auditRepository
            ->getActiveLogBySessionId(
                $sessionId
            );
    }
}