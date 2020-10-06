<?php

namespace App\Services;

/**
 * Interface for all api services
 * @package App\Services
 */
interface IpContinentServiceInterface
{
    /**
     * Returns continent code based on ip, in two letters format, ex: "EU"
     * or NULL if continent is undefined
     * @param string $ip
     * @return string|null
     */
    public function getContinentCode(string $ip): ?string;
}