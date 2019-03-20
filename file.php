<?php

/**
 * SCRIPT INI 100% GRATIS DAN TIDAK DIPERBOLEHKAN UNTUK DIPERJUAL BELIKAN!
 * SAYA BERJANJI TIDAK AKAN MENJUAL SCRIPT INI KEPADA SIAPAPUN
 * JIKA SAYA MENJUAL SCRIPT INI MAKA REZEKI SAYA DAN KETURUNAN SAYA AKAN SERET SELAMANYA!
 * AAMIIN
 */

set_time_limit( 0 );

require 'config/init.php';

require 'core/functions/options.php';
require 'core/functions/common.php';

$url = ( isset( $_GET['u'] ) && $_GET['u'] ) ? base64_url_decode( $_GET['u'] ) : null;
$title = ( isset( $_GET['ti'] ) && $_GET['ti'] ) ? urldecode( $_GET['ti'] ) : null;
$source = ( isset( $_GET['s'] ) && in_array( $_GET['s'], [ 1 ] ) ) ? $_GET['s'] : null;
$type = ( isset( $_GET['ty'] ) && in_array( $_GET['ty'], [ 'mp3', 'mp4' ] ) ) ? $_GET['ty'] : null;

if ( is_null( $source ) ) {
  print_error( 'Invalid source!' );
} elseif ( is_null( $url ) ) {
  print_error( 'Invalid URL!' );
} elseif ( is_null( $type ) ) {
  print_error( 'Invalid type!' );
} else {
  $domain = $_SERVER['HTTP_HOST'];
  $title = preg_replace( '/([^a-z-A-Z-0-9-\s]+)/', '', $title ) . ' [' . $domain . ']';

  if ( $source == 1 ) {
    require 'core/classes/download.php';
    Download::start( $url, $title . '.mp3' );
  }
}
