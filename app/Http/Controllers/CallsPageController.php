<?php

namespace App\Http\Controllers;

use App\Repositories\CallsRepository;
use Exception;

/**
 * Controller for calls pages
 * @package App\Http\Controllers
 */
class CallsPageController
{
    /**
     * Show page with form to upload the file with history of calls
     * @return void
     */
    public static function getHistoryUploadForm(): void
    {
        include('../views/calls/historyUploadForm.php');
    }

    /**
     * Get calls report based on calls history
     * @return void
     * @throws Exception
     */
    public static function getReport(): void
    {
        $callsRepository = new CallsRepository();
        $callsReportData = $callsRepository->getCallsReportData($_FILES['file']);

        // uses $callsReportData
        include('../views/calls/report.php');
    }
}
