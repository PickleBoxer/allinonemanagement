<?php

function normaliseHost($host)
{
    if (strpos($host, "http") !== 0) {
        $host = "http" . (strpos($host, "localhost") === 0 ? "" : "s") . "://" . $host;
    }
    return strpos($host, ".") !== false ? $host : ensureTrailingSlash($host);
}

function ensureTrailingSlash($url)
{
    if (substr($url, -1) !== '/') {
        $url .= '/';
    }
    return $url;
}

function isAbsolutePath($path)
{
    return strpos($path, $_SERVER['DOCUMENT_ROOT']) === 0;
}

function joinPaths($path1, $path2)
{
    return rtrim($path1, '/') . '/' . ltrim($path2, '/');
}
