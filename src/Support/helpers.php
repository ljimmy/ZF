<?php

if (!function_exists('setProcessTitle')) {

    function setProcessTitle(string $title)
    {
        if (\SF\Support\PHP::isMacOs()) {
            return true;
        }
        if (empty($title)) {
            return false;
        }

        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($title);
        } else {
            swoole_set_process_name($title);
        }
        return true;
    }

}
