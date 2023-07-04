<?php

declare(strict_types=1);

/**
 * This class represents the controller for managing critical CSS files in the All In One Management module.
 * It extends the ModuleAdminController class and provides methods for initializing content, retrieving critical CSS files and their content, and saving changes to the files.
 *
 * @package AllInOneManagement
 */
class AdminAllInOneManagementCriticalCssController extends ModuleAdminController
{
    /**
     * The path to the module directory.
     *
     * @var string
     */
    private $module_path;

    /**
     * Constructor method for the AdminAllInOneManagementCriticalCssController class.
     * Sets the module instance, controller name, module path, and context, and calls the parent constructor.
     */
    public function __construct()
    {
        $this->bootstrap = true;
        $this->module          = Module::getInstanceByName('allinonemanagement');
        $this->controller_name = 'AdminAllInOneManagementCriticalCss';
        $this->module_path = _PS_MODULE_DIR_ . 'allinonemanagement';
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

        $files = $this->getCriticalCssFiles();
        $filesContent = $this->getCriticalCssFilesContent($files);
        $filesWithContent = array_combine($files, $filesContent);

        $this->context->smarty->assign(array(
            'filesWithContent' => $filesWithContent,
        ));

        Media::addJsDef([
            'filesWithContent' => $filesWithContent,
            'configurationUrl' => $this->context->link->getAdminLink($this->controller_name),
        ]);

        // Render the template
        $this->content = $this->context->smarty->fetch(
            $this->module_path . '/views/templates/admin/criticalCss.tpl'
        );

        parent::initContent();
    }

    /**
     * Retrieves an array of critical CSS files from the theme directory.
     *
     * @return array An array of critical CSS files.
     */
    private function getCriticalCssFiles(): array
    {
        $files = Tools::scandir(_PS_THEME_DIR_ . 'assets/cache/', 'css', '', false);
        $files = array_filter($files, function($file) {
            return strpos(basename($file), 'theme') !== 0;
        });
        return $files ?: [];
    }

    /**
     * Retrieves an array of critical CSS files and their content.
     *
     * @param array $files An array of critical CSS files.
     * @return array An array of critical CSS files and their content.
     */
    private function getCriticalCssFilesContent(array $files): array
    {
        $filesContent = [];
        foreach ($files as $file) {
            $filesContent[] = file_get_contents(_PS_THEME_DIR_ . 'assets/cache/' . $file);
        }
        return $filesContent;
    }

    /**
     * Processes an AJAX request to save changes to a critical CSS file.
     * Retrieves the file and content from the request, checks if the file exists and is writable, and saves the changes if possible.
     * Returns a JSON response with a success or error message and the updated critical CSS files and their content.
     */
    public function ajaxProcessSaveChanges(): void
    {
        $file = Tools::getValue('file');
        $content = Tools::getValue('content');

        if (!file_exists(_PS_THEME_DIR_ . 'assets/cache/' . $file)) {
            $responseMsg = [
                'hasError' => true,
                'errorMessage' => 'File does not exist',
            ];
        } elseif (!is_writable(_PS_THEME_DIR_ . 'assets/cache/' . $file)) {
            $responseMsg = [
                'hasError' => true,
                'errorMessage' => 'File is not writable',
            ];
        } else {
            if (file_put_contents(_PS_THEME_DIR_ . 'assets/cache/' . $file, $content) === false) {
                $responseMsg = [
                    'hasError' => true,
                    'errorMessage' => 'Error writing file',
                ];
            } else {
                $files = $this->getCriticalCssFiles();
                $filesContent = $this->getCriticalCssFilesContent($files);
                $filesWithContent = array_combine($files, $filesContent);
                $responseMsg = [
                    'hasError' => false,
                    'successMessage' => 'Updated successfully',
                    'filesWithContent' => $filesWithContent,
                ];
            }
        }

        die(json_encode($responseMsg));
    }
}
