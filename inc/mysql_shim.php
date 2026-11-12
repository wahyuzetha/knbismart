<?php
/**
 * Drop-in MySQL to MySQLi Compatibility Shim
 * Enables legacy PHP 5 mysql_* code to run seamlessly on PHP 7.x and PHP 8.x
 */

if (!function_exists('mysql_connect')) {
    global $__global_mysql_link;
    $__global_mysql_link = null;

    if (!defined('MYSQL_ASSOC')) define('MYSQL_ASSOC', MYSQLI_ASSOC);
    if (!defined('MYSQL_NUM')) define('MYSQL_NUM', MYSQLI_NUM);
    if (!defined('MYSQL_BOTH')) define('MYSQL_BOTH', MYSQLI_BOTH);

    function mysql_connect($server = 'localhost', $username = '', $password = '', $new_link = false, $client_flags = 0) {
        global $__global_mysql_link;
        $port = 3306;
        $host = $server;
        if (strpos($server, ':') !== false) {
            list($host, $port) = explode(':', $server, 2);
        }
        $link = @mysqli_connect($host, $username, $password, '', (int)$port);
        if ($link) {
            $__global_mysql_link = $link;
            @mysqli_query($link, "SET sql_mode=''");
            return $link;
        }
        return false;
    }

    function mysql_select_db($database_name, $link_identifier = null) {
        global $__global_mysql_link;
        $link = $link_identifier ?: $__global_mysql_link;
        if (!$link) return false;
        return mysqli_select_db($link, $database_name);
    }

    function mysql_query($query, $link_identifier = null) {
        global $__global_mysql_link;
        $link = $link_identifier ?: $__global_mysql_link;
        if (!$link) return false;
        return mysqli_query($link, $query);
    }

    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_array($result, $result_type);
    }

    function mysql_fetch_assoc($result) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_assoc($result);
    }

    function mysql_fetch_row($result) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_row($result);
    }

    function mysql_num_rows($result) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_num_rows($result);
    }

    function mysql_real_escape_string($unescaped_string, $link_identifier = null) {
        global $__global_mysql_link;
        $link = $link_identifier ?: $__global_mysql_link;
        if (!$link) {
            return addslashes($unescaped_string ?? '');
        }
        return mysqli_real_escape_string($link, (string)($unescaped_string ?? ''));
    }

    function mysql_escape_string($unescaped_string) {
        return mysql_real_escape_string($unescaped_string);
    }

    function mysql_error($link_identifier = null) {
        global $__global_mysql_link;
        $link = $link_identifier ?: $__global_mysql_link;
        if (!$link) return mysqli_connect_error() ?: '';
        return mysqli_error($link);
    }

    function mysql_insert_id($link_identifier = null) {
        global $__global_mysql_link;
        $link = $link_identifier ?: $__global_mysql_link;
        if (!$link) return 0;
        return mysqli_insert_id($link);
    }

    function mysql_close($link_identifier = null) {
        global $__global_mysql_link;
        $link = $link_identifier ?: $__global_mysql_link;
        if ($link) {
            return mysqli_close($link);
        }
        return false;
    }
}
