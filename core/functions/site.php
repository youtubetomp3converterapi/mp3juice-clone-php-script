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

function site_title( $title = null, $sep = ' - ' ) {
  $title = ( ( $title ) ? $title . $sep : '' ) . get_option( 'site_name' );
  return $title;
}

function register_stylesheet( $file ) {
  echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $file . '" />' . "\n";
}

function register_script( $file ) {
  echo '<script type="text/javascript" src="' . $file . '"></script>' . "\n";
}

function register_localize_script( $key, $args ) {
  $output = '<script type="text/javascript">' . "\n";
	$output.= '/* <![CDATA[ */' . "\n";
	$output.= 'var ' . $key . ' = ' . json_encode( $args ) . ';' . "\n";
	$output.= '/* ]]> */' . "\n";
	$output.= '</script>' . "\n";

  echo $output;
}
