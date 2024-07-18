<?php

if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']==='GET' ){

    $is_https = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1))
                || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');

    if( !$is_https && isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI']) ){
        $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redirect_url");
        exit();
    }
}
?>
