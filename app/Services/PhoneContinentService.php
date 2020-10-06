<?php

namespace App\Services;

/**
 * Methods for working with continent phone codes
 * @package App\Services
 */
class PhoneContinentService
{
    /**
     * Continent phone codes based on country info file
     *
     *  example:
     *  [
     *      'EU' => ['123', ...],
     *      ...
     *  ]
     *
     * @var array
     */
    private array $continentPhoneCodes = [];

    /**
     * @var string
     */
    private string $countryInfoFilePath = '../storage/countryInfo.txt';

    public function __construct()
    {
        $this->loadContinentPhoneCodes();
    }

    /**
     * Validate if the phone is in the specified continent
     * @param string $phone // only digits
     * @param string $continentCode // in two letters format, ex: "EU"
     * @return bool
     */
    public function validatePhoneContinent(string $phone, string $continentCode): bool
    {
        $continentPhoneCodes = $this->getContinentPhoneCodes($continentCode);

        foreach ($continentPhoneCodes as $continentPhoneCode) {
            if (substr($phone, 0, strlen($continentPhoneCode)) === $continentPhoneCode) {
                return true;
            }
        }

        return false;
    }

    /**
     * Load continent phone codes based on country info file
     */
    private function loadContinentPhoneCodes(): void
    {
        $countryInfoFile = file($this->countryInfoFilePath);

        foreach ($countryInfoFile as $fileLine) {
            if ($fileLine[0] != '#') {
                $row = explode("\t", $fileLine);

                $continentCode = $row[8];
                $phoneCodes = $row[12];

                $phoneCodes = str_replace(['+', '-', ' '], '', $phoneCodes);

                if (strpos($phoneCodes, 'and') !== false) {
                    foreach (explode('and', $phoneCodes) as $phoneCode) {
                        $this->continentPhoneCodes[$continentCode][] = $phoneCode;
                    }
                } else {
                    $this->continentPhoneCodes[$continentCode][] = $phoneCodes;
                }
            }
        }
    }

    /**
     * Get continent phone codes based on continent code
     * @param string $continentCode // in two letters format, ex: "EU"
     * @return array
     */
    private function getContinentPhoneCodes(string $continentCode): array
    {
        return array_key_exists($continentCode, $this->continentPhoneCodes) ? $this->continentPhoneCodes[$continentCode] : [];
    }
}