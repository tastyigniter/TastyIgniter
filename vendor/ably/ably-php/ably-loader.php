<?php
/**
 * This is an autoloader for Ably classes for cases when you do not wish to use composer
 */

namespace Ably;

function ably_autoloader( $class ) {
	if ( strpos( $class, 'Ably\\' ) !== 0 ) { // attempt auto-loading only classes from the Ably namespace
		return;
	}
	require_once ( __DIR__ . '/src/' . str_replace( '\\', '/', substr( $class, 5 ) ) . '.php' );
}

spl_autoload_register( '\Ably\ably_autoloader', true, true );