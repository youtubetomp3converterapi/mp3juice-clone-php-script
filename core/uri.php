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

$path = ( PATH == '' ) ? '/' : PATH;
$parse_uri = parse_url( $_SERVER['REQUEST_URI'] );
$clean_path = str_replace( PATH, '', $parse_uri['path'] );

if ( $path == '/' ) {
  $uri['path'] = ( $parse_uri['path'] != '/' ) ? ltrim( $parse_uri['path'], '/' ) : '/';
} else {
  $uri['path'] = ( $clean_path != '/' ) ? str_replace( PATH . '/', '', $parse_uri['path'] ) : '/';
}

$explode_uri_path = explode( '/', $uri['path'] );

$uri['query'] = ( isset( $parse_uri['query'] ) ) ? $parse_uri['query'] : '';

if ( $uri['path'] != '/' ) {
  $filter_uri_path = array_filter( $explode_uri_path );
  $contain_slashes = $explode_uri_path;
  $has_slashes = false;

  if ( count( $contain_slashes ) > count( $filter_uri_path ) && count( $contain_slashes ) > ( count( $filter_uri_path ) + 1 ) ) {
    $has_slashes = true;
  } elseif ( count( $contain_slashes ) > count( $filter_uri_path ) ) {
    $has_slashes = true;
  }

  if ( uri_has_extension( $uri['path'] ) ) {
    $has_slashes = false;
  }

  if ( $has_slashes ) {
    $redirect = implode( array_filter( $explode_uri_path ), '/' );
    $redirect.= ( ! empty( $uri['query'] ) ) ? '?' . $uri['query'] : '';

    redirect( site_url() . '/' . $redirect );
  }
}
