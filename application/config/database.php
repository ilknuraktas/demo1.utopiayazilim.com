<?php

defined('BASEPATH') OR exit('No direct script access allowed');



$active_group = 'default';

$query_builder = TRUE;



$db['default'] = array(

    'dsn'	=> '',

    'hostname' => 'localhost',

    'username' => 'root',

    'password' => '',

    'database' => 'mowww',

    'dbdriver' => 'mysqli',

    'dbprefix' => '',

    'pconnect' => FALSE,

    'db_debug' => (ENVIRONMENT !== 'production'),

    'cache_on' => FALSE,

    'cachedir' => '',

    'char_set' => 'utf8',

    'dbcollat' => 'utf8_general_ci',

    'swap_pre' => '',

    'encrypt' => FALSE,

    'compress' => FALSE,

    'stricton' => FALSE,

    'failover' => array(),

    'save_queries' => TRUE

);

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|   http://example.com/
|
| If this is not set CodeIgniter will try to guess the protocol and path.
|
*/
$config['base_url'] = 'http://localhost/mowww/';