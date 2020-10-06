<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Controllers\CallsPageController;

// TODO: real app needs a real router, request handler, middleware, error handler, logger
try {
    switch (strtok($_SERVER["REQUEST_URI"],'?')) {
        case '/':
            CallsPageController::getHistoryUploadForm();
            break;
        case '/get-calls-report':
            CallsPageController::getReport();
            break;
        default:
            echo '404';
    }
} catch (\Exception $e) {
    // simple error handler
    header("Location: /?error=". $e->getMessage());
    die();
}