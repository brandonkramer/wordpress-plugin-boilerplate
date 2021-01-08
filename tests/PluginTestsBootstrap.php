<?php
use tad\FunctionMocker\FunctionMocker;

if ( !file_exists( $autoloader = dirname( __DIR__, 1 ) . '/vendor/autoload.php' ) ) {
    die();
}
$autoloader = require_once( $autoloader );

FunctionMocker::init();

/**
 * Add mocked functions here
 */