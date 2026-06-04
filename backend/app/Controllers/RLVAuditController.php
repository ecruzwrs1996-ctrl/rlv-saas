<?php

namespace App\Controllers;

use App\Controllers\BaseApiController;
use App\Services\RLVAuditService;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RLVAuditController extends BaseApiController
{
    protected RLVAuditService $auditService;

    public function __construct()
    {
        $this->auditService =
            new RLVAuditService();
    }

    /**
     * GET /api/audit
     */
    public function index()
    {
        /**
         * Pagination
         */
        $page = (int)
            ($this->request->getGet('page') ?? 1);

        $perPage = (int)
            ($this->request->getGet('perPage') ?? 10);

        /**
         * Filters
         */
        $filters = [

            'start_date' => $this->request
                ->getGet('start_date'),

            'end_date' => $this->request
                ->getGet('end_date'),

            'Id_user' => $this->request
                ->getGet('Id_user'),

            'username' => $this->request
                ->getGet('username'),

            'name' => $this->request
                ->getGet('name'),

            'Role_id' => $this->request
                ->getGet('Role_id'),

            'role_name' => $this->request
                ->getGet('role_name'),

            'module' => $this->request
                ->getGet('module'),

            'action_type' => $this->request
                ->getGet('action_type'),

            'search' => $this->request
                ->getGet('search')
        ];

        $result = $this->auditService
            ->getAuditLogs(

                $filters,

                $page,

                $perPage
            );

        return $this->successResponse(

            'Auditoría obtenida correctamente',

            $result
        );
    }

    /**
     * Export Excel
     */
    public function export()
    {
        $data = $this->auditService
            ->getAuditExportData();

        /**
         * Spreadsheet
         */
        $spreadsheet =
            new Spreadsheet();

        $sheet =
            $spreadsheet
                ->getActiveSheet();

        $sheet->setTitle(
            'Audit Report'
        );

        /**
         * Headers
         */
        $headers = [

            'A1' => 'Name',
            'B1' => 'Username',

            'C1' => 'Role',
            'D1' => 'Role Description',

            'E1' => 'Token',
            'F1' => 'Login At',
            'G1' => 'Logout At',

            'H1' => 'Module',
            'I1' => 'Action',
            'J1' => 'Description',
            'K1' => 'Created At'
        ];

        foreach ($headers as $cell => $value) {

            $sheet->setCellValue(
                $cell,
                $value
            );
        }

        /**
         * Header styles
         */
        $sheet->getStyle('A1:K1')
            ->getFont()
            ->setBold(true);

        /**
         * Auto size columns
         */
        foreach (range('A', 'K') as $column) {

            $sheet
                ->getColumnDimension($column)
                ->setAutoSize(true);
        }

        /**
         * Data rows
         */
        $row = 2;

        foreach ($data as $item) {

            $sheet->setCellValue(
                'A' . $row,
                $item['name']
            );

            $sheet->setCellValue(
                'B' . $row,
                $item['username']
            );

            $sheet->setCellValue(
                'C' . $row,
                $item['role_name']
            );

            $sheet->setCellValue(
                'D' . $row,
                $item['role_description']
            );

            $sheet->setCellValue(
                'E' . $row,
                $item['token']
            );

            $sheet->setCellValue(
                'F' . $row,
                $item['login_at']
            );

            $sheet->setCellValue(
                'G' . $row,
                $item['logout_at']
            );

            $sheet->setCellValue(
                'H' . $row,
                $item['table_name']
            );

            $sheet->setCellValue(
                'I' . $row,
                $item['action_type']
            );

            $sheet->setCellValue(
                'J' . $row,
                $item['description']
            );

            $sheet->setCellValue(
                'K' . $row,
                $item['created_at']
            );

            $row++;
        }

        /**
         * Filename
         */
        $fileName =

            'AuditReport_' .

            date('Ymd_His') .

            '.xlsx';

        /**
         * Writer
         */
        $writer =
            new Xlsx(
                $spreadsheet
            );

        /**
         * Temp file
         */
        $tempFile = tempnam(
            sys_get_temp_dir(),
            'audit'
        );

        $writer->save(
            $tempFile
        );

        /**
         * Download response
         */
        return $this->response
            ->download(
                $tempFile,
                null
            )
            ->setFileName(
                $fileName
            );
    }

    /**
     * POST /api/audit/purge
     */
    public function purge()
    {
        /**
         * Obtener data backup
         */
        $data = $this->auditService
            ->getFullAuditBackupData();

        /**
         * Spreadsheet
         */
        $spreadsheet =
            new Spreadsheet();

        /**
         * Eliminar hoja default
         */
        $spreadsheet
            ->removeSheetByIndex(0);

        /**
         * Crear hojas
         */
        foreach ($data as $sheetName => $rows) {

            $sheet =
                $spreadsheet
                    ->createSheet();

            $sheet->setTitle(
                substr(
                    $sheetName,
                    0,
                    31
                )
            );

            /**
             * Sin registros
             */
            if (empty($rows)) {

                $sheet->setCellValue(
                    'A1',
                    'No data'
                );

                continue;
            }

            /**
             * Headers
             */
            $headers =
                array_keys($rows[0]);

            $column = 'A';

            foreach ($headers as $header) {

                $sheet->setCellValue(

                    $column . '1',

                    $header
                );

                $sheet->getStyle(
                    $column . '1'
                )
                    ->getFont()
                    ->setBold(true);

                $sheet
                    ->getColumnDimension(
                        $column
                    )
                    ->setAutoSize(true);

                $column++;
            }

            /**
             * Data
             */
            $rowNumber = 2;

            foreach ($rows as $row) {

                $column = 'A';

                foreach ($headers as $header) {

                    $sheet->setCellValue(

                        $column . $rowNumber,

                        $row[$header]
                    );

                    $column++;
                }

                $rowNumber++;
            }
        }

        /**
         * Backup path
         */
        $backupPath =

            WRITEPATH .

            'backups/audit/';

        /**
         * Crear carpeta si no existe
         */
        if (!is_dir($backupPath)) {

            mkdir(

                $backupPath,

                0777,

                true
            );
        }

        /**
         * XLSX filename
         */
        $xlsxName =

            'AuditBackup_' .

            date('Ymd_His') .

            '.xlsx';

        $xlsxFullPath =

            $backupPath .

            $xlsxName;

        /**
         * Save XLSX
         */
        $writer =
            new Xlsx(
                $spreadsheet
            );

        $writer->save(
            $xlsxFullPath
        );

        /**
         * ZIP filename
         */
        $zipName =

            'AuditBackup_' .

            date('Ymd_His') .

            '.zip';

        $zipFullPath =

            $backupPath .

            $zipName;

        /**
         * ZIP
         */
        $zip =
            new \ZipArchive();

        if (

            $zip->open(

                $zipFullPath,

                \ZipArchive::CREATE

            ) === true

        ) {

            $zip->addFile(

                $xlsxFullPath,

                $xlsxName
            );

            $zip->close();
        }

        /**
         * Registrar debug purge
         */
        $this->auditService
            ->registerPurgeDebug(

                (int) $this->authUser
                    ->Id_user,

                $zipFullPath
            );

        /**
         * Purge tablas
         */
        $purge =
            $this->auditService
                ->purgeAudit();

        if (!$purge) {

            return $this->errorResponse(

                'Error purge auditoría',

                null,

                500
            );
        }

        /**
         * Response
         */
        return $this->successResponse(

            'Auditoría purgada correctamente',

            [

                'backup_xlsx' => $xlsxName,

                'backup_zip' => $zipName,

                'backup_path' => $backupPath
            ]
        );
    }
}