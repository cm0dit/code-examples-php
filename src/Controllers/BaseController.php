<?php

namespace Example\Controllers;

use Example\Services\ManifestService;

abstract class BaseController
{

    protected const DEMO_DOCS_PATH = __DIR__ . '/../../public/demo_documents/';
    
    protected array $codeExampleText;

    /**
     * Save the current operation so it will be resumed after authentication
     * @param string $eg
     */
    protected function saveCurrentUrlToSession($eg)
    {
        $_SESSION['eg'] = $GLOBALS['app_url'] . 'index.php?page=' . $eg;
    }

    protected function displayOptions($eg, $routerService, $basename): array
    {
        return [
            'title' => $routerService->getTitle($eg),
            'source_url' => $GLOBALS['DS_CONFIG']['github_example_url'] . $basename,
            'documentation' => $GLOBALS['DS_CONFIG']['documentation'] . $eg,
            'show_doc' => $GLOBALS['DS_CONFIG']['documentation'],
        ];
    }

    protected function homeDisplayOptions($eg): array
    {
        return [
            'title' => $this->homePageTitle($eg),
            'show_doc' => false
        ];
    }

    protected function isHomePage(string $eg): bool
    {
        return in_array($eg, ["home_esig", "home_rooms", "home_click", "home_monitor", "home_admin"]);
    }

    protected function getPageText(string $eg): array
    {
        return ManifestService::getPageText($eg);
    }

    protected function getCommonText(): array
    {
        return ManifestService::getCommonTexts();
    }

    protected function homePageTitle($eg=''): string
    {
        $title = '';
        if (isset(explode("_", $eg)[1])) {
            $title = ucfirst(explode("_", $eg)[1]);
        }
        return "Home--PHP $title Code Examples";
    }
}
