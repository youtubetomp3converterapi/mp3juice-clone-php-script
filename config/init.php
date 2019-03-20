<?php

/**
 * SCRIPT INI 100% GRATIS DAN TIDAK DIPERBOLEHKAN UNTUK DIPERJUAL BELIKAN!
 * SAYA BERJANJI TIDAK AKAN MENJUAL SCRIPT INI KEPADA SIAPAPUN
 * JIKA SAYA MENJUAL SCRIPT INI MAKA REZEKI SAYA DAN KETURUNAN SAYA AKAN SERET SELAMANYA!
 * AAMIIN
 */

if ( ! defined( 'DICKYSYAPUTRA' ) ) {
  exit( '\m/' );
}

$config = require 'default/common.php';

if ( file_exists( BASE . '/config/' . $_SERVER['HTTP_HOST'] . '/common.php' ) ) {
  $site_config = require $_SERVER['HTTP_HOST'] . '/common.php';

  if (
    isset( $config['use_default_store'] ) && $config['use_default_store'] ||
    isset( $site_config['use_default_store'] ) && $site_config['use_default_store']
  ) {
    $use_default_store = true;
  } else {
    $use_default_store = false;
  }

  if ( ! $use_default_store && ! is_dir( BASE . '/store/' . $_SERVER['HTTP_HOST'] ) && ! @mkdir( BASE . '/store/' . $_SERVER['HTTP_HOST'], 0755, true ) ) {
    exit( 'Can\'t create store directory. Please check your folder permission.' );
  }
}

$routes = require 'default/routes.php';

if ( file_exists( BASE . '/config/' . $_SERVER['HTTP_HOST'] . '/routes.php' ) ) {
  $site_routes = require $_SERVER['HTTP_HOST'] . '/routes.php';
  $routes = array_merge( $routes, $site_routes );
}
