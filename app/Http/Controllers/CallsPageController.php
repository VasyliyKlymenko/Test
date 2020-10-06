<?php

namespace App\Http\Controllers;

use App\Repositories\CallsRepository;
use Exception;

/**
 * Controller for calls pages
 * @package App\Http\Controllers
 */
class CallsPageController extends BasePageController
{
    /**
     * Show page with form to upload the file with history of calls
     * @return void
     */
    public function getHistoryUploadForm(): void
    {
        $this->render('calls/historyUploadForm.php');
    }

    /**
     * Get calls report based on calls history
     * Required file with history
     * @return void
     * @throws Exception
     */
    public function getReport(): void
    {
        // TODO: Needs real request validation
        $uploadedFiles = $_FILES;
        if(!array_key_exists('file', $uploadedFiles) || !file_exists($uploadedFiles['file']['tmp_name'])) {
            throw new Exception('The file must be uploaded.');
        }

        $callsRepository = new CallsRepository();
        $callsReportData = $callsRepository->getCallsReportData($uploadedFiles['file']);

        $this->render('calls/report.php', ['callsReportData' => $callsReportData]);
    }
}
