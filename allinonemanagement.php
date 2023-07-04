<?php

/**
 * 2007-2023 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2023 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use AllInOneManagement\Assets\CriticalCss;
use Symfony\Component\Filesystem\Filesystem;
use PrestaShop\PrestaShop\Adapter\Configuration as ConfigurationAdapter;

class AllInOneManagement extends Module
{
    protected $config_form = false;

    /**
     * @var object CriticalCss
     */
    protected $criticalCss;
    protected $cccReducer;

    public function __construct()
    {
        $this->name = 'allinonemanagement';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Matic Vertacnik';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('All-in-one Management');
        $this->description = $this->l('All-in-one Management Module for Prestashop');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall my module?');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->criticalCss = new CriticalCss(
            _PS_THEME_DIR_ . 'assets/cache/',
            new ConfigurationAdapter(),
            new Filesystem()
        );
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('ALLINONEMANAGEMENT_CRITICALCSS', true);
        Configuration::updateValue('ALLINONEMANAGEMENT_LOGIN_AS_CUSTOMER', false);
        Configuration::updateValue('ALLINONEMANAGEMENT_CUSTOM_CSS', false);
        Configuration::updateValue('ALLINONEMANAGEMENT_CUSTOM_JS', false);

        include(dirname(__FILE__) . '/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('actionOutputHTMLBefore') &&
            $this->registerHook('actionFrontControllerSetMedia') &&
            $this->registerHook('hookActionClearCache') &&
            $this->registerHook('displayAdminCustomers') &&
            $this->addTab("AdminAllInOneManagement", "All-in-One Management", "0") &&
            $this->addTab("AdminAllInOneManagementDashboard", "Control center", "AdminAllInOneManagement") &&
            $this->addTab("AdminAllInOneManagementCriticalCss", "Critical CSS", "AdminAllInOneManagement") &&
            $this->addTab("AdminAllInOneManagementPhpInfo", "Php Info", "AdminAllInOneManagement") &&
            $this->addTab("AdminAllInOneManagementMysqlTuner", "Mysql Tuner", "AdminAllInOneManagement") &&
            $this->addTab("AdminAllInOneManagementPageSpeed", "PageSpeed Insights", "AdminAllInOneManagement") &&
            $this->addTab("AdminAllInOneManagementFileVersionTracker", "File Version Tracker", "AdminAllInOneManagement");
    }

    public function uninstall()
    {

        Configuration::deleteByName('ALLINONEMANAGEMENT_CRITICALCSS');
        Configuration::deleteByName('ALLINONEMANAGEMENT_CUSTOM_CSS');
        Configuration::deleteByName('ALLINONEMANAGEMENT_CUSTOM_JS');
        Configuration::deleteByName('ALLINONEMANAGEMENT_LOGIN_AS_CUSTOMER');

        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall() &&
            $this->deleteTab("AdminAllInOneManagement") &&
            $this->deleteTab("AdminAllInOneManagementDashboard") &&
            $this->deleteTab("AdminAllInOneManagementCriticalCss") &&
            $this->deleteTab("AdminAllInOneManagementPhpInfo") &&
            $this->deleteTab("AdminAllInOneManagementFileVersionTracker") &&
            $this->deleteTab("AdminAllInOneManagementPageSpeed") &&
            $this->deleteTab("AdminAllInOneManagementMysqlTuner");
    }

    /**
     * add tab
     */
    public function addTab($className, $name, $parentClassName)
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $className;
        $tab->name = array();
        $tab->name[(int)(Configuration::get('PS_LANG_DEFAULT'))] = $this->l($name);
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName($parentClassName);
        return $tab->add();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        global $cookie;
        header('Location: index.php?tab=AdminAllInOneManagementDashboard&token=' . md5(pSQL(_COOKIE_KEY_ . 'AdminAllInOneManagementDashboard' . (int) Tab::getIdFromClassName('AdminAllInOneManagementDashboard') . (int) $cookie->id_employee)));
        exit;
    }

    /**
     * Register the current module to a given hook and moves it at the first position.
     *
     * @param string $hookName
     *
     * @return bool
     */
    public function registerHookAndSetToTop($hookName)
    {
        return $this->registerHook($hookName) && $this->updatePosition((int) Hook::getIdByName($hookName), false);
    }

    /**
     * Delete tab
     */
    protected function deleteTab($className)
    {
        $id_tab = (int)Tab::getIdFromClassName($className);
        $allTableDeleted = true;
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $allTableDeleted = $tab->delete();
        } else {
            return false;
        }
        return $allTableDeleted;
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $customcss = Configuration::get('ALLINONEMANAGEMENT_CUSTOM_CSS', true);
        $customjs = Configuration::get('ALLINONEMANAGEMENT_CUSTOM_JS', true);

        if ($customcss) {
            $this->context->controller->addCSS($this->_path . '/views/css/front.css');
        }

        if ($customjs) {
            $this->context->controller->addJS($this->_path . '/views/js/front.js');
        }
    }

    /**
     * This function is a hook that runs before the HTML output is generated on the front-end of the website.
     * It takes in a single parameter $params which is an array of variables that can be modified before the final HTML output is generated.
     */
    public function hookActionOutputHTMLBefore($params)
    {
        if (Configuration::get('ALLINONEMANAGEMENT_CRITICALCSS')) {
            // Get the class name of the current controller
            $controllerName = $this->context->controller->php_self;

            $params['html'] = $this->criticalCss->process($params['html'], $controllerName);
        }
    }

    public function hookDisplayAdminCustomers($params)
    {
        if (Configuration::get('ALLINONEMANAGEMENT_LOGIN_AS_CUSTOMER')) {
            $customer = new CustomerCore($params['id_customer']);
            $link = $this->context->link->getModuleLink($this->name, 'login', array('id_customer' => $customer->id, 'xtoken' => $this->makeToken($customer->id)));

            if (!Validate::isLoadedObject($customer)) {
                return;
            }

            return '<li id="customer-login">
                <a id="page-header-desc-customer-modules-list" class="toolbar_btn" href="' . $link . '" target="_blank" title="' . $this->l("Login As Customer") . '">
                  <i class="process-icon- icon-sign-in"></i>
                  <div>' . $this->l("Login As Customer") . '</div>
                </a>
              </li>
              <script>
            $(document).ready(function() {
                // Move the button to a desired position
                $("#customer-login").appendTo("#toolbar-nav");
            });
         </script>';
        }
    }

    public function makeToken($id_customer)
    {
        return md5(_COOKIE_KEY_ . $id_customer . date("Ymd"));
    }
}
