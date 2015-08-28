<?php
// This is global bootstrap for autoloading

// Ensure that we don't run into any php date-related issues
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('UTC');
}

