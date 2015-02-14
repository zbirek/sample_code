<?php

namespace Webwings\Utils;

class Dump {

    public static function ddump($var) {
        $backtrace = debug_backtrace(false);
        $trace = array();
        for ($i = 2; $i < 5; $i++) {
            if (!isset($backtrace[$i]) || !isset($backtrace[$i]['file']) || !isset($backtrace[$i]['line'])) {
                break;
            }
            $trace[] = sprintf("file %s on line %d<br />\n", $backtrace[$i]['file'], $backtrace[$i]['line']);
        }
        foreach (func_get_args() as $arg) {
            $dump = \Nette\Diagnostics\Debugger::dump($arg, TRUE);
            echo str_replace("<pre", "<pre title=\"ddump(): " . strip_tags(implode("\n", $trace)) . "\"", $dump);
        }
        die();
    }

}
