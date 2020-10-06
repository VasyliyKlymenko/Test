<?php

namespace App\Repositories;

use App\Http\Client\GuzzleHttpClient;
use App\Services\IpStackService;
use App\Services\PhoneContinentService;
use Exception;

/**
 * Methods for working with calls data
 * @package App\Repositories
 */
class CallsRepository
{
    /**
     * Returns calls report data based on calls history file
     *
     *  example:
     *  [
     *      '1234' => [ // client id
     *          'sameContinentNumber' => 11,
     *          'sameContinentDuration' => 3650,
     *          'totalNumber' => 15,
     *          'totalDuration' => 4560,
     *      ],
     *      ...
     *  ]
     *
     * @param array $callsHistoryUploadedFile [name, type, tmp_name, error, size]
     *      csv file which should contain columns in order
     *      (Call Date, Duration in seconds, Dialed Phone Number, Customer IP that initiated the call)
     * @return array
     * @throws Exception
     */
    public function getCallsReportData(array $callsHistoryUploadedFile): array
    {
        $this->validateCallsHistoryUploadedFile($callsHistoryUploadedFile);

        $callsReportData = [];

        if (($handle = fopen($callsHistoryUploadedFile['tmp_name'], "r")) !== false) {
            $httpClient = new GuzzleHttpClient();
            $ipContinentService = new IpStackService($httpClient);
            $phoneContinentService = new PhoneContinentService();

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $clientId = $data[0];
                $callDuration = $data[2];
                $callPhone = $data[3];
                $callIp = $data[4];

                if (!array_key_exists($clientId, $callsReportData)) {
                    $callsReportData[$clientId] = [
                        'sameContinentNumber' => 0,
                        'sameContinentDuration' => 0,
                        'totalNumber' => 0,
                        'totalDuration' => 0,
                    ];
                }

                $callsReportData[$clientId]['totalNumber']++;
                $callsReportData[$clientId]['totalDuration'] += $callDuration;

                $ipContinentCode = $ipContinentService->getContinentCode($callIp);

                // check if the phone is in the same continent as ip
                if ($ipContinentCode && $phoneContinentService->validatePhoneContinent($callPhone, $ipContinentCode)) {
                    $callsReportData[$clientId]['sameContinentNumber']++;
                    $callsReportData[$clientId]['sameContinentDuration'] += $callDuration;
                }
            }
            fclose($handle);
        }

        return $callsReportData;
    }

    /**
     * // TODO: Needs real validation
     * @param $callsHistoryUploadedFile
     * @throws Exception
     */
    public function validateCallsHistoryUploadedFile($callsHistoryUploadedFile): void
    {
        $fileExtension = pathinfo($callsHistoryUploadedFile['name'], PATHINFO_EXTENSION);

        if ($fileExtension !== 'csv') {
            throw new Exception('The file must only be in csv format.');
        }
    }
}