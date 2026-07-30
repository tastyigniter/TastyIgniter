<?php
namespace Ably\Utils;

/**
 * A wrapper class around cURL functions to allow mocking.
 * Also generates commands pastable to terminal for easier debugging.
 */
class CurlWrapper {
    protected $commands = [];

    public function init( $url = null ) {
        $handle = curl_init( $url );
        $this->commands[(int) $handle] = [
            'prefix' => 'curl',
            'command' => ' ',
            'url' => $url ? : '',
        ];

        return $handle;
    }

    public function setOpt( $handle, $option, $value ) {
        if ( $option == CURLOPT_URL ) {
            $this->commands[(int) $handle]['url'] = $value;
        } else if ( $option == CURLOPT_POST && $value ) {
            $this->commands[(int) $handle]['command'] .= '-X POST ';
        } else if ( $option == CURLOPT_CUSTOMREQUEST ) {
            $this->commands[(int) $handle]['command'] .= '-X ' . $value . ' ';
        } else if ( $option == CURLOPT_POSTFIELDS ) {
            $this->commands[(int) $handle]['command'] .= '--data "'. str_replace( '"', '\"', $value ) .'" ';
        } else if ( $option == CURLOPT_HTTPHEADER ) {
            foreach($value as $header) {
                $this->commands[(int) $handle]['command'] .= '-H "' . str_replace( '"', '\"', $header ).'" ';
            }
        }

        return curl_setopt( $handle, $option, $value );
    }

    public function exec( $handle ) {
        return curl_exec( $handle );
    }

    public function close( $handle ) {
        unset( $this->commands[(int) $handle] );

        if ( PHP_VERSION_ID < 80000 ) {
            curl_close( $handle );
        }

        return null;
    }

    public function getInfo( $handle ) {
        return curl_getinfo( $handle );
    }

    public function getErrNo( $handle ) {
        return curl_errno( $handle );
    }

    public function getError( $handle ) {
        return curl_error( $handle );
    }

    public function getContentType( $handle ) {
        return curl_getinfo( $handle, CURLINFO_CONTENT_TYPE );
    }

    /**
     * Retrieve a command pastable to terminal for a handle
     */
    public function getCommand( $handle ) {
        return $this->commands[(int) $handle]['prefix'] . $this->commands[(int) $handle]['command'] . $this->commands[(int) $handle]['url'];
    }
}
