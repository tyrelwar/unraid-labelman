<?php

namespace Labelman;

foreach (glob("/usr/local/emhttp/plugins/labelman/include/Labelman/*.php") ?: array() as $file) {
    try {
        require $file;
    } catch (\Throwable $e) {
        Utils::logmsg("Caught exception in {$file} : " . $e->getMessage());
    }
}
