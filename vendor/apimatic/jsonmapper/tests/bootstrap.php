<?php
if (is_dir(__DIR__ . '/../src/')) {
    set_include_path(
        __DIR__ . '/../src/'
        . PATH_SEPARATOR . get_include_path()
    );
}

require_once 'JsonMapper.php';
require_once 'JsonMapperException.php';
?>
