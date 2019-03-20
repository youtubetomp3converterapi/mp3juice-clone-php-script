<?php

/**
 * SCRIPT INI 100% GRATIS DAN TIDAK DIPERBOLEHKAN UNTUK DIPERJUAL BELIKAN!
 * SAYA BERJANJI TIDAK AKAN MENJUAL SCRIPT INI KEPADA SIAPAPUN
 * JIKA SAYA MENJUAL SCRIPT INI MAKA REZEKI SAYA DAN KETURUNAN SAYA AKAN SERET SELAMANYA!
 * AAMIIN
 */

date_default_timezone_set( 'Asia/Jakarta' );

error_reporting( E_ALL );

define( 'DICKYSYAPUTRA', true );
define( 'IDC', dirname( __FILE__ ) );

$base = str_replace( "\\", "/", IDC );
$path = str_replace( rtrim( $_SERVER['DOCUMENT_ROOT'], '/' ), '', $base );
if ( $base == $path ) {
	$base = str_replace( array( "public_html", "\\" ), array( "www", "/" ), IDC );
	$path = str_replace( rtrim( $_SERVER['DOCUMENT_ROOT'], '/' ), '', $base );
}

define( 'BASE', $base, TRUE );
define( 'PATH', $path, TRUE );

require 'config/init.php';

require 'core/functions/general.php';
require 'core/uri.php';
require 'core/router.php';

if ( $found ) {
  $file = BASE . '/' . $route['file'];
  if ( $route['file'] && file_exists( $file ) ) {
    require $file;
    exit();
  } else {
    print_error( "File <strong>$vars[file]</strong> is not found" );
  }
} else {
  print_error( "Page is not found" );
}
