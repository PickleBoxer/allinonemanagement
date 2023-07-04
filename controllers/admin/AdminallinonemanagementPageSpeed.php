<?php

declare(strict_types=1);

use AllInOneManagement\Lightkeeper\Lightkeeper;
use AllInOneManagement\Services\PageSpeedAPI;

require_once _PS_MODULE_DIR_ . 'allinonemanagement/public/helpers.php';

class AdminAllInOneManagementPageSpeedController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->module          = Module::getInstanceByName('allinonemanagement');
        $this->controller_name = 'AdminAllInOneManagementPageSpeed';
        $this->context = Context::getContext();
        parent::__construct();
    }

    /**
     * Initializes the content for the critical CSS management page.
     * Adds the necessary CSS and JavaScript files, retrieves the critical CSS files and their content, and assigns them to the Smarty template.
     */
    public function initContent()
    {
        $this->context->controller->addCSS(_PS_MODULE_DIR_ . 'allinonemanagement/views/css/back.css');
        $urls = array('https://vapr.store', 'https://vapr.store/746-per-iniziare', 'https://vapr.store/basi-con-nicotina/6875-6593-vapr-base-nicobooster-70-30-10ml.html#/65-nicotina-18mg_ml');
        $options = array(
            'strategy' => 'mobile',
            'category' => array(
                'performance',
                'accessibility',
                'best-practices',
                'seo',
                'pwa'
            )
        );

        //$config = DefaultConfig::getInstance()->getConfig();
        $config = new Lightkeeper(['root' => 'modules/allinonemanagement/', 'urls' => ['https://vapr.store', 'https://vapr.store/746-per-iniziare', 'https://vapr.store/basi-con-nicotina/6875-6593-vapr-base-nicobooster-70-30-10ml.html#/65-nicotina-18mg_ml']]);
        //$pageSpeedAPI = new PageSpeedAPI();
        //$pageSpeedAPI->getResults($urls, $options);

        $this->context->smarty->assign(array(
            'vite' => vite('main.js'),
            'config' => $config->run(),
        ));

        $reportFiles = $this->getAllJsonFiles(_PS_MODULE_DIR_ . 'allinonemanagement/reports/');
        $reports = array();
        foreach ($reportFiles as $reportFile) {
            $reportContent = $this->getJsonFileContent($reportFile);
            if ($reportContent !== false) {
                $reports[] = $reportContent;
            }
        }

        Media::addJsDef([
            'configurationUrl' => $this->context->link->getAdminLink($this->controller_name),
            'modulePath' => _PS_MODULE_DIR_ . 'allinonemanagement/',
            'getAllJsonFiles' => $reports,
        ]);

        parent::initContent();
    }

    public function display()
    {
        $this->ajax = true;
        $this->content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . 'allinonemanagement/views/templates/admin/pageSpeed.tpl'
        );

        parent::display();
    }


    public function getPageSpeedReport($urls, $options = array())
    {
        $pageSpeedAPI = new PageSpeedAPI();
        $pageSpeedAPI->getResults($urls, $options);
    }

    /**
     * Recursively get all the JSON files from the /reports folder.
     *
     * @param string $dir The directory to search in.
     * @return array An array of file paths to the JSON files.
     */
    public function getAllJsonFiles($dir)
    {
        $files = array();
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        foreach ($iterator as $file) {
            if ($file->isFile() && strtolower($file->getExtension()) === 'json') {
                $files[] = $file->getPathname();
            }
        }
        return $files;
    }

    /**
     * Get the path and content of a JSON file.
     *
     * @param string $filePath The path to the JSON file.
     * @return array|false An array containing the path and content of the JSON file, or false if the file does not exist or is not readable.
     */
    public function getJsonFileContent($filePath)
    {
        if (file_exists($filePath) && is_readable($filePath)) {
            $content = file_get_contents($filePath);
            return array(
                'path' => $filePath,
                'content' => $content
            );
        } else {
            return false;
        }
    }
}
