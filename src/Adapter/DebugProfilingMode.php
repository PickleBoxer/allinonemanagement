<?php

declare(strict_types=1);

namespace AllInOneManagement\Adapter;

use Tools;

/**
 * Utilitary class to manages the Debug Profiling mode legacy application
 */
class DebugProfilingMode
{
    const DEBUG_PROFILING_MODE_SUCCEEDED = 0;
    const DEBUG_PROFILING_MODE_ERROR_NO_READ_ACCESS = 1;
    const DEBUG_PROFILING_MODE_ERROR_NO_READ_ACCESS_CUSTOM = 2;
    const DEBUG_PROFILING_MODE_ERROR_NO_WRITE_ACCESS = 3;
    const DEBUG_PROFILING_MODE_ERROR_NO_WRITE_ACCESS_CUSTOM = 4;
    const DEBUG_PROFILING_MODE_ERROR_NO_DEFINITION_FOUND = 5;

    /**
     * Is Debug Profiling Mode enabled? Checks on custom defines file first
     *
     * @return bool Whether debug profiling mode is enabled
     */
    public function isDebugProfilingModeEnabled()
    {
        $definesClean = '';
        $customDefinesPath = _PS_ROOT_DIR_.'/config/defines_custom.inc.php';
        $definesPath = _PS_ROOT_DIR_.'/config/defines.inc.php';

        if (is_readable($customDefinesPath)) {
            $definesClean = php_strip_whitespace($customDefinesPath);
        }

        if (!preg_match('/define\(\'_PS_DEBUG_PROFILING_\', ([a-zA-Z]+)\);/Ui', $definesClean, $profilingModeValue)) {
            $definesClean = php_strip_whitespace($definesPath);
            if (!preg_match('/define\(\'_PS_DEBUG_PROFILING_\', ([a-zA-Z]+)\);/Ui', $definesClean, $profilingModeValue)) {
                return false;
            }
        }

        return 'true' === Tools::strtolower($profilingModeValue[1]);
    }

    /**
     * Enable Debug Profiling mode
     *
     * @return int Whether changing debug profiling mode succeeded or error code
     */
    public function enable()
    {
        return $this->changePsModeProfValue('true');
    }

    /**
     * Disable profiling mode
     *
     * @return int Whether changing profiling mode succeeded or error code
     */
    public function disable()
    {
        return $this->changePsModeProfValue('false');
    }

    /**
     * Check read permission on custom defines.inc.php
     *
     * @return bool Whether the file can be read
     */
    private function isCustomDefinesReadable()
    {
        return is_readable(_PS_ROOT_DIR_.'/config/defines_custom.inc.php');
    }

    /**
     * Check read permission on main defines.inc.php
     *
     * @return bool Whether the file can be read
     */
    private function isMainDefinesReadable()
    {
        return is_readable(_PS_ROOT_DIR_.'/config/defines.inc.php');
    }

    /**
     * Update Debug Profiling Mode value in main defines file
     *
     * @param string $value should be "true" or "false"
     * @return int the debug profiling mode
     */
    private function updateDebugProfilingModeValueInMainFile($value)
    {
        $filename = _PS_ROOT_DIR_.'/config/defines.inc.php';
        $cleanedFileContent = php_strip_whitespace($filename);
        $fileContent = Tools::file_get_contents($filename);

        if (!preg_match('/define\(\'_PS_DEBUG_PROFILING_\', ([a-zA-Z]+)\);/Ui', $cleanedFileContent)) {
            return self::DEBUG_PROFILING_MODE_ERROR_NO_DEFINITION_FOUND;
        }

        $fileContent = preg_replace('/define\(\'_PS_DEBUG_PROFILING_\', ([a-zA-Z]+)\);/Ui', 'define(\'_PS_DEBUG_PROFILING_\', '. $value .');', $fileContent);
        if (!@file_put_contents($filename, $fileContent)) {
            return self::DEBUG_PROFILING_MODE_ERROR_NO_WRITE_ACCESS;
        }

        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($filename);
        }

        return self::DEBUG_PROFILING_MODE_SUCCEEDED;
    }

    /**
     * Update Debug Profiling Mode value in custom defines file
     *
     * @param string $value should be "true" or "false"
     * @return int the debug profiling mode
     */
    private function updateDebugProfilingModeValueInCustomFile($value)
    {
        $customFileName = _PS_ROOT_DIR_.'/config/defines_custom.inc.php';
        $cleanedFileContent = php_strip_whitespace($customFileName);
        $fileContent = Tools::file_get_contents($customFileName);

        if (!empty($cleanedFileContent) && preg_match('/define\(\'_PS_DEBUG_PROFILING_\', ([a-zA-Z]+)\);/Ui', $cleanedFileContent)) {
            $fileContent = preg_replace('/define\(\'_PS_DEBUG_PROFILING_\', ([a-zA-Z]+)\);/Ui', 'define(\'_PS_DEBUG_PROFILING_\', '. $value .');', $fileContent);

            if (!@file_put_contents($customFileName, $fileContent)) {
                return self::DEBUG_PROFILING_MODE_ERROR_NO_WRITE_ACCESS_CUSTOM;
            }

            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($customFileName);
            }

            return self::DEBUG_PROFILING_MODE_SUCCEEDED;
        }
    }

    /**
     * Change value of _PS_DEBUG_PROFILING_ constant
     *
     * @param string $value should be "true" or "false"
     * @return int the debug profiling mode
     */
    private function changePsModeProfValue($value)
    {
        // Check custom defines file first
        if ($this->isCustomDefinesReadable()) {
            return $this->updateDebugProfilingModeValueInCustomFile($value);
        }

        if ($this->isMainDefinesReadable()) {
            return $this->updateDebugProfilingModeValueInMainFile($value);
        } else {
            return self::DEBUG_PROFILING_MODE_ERROR_NO_READ_ACCESS;
        }
    }
}