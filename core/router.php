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

$found = false;

foreach ( $routes as $route => $args ) {
  if ( $args['name'] == 'search' ) {
    $route = str_replace( '%query%', '([^/_~!#$&*()+={}\[\]|;,]+)', $config['search_permalink'] );
  } if ( $args['name'] == 'download' ) {
    $route = str_replace( [ '%slug%', '%id%' ], '([^/_~!#$&*()+={}\[\]|;,]+)', $config['download_permalink'] );
  } if ( $args['name'] == 'file' ) {
    $route = $config['file_permalink'];
  } if ( $args['name'] == 'sitemap-searches' ) {
    $route = $config['sitemap_searches_permalink'];
  } if ( $args['name'] == 'sitemap-keywords' ) {
    $route = str_replace( '%num%', '([0-9-]+)', $config['sitemap_keywords_permalink'] );
  } if ( $args['name'] == 'sitemap-index' ) {
    $route = $config['sitemap_index_permalink'];
  }

  $pattern = '/^' . str_replace( '/', '\/', $route ) . '$/';
  if ( preg_match( $pattern, $uri['path'], $vars ) ) {
    array_shift( $vars );

    $args['name'] = ( isset( $args['name'] ) ) ? $args['name'] : null;
    $args['vars'] = ( isset( $vars ) ) ? $vars : [];
    $args['file'] = ( isset( $args['file'] ) ) ? $args['file'] : null;

    $found = true;

    break;
  }
}

if ( ! $found ) {
  $args['name'] = 'error404';
  $args['vars'] = [];
}

$route = $args;
