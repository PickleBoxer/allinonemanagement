<?php

use AllInOneManagement\Classes\FolderProtector;
use AllInOneManagement\Adapter\DebugProfilingMode;
use PrestaShop\PrestaShop\Adapter\Debug\DebugMode;

class AdminAllInOneManagementDashboardController extends ModuleAdminController
{
  /**
   * @var DebugMode $debugMode Debug mode manager
   */
  private $debugMode;
  /**
   * @var DebugProfilingMode $debugProfilingMode Debug Profiling mode manager
   */
  private $debugProfilingMode;

  private $module_path;

  // Implement your logic and display methods here
  public function __construct()
  {
    $this->bootstrap       = true;
    $this->module          = Module::getInstanceByName('allinonemanagement');
    $this->controller_name = 'AdminAllInOneManagementDashboard';
    $this->ajax            = true;

    parent::__construct();

    $this->debugMode = new DebugMode;
    $this->debugProfilingMode = new DebugProfilingMode;
    $this->module_path = _PS_MODULE_DIR_ . 'allinonemanagement';
  }

  public function initPageHeaderToolbar()
  {
    $this->page_header_toolbar_title = $this->l('All-in-one Management');

    $this->page_header_toolbar_btn = array();
    $this->page_header_toolbar_btn['new_item'] = array(
      'href' => $this->context->link->getAdminLink('AdminDashboard'),
      'desc' => $this->l('Back to list'),
      'icon' => 'process-icon-back'
    );

    $this->context->smarty->assign(array(
      'page_header_toolbar_title' => $this->page_header_toolbar_title,
      'page_header_toolbar_btn' => $this->page_header_toolbar_btn,
    ));

    parent::initPageHeaderToolbar();
  }

  public function initContent()
  {
    $overrideFiles = Tools::scandir($this->module->getLocalPath() . 'override', 'php', '', true);
    $statusOverrideFiles = array();

    foreach ($overrideFiles as $overrideFile) {
      $overrideFileName = basename($overrideFile);
      if ($overrideFileName === 'index.php') {
        continue; // skip files with basename index.php
      }
      $status = (strpos($overrideFileName, '_') === 0) ? 'disabled' : 'enabled';
      $statusOverrideFiles[] = array(
        'filepath' => $overrideFile,
        'status' => $status
      );
    }

    //dump($this);
    $this->context->controller->addCSS(_PS_MODULE_DIR_ . 'allinonemanagement/views/css/back.css');
    Media::addJsDef([
      'configurationUrl' => $this->context->link->getAdminLink($this->controller_name),
      'devMode' => $this->debugMode->isDebugModeEnabled(),
      'debugProfiling' => $this->debugProfilingMode->isDebugProfilingModeEnabled(),
      'criticalCss' => Configuration::get('ALLINONEMANAGEMENT_CRITICALCSS'),
      'folderProtector' => FolderProtector::isProtected(),
      'loginAsCustomer' => Configuration::get('ALLINONEMANAGEMENT_LOGIN_AS_CUSTOMER', false),
      'customCss' => Configuration::get('ALLINONEMANAGEMENT_CUSTOM_CSS', false),
      'customJs' => Configuration::get('ALLINONEMANAGEMENT_CUSTOM_JS', false),
      'customCssValue' => file_get_contents(_PS_MODULE_DIR_ . 'allinonemanagement/views/css/front.css'),
      'customJsValue' => file_get_contents(_PS_MODULE_DIR_ . 'allinonemanagement/views/js/front.js'),
      'overrideFiles' => $statusOverrideFiles,
      // add tables with count of rows
      'tablesToOptimize' => $this->getTablesToOptimize(),
    ]);

    $this->context->smarty->assign([
      'image_path' => $this->module->getPathUri() . 'views/img/',
    ]);

    // Render the template
    $this->content = $this->context->smarty->fetch(
      _PS_MODULE_DIR_ . 'allinonemanagement/views/templates/admin/dashboard.tpl'
    );

    parent::initContent();
  }

  /**
   * This method is an AJAX endpoint that toggles the filename of an override file.
   * If the filename starts with an underscore, it removes it. Otherwise, it adds an underscore to the beginning of the filename.
   *
   * @return void
   */
  public function ajaxProcessToggleOverrideFileName()
  {
    // Get the override file name and status values from POST request.
    $overridePath = trim(Tools::getValue('document_name'));
    $overridePathFull = $this->module->getLocalPath() . 'override' . DIRECTORY_SEPARATOR . $overridePath;
    $overrideFileName = basename($overridePathFull);

    // if overrideFileName basename starts with _ than remove it otherwise add it
    try {
      if (strpos($overrideFileName, '_') === 0) {
        $newOverrideFileName = substr($overrideFileName, 1);
      } else {
        $this->module->uninstallOverrides();
        $newOverrideFileName = '_' . $overrideFileName;
      }

      $newOverridePathFull = str_replace($overrideFileName, $newOverrideFileName, $overridePathFull);
      rename($overridePathFull, $newOverridePathFull);

      $overrideFiles = Tools::scandir($this->module->getLocalPath() . 'override', 'php', '', true);
      $statusOverrideFiles = array();

      foreach ($overrideFiles as $overrideFile) {
        $overrideFileName = basename($overrideFile);
        if ($overrideFileName === 'index.php') {
          continue; // skip files with basename index.php
        }
        $status = (strpos($overrideFileName, '_') === 0) ? 'disabled' : 'enabled';
        $statusOverrideFiles[] = array(
          'filepath' => $overrideFile,
          'status' => $status
        );
      }

      // Construct the response message array with default values
      $responseMsg = [
        'hasError' => false,
        'successMessage' => 'Override file name changed successfully',
        'overrideFiles' => $statusOverrideFiles,
      ];
    } catch (\Throwable $e) {
      // Handle any exceptions that occur and return an error message.
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => $e->getMessage(),
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  public function getTablesToOptimize()
  {
    $tables = [
      'cart' => [
        'name' => 'Cart',
        'description' => 'Remove any abandoned carts that do not have orders linked to them.',
        'icon' => 'shopping_cart'
      ],
      'guest' => [
        'name' => 'Guest',
        'description' => 'Remove all Guests from the database.',
        'icon' => 'person'
      ],
      'connections' => [
        'name' => 'Connections',
        'description' => 'Remove all Connection informations from the database.',
        'icon' => 'link'
      ],
      'connections_page' => [
        'name' => 'Connections Page',
        'description' => 'Remove all Connection informations page from the database.',
        'icon' => 'link'
      ],
      'connections_source' => [
        'name' => 'Connections Source',
        'description' => 'Remove all Connection informations source from the database.',
        'icon' => 'link'
      ]
    ];

    $tableData = array();

    foreach ($tables as $table => $data) {
      $tableData[$table] = array(
        'table' => $table,
        'count' => $this->tableRowCounter($table),
        'name' => $data['name'],
        'description' => $data['description'],
        'icon' => $data['icon']
      );
    }

    return $tableData;
  }

  public function ajaxProcessOptimizeDatabase()
  {
    $table = Tools::getValue('table');

    try {
      $this->optimizeDatabase($table);
      $responseMsg = [
        'hasError' => false,
        'successMessage' => $table . ' Database optimized successfully',
      ];
    } catch (\Throwable $e) {
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => $e->getMessage(),
      ];
    }

    die(json_encode($responseMsg));
  }

  private function optimizeDatabase($table)
  {
    if ($table == "cart") {
      Configuration::updateValue('ALLINONEMANAGEMENT' . $table, date("Y-m-d h:i:s"));
      Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('DELETE FROM `' . _DB_PREFIX_ . $table . '` WHERE id_cart not in (SELECT id_cart from ' . _DB_PREFIX_ . 'orders)');
    } else {
      Configuration::updateValue('ALLINONEMANAGEMENT' . $table, date("Y-m-d h:i:s"));
      Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('DELETE FROM `' . _DB_PREFIX_ . $table . '`');
    }
  }

  public function tableRowCounter($table)
  {
    if ($table == "cart") {
      $query = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT count(*) AS count FROM `' . _DB_PREFIX_ . $table . '` WHERE id_cart not in (SELECT id_cart from ' . _DB_PREFIX_ . 'orders)');
    } else {
      $query = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT count(*) AS count FROM `' . _DB_PREFIX_ . $table . '`');
    }
    return $query[0]['count'];
  }

  /**
   * This method is an AJAX endpoint that applies any changes made to override files.
   *
   * @return void
   */
  public function ajaxProcessApplyOverrideChanges()
  {
    try {
      // Uninstall overrides from the override folder
      $this->module->uninstallOverrides();
      // Install overrides from the override folder
      $this->module->installOverrides();

      // Construct the response message array with default values
      $responseMsg = [
        'hasError' => false,
        'successMessage' => 'Overrides applied successfully',
      ];
    } catch (\Throwable $e) {
      // Handle any exceptions that occur and return an error message.
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => $e->getMessage(),
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  /**
   * ajaxProcessClearAllCache()
   *
   * This function is used to handle an AJAX request that clears all cache at once.
   * It uses the Tools::clearAllCache() method to clear all cache.
   * The function constructs a response message array which contains information
   * about the success or failure of the cache clearing operation along with any error messages.
   * Finally, it encodes the response message array into JSON format and outputs it as the response.
   *
   * @param void
   * @return void (dies with the encoded response message)
   */
  public function ajaxProcessClearAllCache()
  {
    try {
      // clear all cache at once
      Tools::clearAllCache();

      // Construct the response message array with default values
      $responseMsg = [
        'hasError' => false,
        'successMessage' => 'Cache cleared successfully',
      ];
    } catch (\Throwable $e) {
      // Handle any exceptions that occur and return an error message.
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => $e->getMessage(),
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  /**
   * ajaxProcessToggleDeveloperMode()
   *
   * This function is used to handle an AJAX request that toggles the developer mode.
   * The enableStatus parameter from the request payload is used to update the debug mode.
   * The function constructs a response message array which contains information
   * about the success or failure of the update operation along with any error messages.
   * Finally, it encodes the response message array into JSON format and outputs it as the response.
   *
   * @param void
   * @return void (dies with the encoded response message)
   */
  public function ajaxProcessToggleDeveloperMode()
  {
    // Get the enableStatus parameter from the request payload
    $getStatus = Tools::getValue('enableStatus');

    // Convert the enableStatus parameter to a boolean value using FILTER_VALIDATE_BOOLEAN, with NULL on failure
    $boolStatus = filter_var($getStatus, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    // Update the debug mode based on the value of boolStatus
    $status = $this->updateDebugMode($boolStatus);

    // Construct the response message array with default values
    $responseMsg = [
      'hasError' => false,
      'successMessage' => 'Developer mode turned on',
      'devMode' => $status
    ];

    // Check for known error types and populate the $responseMsg array accordingly
    switch ($status) {
      case DebugMode::DEBUG_MODE_ERROR_NO_WRITE_ACCESS:
        $responseMsg['hasError'] = true;
        $responseMsg['errorMessage'] = 'Error: Could not write to file. Make sure that the correct permissions are set on the file %s';
        break;
      case DebugMode::DEBUG_MODE_ERROR_NO_DEFINITION_FOUND:
        $responseMsg['hasError'] = true;
        $responseMsg['errorMessage'] = 'Error: Could not find whether debug mode is enabled. Make sure that the correct permissions are set on the file %s';
        break;
      case DebugMode::DEBUG_MODE_ERROR_NO_WRITE_ACCESS_CUSTOM:
      case DebugMode::DEBUG_MODE_ERROR_NO_READ_ACCESS:
        $responseMsg['hasError'] = true;
        $responseMsg['errorMessage'] = 'Error: Could not access the debug mode file. Make sure that the correct permissions are set on the file %s';
        break;
      default:
        break;
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }


  /**
   * ajaxProcessToggleDebugProfiling()
   *
   * This function is used to handle an AJAX request that toggles the debug profiling mode. It gets the current state of the 
   * debug profiling and toggles it accordingly by defining _PS_DEBUG_PROFILING_ as either true or false.
   * The function constructs a response message array with information about the success or failure of the operation
   * along with the new state of debug profiling. Finally, it encodes the response message array into JSON format and
   * outputs it as the response.
   *
   * @param void
   * @return void (dies with the encoded response message)
   */
  public function ajaxProcessToggleDebugProfiling()
  {
    // Get the enableStatus parameter from the request payload
    $getStatus = Tools::getValue('enableStatus');

    // Convert the enableStatus parameter to a boolean value using FILTER_VALIDATE_BOOLEAN, with NULL on failure
    $boolStatus = filter_var($getStatus, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    // Update the debug mode based on the value of boolStatus
    $status = $this->updateDebugProfilingMode($boolStatus);

    // Construct the response message array with default values
    $responseMsg = [
      'hasError' => false,
      'successMessage' => 'Debug Profiling mode turned on',
      'devMode' => $status
    ];

    // Check for known error types and populate the $responseMsg array accordingly
    switch ($status) {
      case DebugMode::DEBUG_MODE_ERROR_NO_WRITE_ACCESS:
        $responseMsg['hasError'] = true;
        $responseMsg['errorMessage'] = 'Error: Could not write to file. Make sure that the correct permissions are set on the file %s';
        break;
      case DebugMode::DEBUG_MODE_ERROR_NO_DEFINITION_FOUND:
        $responseMsg['hasError'] = true;
        $responseMsg['errorMessage'] = 'Error: Could not find whether debug profiling mode is enabled. Make sure that the correct permissions are set on the file %s';
        break;
      case DebugMode::DEBUG_MODE_ERROR_NO_WRITE_ACCESS_CUSTOM:
      case DebugMode::DEBUG_MODE_ERROR_NO_READ_ACCESS:
        $responseMsg['hasError'] = true;
        $responseMsg['errorMessage'] = 'Error: Could not access the debug profiling mode file. Make sure that the correct permissions are set on the file %s';
        break;
      default:
        break;
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  /**
   * This function processes an AJAX request to toggle the critical css status by updating the configuration value.
   * It expects a POST request with a 'status' parameter that is expected to be a boolean value in string format, 
   * which is validated using PHP's filter_var() function with options for null response on failure. 
   * If the 'status' parameter is successfully validated and updated in the Configuration, it returns a JSON response message with 
   *  - 'hasError': false indicating no errors occurred,
   *  - 'successMessage': Message indicating whether the Critical CSS has been turned ON or OFF.
   * Otherwise, if the 'status' parameter fails validation and/or update process, it returns a JSON response message with
   *  - 'hasError': true indicating an error occurred,
   *  - 'errorMessage': A message indicating why the validation or update failed.
   * The response message is encoded as an array in JSON format using PHP's die() function.
   *
   * @return void
   */
  public function ajaxProcessToggleCriticalCss()
  {
    $status = Tools::getValue('status');
    $boolStatus = filter_var($status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    if (is_bool($boolStatus)) {
      // Update the configuration value if the 'status' parameter is a valid boolean value
      Configuration::updateValue('ALLINONEMANAGEMENT_CRITICALCSS', $boolStatus);
      $responseMsg = [
        'hasError' => false,
        'successMessage' => ($boolStatus) ? 'Critical css turned on' : 'Critical css turned off',
      ];
    } else {
      // Return an error message if the 'status' parameter is not a valid boolean value
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Invalid status parameter format',
      ];
    }

    // This cache is stored in themes/your-theme/assets/cache directory
    // clear this cache, use this method:
    Media::clearCache();

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  public function ajaxProcessToggleLoginAsCustomer()
  {
    $status = Tools::getValue('status');
    $boolStatus = filter_var($status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    if (is_bool($boolStatus)) {
      // Update the configuration value if the 'status' parameter is a valid boolean value
      Configuration::updateValue('ALLINONEMANAGEMENT_LOGIN_AS_CUSTOMER', $boolStatus);
      $responseMsg = [
        'hasError' => false,
        'successMessage' => ($boolStatus) ? 'Login as customer turned on' : 'Login as customer turned off',
      ];
    } else {
      // Return an error message if the 'status' parameter is not a valid boolean value
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Invalid status parameter format',
      ];
    }

    // This cache is stored in themes/your-theme/assets/cache directory
    // clear this cache, use this method:
    Media::clearCache();

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  public function ajaxProcessToggleFolderProtector()
  {
    $status = Tools::getValue('status');
    $boolStatus = filter_var($status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    if (is_bool($boolStatus)) {
      // Create instance and call generateHtaccessFile() method
      $folderProtector = new FolderProtector('admin', 'admin');
      //$htaccessContent = $folderProtector->protect();
      if ($boolStatus) {
        $htaccessContent = $folderProtector->protect();
      } else {
        $htaccessContent = $folderProtector->unprotect();
      }

      $responseMsg = [
        'hasError' => false,
        'successMessage' => ($boolStatus) ? 'Folder protection turned on' : 'Folder protection turned off',
      ];
    } else {
      // Return an error message if the 'status' parameter is not a valid boolean value
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Invalid status parameter format',
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  /**
   * ajaxProcessToggleCustomCss function
   *
   * This function toggles the state of custom CSS functionality based on an AJAX request.
   * It receives a 'status' parameter in the request payload, which should be a boolean value.
   * The configuration value for 'ALLINONEMANAGEMENT_CUSTOM_CSS' is updated with the opposite boolean value.
   * Once the configuration value is updated, a response message array is generated and output as a JSON-encoded string.
   *
   * @return void
   */
  public function ajaxProcessToggleCustomCss()
  {
    $status = Tools::getValue('status');
    $boolStatus = filter_var($status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);


    if (is_bool($boolStatus)) {
      Configuration::updateValue('ALLINONEMANAGEMENT_CUSTOM_CSS', $boolStatus);

      $responseMsg = [
        'hasError' => false,
        'successMessage' => ($boolStatus) ? 'Custom css turned on' : 'Custom css turned off',
      ];
    } else {
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Invalid status parameter format',
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  public function ajaxProcessSaveCustomCss()
  {
    $content = Tools::getValue('customCssValue');
    $filename = _PS_MODULE_DIR_ . 'allinonemanagement/views/css/front.css';

    $result = file_put_contents($filename, $content);

    if ($result !== false) {
      $responseMsg = [
        'hasError' => false,
        'successMessage' => 'File saved successfully',
      ];
    } else {
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Error saving file',
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  /**
   * ajaxProcessToggleCustomJs function
   *
   * This function toggles the state of custom Js functionality based on an AJAX request.
   * It receives a 'status' parameter in the request payload, which should be a boolean value.
   * The configuration value for 'ALLINONEMANAGEMENT_CUSTOM_JS' is updated with the opposite boolean value.
   * Once the configuration value is updated, a response message array is generated and output as a JSON-encoded string.
   *
   * @return void
   */
  public function ajaxProcessToggleCustomJs()
  {
    $status = Tools::getValue('status');
    $boolStatus = filter_var($status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);


    if (is_bool($boolStatus)) {
      Configuration::updateValue('ALLINONEMANAGEMENT_CUSTOM_JS', $boolStatus);

      $responseMsg = [
        'hasError' => false,
        'successMessage' => ($boolStatus) ? 'Custom js turned on' : 'Custom js turned off',
      ];
    } else {
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Invalid status parameter format',
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  public function ajaxProcessSaveCustomJs()
  {
    $content = Tools::getValue('customJsValue');
    $filename = _PS_MODULE_DIR_ . 'allinonemanagement/views/js/front.js';

    $result = file_put_contents($filename, $content);

    if ($result !== false) {
      $responseMsg = [
        'hasError' => false,
        'successMessage' => 'File saved successfully',
      ];
    } else {
      $responseMsg = [
        'hasError' => true,
        'errorMessage' => 'Error saving file',
      ];
    }

    // Encode the response message array to JSON format and output it as the response
    die(json_encode($responseMsg));
  }

  /**
   * Change Debug mode value if needed
   *
   * @param $enableStatus
   * @return int the status of update
   */
  private function updateDebugMode($enableStatus)
  {
    $currentDebugMode = $this->debugMode->isDebugModeEnabled();

    if ($enableStatus !== $currentDebugMode) {
      return (true === $enableStatus) ? $this->debugMode->enable() : $this->debugMode->disable();
    }
  }

  /**
   * Change Debug Profiling mode value if needed
   *
   * @param $enableStatus
   * @return int the status of update
   */
  private function updateDebugProfilingMode($enableStatus)
  {
    $currentDebugMode = $this->debugProfilingMode->isDebugProfilingModeEnabled();

    if ($enableStatus !== $currentDebugMode) {
      return (true === $enableStatus) ? $this->debugProfilingMode->enable() : $this->debugProfilingMode->disable();
    }
  }
}
