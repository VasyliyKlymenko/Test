<?php


namespace App\Http\Controllers;

/**
 * Base class for page controllers
 * @package App\Http\Controllers
 */
class BasePageController
{
    /**
     * @var string
     */
    protected string $baseViewsPath = '../views/';

    /**
     * Render view
     * @param string $viewPath
     * @param array|null $data
     */
    protected function render(string $viewPath, ?array $data = [])
    {
        include($this->baseViewsPath . $viewPath);
    }
}