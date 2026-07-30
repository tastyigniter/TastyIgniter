<?php
namespace Ably\Models;

use Ably\Log;

/**
 * Base class for models with options
 * Provides automatic loading of options from array or an object
 */
abstract class BaseOptions {
    public function __construct( $options = [] ) {
        $class = get_class( $this );
        
        foreach ($options as $key => $value) {
            if (property_exists( $class, $key )) {
                $this->$key = $value;
            }
        }
    }

    public function toArray() {
        $properties = call_user_func('get_object_vars', $this);
        foreach ($properties as $k => $v) {
            if ($v === null) {
                unset($properties[$k]);
            }
        }
        return $properties;
    }

    public function fromJSON( $json ) {
        if (!is_string( $json )) {
            $obj = $json;
        } else {
            $obj = @json_decode($json);
            if (!$obj) {
                throw new AblyException( 'Invalid object or JSON encoded object' );
            }
        }

        $class = get_class( $this );
        foreach ($obj as $key => $value) {
            if (property_exists( $class, $key )) {
                $this->$key = $value;
            }
        }
    }

}
