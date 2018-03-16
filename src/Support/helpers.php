<?php

if (!function_exists('setProcessTitle')) {

    function setProcessTitle(string $title)
    {
        if (\SF\Support\PHP::isMacOS()) {
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


if (!function_exists('save_pid')) {
    function save_pid($master_pid, $manager_pid)
    {
        swoole_async_writefile(\SF\Console\Command::getSelf()->getPidFile(), $master_pid.','.$manager_pid);
    }
}

if (!function_exists('get_pid')) {
    function get_pid(callable $callback, string $file = '.pid')
    {
        swoole_async_readfile(\SF\Console\Command::getSelf()->getPidFile(), function($filename, $content) use ($callback){
            return \SF\Support\PHP::call($callback, explode(',', $content));
        });
    }
}
