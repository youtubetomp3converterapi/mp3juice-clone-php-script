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

function get_option( $key = null, $default = null ) {
  global $config, $site_config;

  if ( ! is_null( $key ) && isset( $site_config[$key] ) ) {
    return $site_config[$key];
  } elseif ( ! is_null( $key ) && isset( $config[$key] ) ) {
    return $config[$key];
  } else {
    if ( $default ) {
      return $default;
    }
  }
}
