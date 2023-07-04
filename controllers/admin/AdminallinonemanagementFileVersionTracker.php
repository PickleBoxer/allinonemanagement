<?php

declare(strict_types=1);

class AdminAllInOneManagementFileVersionTrackerController extends ModuleAdminController
{
    public $version_is_modified;
    private $missing_files = [];
    private $changed_files = [];

    public function __construct()
    {
        $this->bootstrap = true;
        $this->module          = Module::getInstanceByName('allinonemanagement');
        $this->controller_name = 'AdminAllInOneManagementFileVersionTracker';
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

        $this->context->smarty->assign(array(
            'getChangedFilesList' => $this->getChangedFilesList(),
        ));

        Media::addJsDef([
            'configurationUrl' => $this->context->link->getAdminLink($this->controller_name),
        ]);

        parent::initContent();
    }

    public function display()
    {
        $this->ajax = true;
        $this->content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . 'allinonemanagement/views/templates/admin/fileVersionTracker.tpl'
        );

        parent::display();
    }

    // Upgrade.php

    /**
     * returns an array of files which are present in PrestaShop version $version and has been modified
     * in the current filesystem.
     *
     * @return array|false
     */
    public function getChangedFilesList($version = null, $refresh = false)
    {
        if (empty($version)) {
            //$version = $this->currentPsVersion;
            $version = _PS_VERSION_;
        }
        if (is_array($this->changed_files) && count($this->changed_files) == 0) {
            $checksum = $this->getXmlMd5File($version, $refresh);
            if ($checksum == false) {
                $this->changed_files = false;
            } else {
                $this->browseXmlAndCompare($checksum->ps_root_dir[0]);
            }
        }

        return $this->changed_files;
    }

    /**
     * return xml containing the list of all default PrestaShop files for version $version,
     * and their respective md5sum.
     *
     * @param string $version
     *
     * @return \SimpleXMLElement|false if error
     */
    public function getXmlMd5File($version, $refresh = false)
    {
        $rss_md5file_link_dir = 'https://api.prestashop.com/xml/md5/';
        $version_md5 = [];
        if (isset($version_md5[$version])) {
            return @simplexml_load_file($version_md5[$version]);
        }

        return $this->getXmlFile(_PS_MODULE_DIR_ . 'allinonemanagement/config/xml/' . $version . '.xml', $rss_md5file_link_dir . $version . '.xml', $refresh);
    }
    const DEFAULT_CHECK_VERSION_DELAY_HOURS = 12;

    public function getXmlFile($xml_localfile, $xml_remotefile, $refresh = false)
    {
        // @TODO : this has to be moved in autoupgrade.php > install method
        if (!is_dir(_PS_MODULE_DIR_ . 'allinonemanagement/config/xml/')) {
            if (is_file(_PS_MODULE_DIR_ . 'allinonemanagement/config/xml/')) {
                unlink(_PS_MODULE_DIR_ . 'allinonemanagement/config/xml/');
            }
            mkdir(_PS_MODULE_DIR_ . 'allinonemanagement/config/xml/', 0777);
        }
        if ($refresh || !file_exists($xml_localfile) || @filemtime($xml_localfile) < (time() - (3600 * self::DEFAULT_CHECK_VERSION_DELAY_HOURS))) {
            $xml_string = Tools::file_get_contents($xml_remotefile, false, stream_context_create(['http' => ['timeout' => 10]]));
            $xml = @simplexml_load_string($xml_string);
            if ($xml !== false) {
                file_put_contents($xml_localfile, $xml_string);
            }
        } else {
            $xml = @simplexml_load_file($xml_localfile);
        }

        return $xml;
    }

    /**
     * Compare the md5sum of the current files with the md5sum of the original.
     *
     * @param mixed $node
     * @param array $current_path
     * @param int $level
     */
    protected function browseXmlAndCompare($node, &$current_path = [], $level = 1)
    {
        foreach ($node as $key => $child) {
            if (is_object($child) && $child->getName() == 'dir') {
                $current_path[$level] = (string) $child['name'];
                $this->browseXmlAndCompare($child, $current_path, $level + 1);
            } elseif (is_object($child) && $child->getName() == 'md5file') {
                // We will store only relative path.
                // absolute path is only used for file_exists and compare
                $relative_path = '';
                for ($i = 1; $i < $level; ++$i) {
                    $relative_path .= $current_path[$i] . '/';
                }
                $relative_path .= (string) $child['name'];

                $fullpath = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . $relative_path;
                $fullpath = str_replace('ps_root_dir', _PS_ROOT_DIR_, $fullpath);

                // replace default admin dir by current one
                $fullpath = str_replace(_PS_ROOT_DIR_ . '/admin', _PS_ADMIN_DIR_, $fullpath);
                $fullpath = str_replace(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'admin', _PS_ADMIN_DIR_, $fullpath);
                if (!file_exists($fullpath)) {
                    $this->addMissingFile($relative_path);
                } elseif (!$this->compareChecksum($fullpath, (string) $child)) {
                    $this->addChangedFile($relative_path);
                }
                // else, file is original (and ok)
            }
        }
    }

    protected function compareChecksum($filepath, $md5sum)
    {
        return md5_file($filepath) == $md5sum;
    }

    /** populate $this->missing_files with $path
     * @param string $path filepath to add, relative to _PS_ROOT_DIR_
     */
    protected function addMissingFile($path)
    {
        $this->version_is_modified = true;
        $this->missing_files[] = $path;
    }

    /** populate $this->changed_files with $path
     * in sub arrays  mail, translation and core items.
     *
     * @param string $path filepath to add, relative to _PS_ROOT_DIR_
     */
    protected function addChangedFile($path)
    {
        $this->version_is_modified = true;

        if (strpos($path, 'mails/') !== false) {
            $this->changed_files['mail'][] = $path;
        } elseif (strpos($path, '/en.php') !== false || strpos($path, '/fr.php') !== false
            || strpos($path, '/es.php') !== false || strpos($path, '/it.php') !== false
            || strpos($path, '/de.php') !== false || strpos($path, 'translations/') !== false) {
            $this->changed_files['translation'][] = $path;
        } else {
            $this->changed_files['core'][] = $path;
        }
    }
}