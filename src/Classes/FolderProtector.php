<?php

declare(strict_types=1);

namespace AllInOneManagement\Classes;

class FolderProtector
{
    const HTACCESS_FILE = _PS_ROOT_DIR_ . '/.htaccess';
    const HTPASSWD_FILE = _PS_ROOT_DIR_ . '/.htpasswd';

    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function isProtected()
    {
        if (file_exists(self::HTACCESS_FILE)) {
            $content = file_get_contents(self::HTACCESS_FILE);
            if (strpos($content, '# BEGIN MyFolderProtectorClass start') !== false) {
                return true;
            }
        }
        return false;
    }

    public function protect()
    {
        if ($this->isProtected()) {
            return;
        }

        $htaccessContent = $this->generateHtaccessFile();
        $htpasswdContent = $this->generateHtpasswdFile();

        file_put_contents(self::HTACCESS_FILE, $htaccessContent);
        file_put_contents(self::HTPASSWD_FILE, $htpasswdContent);
    }

    public function unprotect()
    {
        if (!$this->isProtected()) {
            return;
        }

        $htaccessContent = file_get_contents(self::HTACCESS_FILE);
        $newHtaccessContent = preg_replace('#\# BEGIN MyFolderProtectorClass start.*?\# END MyFolderProtectorClass end[^\n]*\n?#s', '', $htaccessContent);

        if ($newHtaccessContent !== $htaccessContent) {
            file_put_contents(self::HTACCESS_FILE, $newHtaccessContent);
        }

        $htpasswdContent = file_get_contents(self::HTPASSWD_FILE);
        $newHtpasswdContent = preg_replace('#\# BEGIN MyFolderProtectorClass start.*?\# END MyFolderProtectorClass end[^\n]*\n?#s', '', $htpasswdContent);
        if ($newHtpasswdContent !== $htpasswdContent) {
            file_put_contents(self::HTPASSWD_FILE, $newHtpasswdContent);
        }

    }

    private function generateHtaccessFile()
    {
        // Check current content of .htaccess and save all code outside of MyFolderProtectorClass comments
        $specific_before = $specific_after = '';
        if (file_exists(self::HTACCESS_FILE)) {
            $content = file_get_contents(self::HTACCESS_FILE);
            if (preg_match('#^(.*)\# BEGIN MyFolderProtectorClass start.*\# END MyFolderProtectorClass end[^\n]*(.*)$#s', $content, $m)) {
                $specific_before = $m[1];
                $specific_after = $m[2];
            } else {
                $specific_before = $content;
            }
        }

        // Write .htaccess data
        if ($specific_before) {
            $htaccessContent = trim($specific_before) . "\n\n";
        } else {
            $htaccessContent = '';
        }
        $htaccessContent .= "# BEGIN MyFolderProtectorClass start - Do not remove this comment, MyFolderProtectorClass will keep automatically the code outside this comment when .htaccess will be generated again\n";
        $htaccessContent .= "AuthUserFile " . self::HTPASSWD_FILE . "\n";
        $htaccessContent .= "AuthName 'Restricted Area'\n";
        $htaccessContent .= "AuthType Basic\n";
        $htaccessContent .= "require valid-user\n";
        $htaccessContent .= "# END MyFolderProtectorClass end - Do not remove this comment, MyFolderProtectorClass will keep automatically the code outside this comment when .htaccess will be generated again\n";

        if ($specific_after) {
            $htaccessContent .= "\n\n" . trim($specific_after);
        }

        return $htaccessContent;
    }

    private function generateHtpasswdFile()
    {
        // Check current content of .htaccess and save all code outside of MyFolderProtectorClass comments
        $specific_before = $specific_after = '';
        if (file_exists(self::HTPASSWD_FILE)) {
            $content = file_get_contents(self::HTPASSWD_FILE);
            if (preg_match('#^(.*)\# BEGIN MyFolderProtectorClass start.*\# END MyFolderProtectorClass end[^\n]*(.*)$#s', $content, $m)) {
                $specific_before = $m[1];
                $specific_after = $m[2];
            } else {
                $specific_before = $content;
            }
        }

        // Write .htaccess data
        if ($specific_before) {
            $htpasswdContent = trim($specific_before) . "\n\n";
        } else {
            $htpasswdContent = '';
        }

        $htpasswdContent .= "# BEGIN MyFolderProtectorClass start - Do not remove this comment, MyFolderProtectorClass will keep automatically the code outside this comment when .htaccess will be generated again\n";
        $htpasswdContent .= $this->username . ":" . password_hash($this->password, PASSWORD_BCRYPT) ." \n";
        $htpasswdContent .= "# END MyFolderProtectorClass end - Do not remove this comment, MyFolderProtectorClass will keep automatically the code outside this comment when .htaccess will be generated again\n";

        if ($specific_after) {
            $htpasswdContent .= "\n\n" . trim($specific_after);
        }

        return $htpasswdContent;
    }
}
