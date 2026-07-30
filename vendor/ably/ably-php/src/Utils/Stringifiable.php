<?php
namespace Ably\Utils;


class Stringifiable {
    public static function buildQuery($params = []) {
        $func = function ($value) {
            if ($value === true) return 'true';
            if ($value === false) return 'false';
            return $value;
        };

        return http_build_query(array_map($func, $params));
    }
}
