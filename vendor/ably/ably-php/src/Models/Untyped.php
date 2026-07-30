<?php
namespace Ably\Models;

/**
 * Blank model used in untyped PaginatedResult requests
 */
#[\AllowDynamicProperties]
class Untyped {
    /**
     * Populates the model from JSON
     * @param string|stdClass $json JSON string or an already decoded object.
     * @throws AblyException
     */
    public function fromJSON( $json ) {
        if (!is_string( $json )) {
            $obj = $json;
        } else {
            $obj = @json_decode($json);
            if (!$obj) {
                throw new AblyException( 'Invalid object or JSON encoded object' );
            }
        }

        foreach ( $obj as $key => $value ) {
            $this->$key = $value;
        }
    }
}
