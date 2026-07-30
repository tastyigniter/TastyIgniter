<?php

function random_string ( $n ) {
    return bin2hex(openssl_random_pseudo_bytes($n / 2));
}
