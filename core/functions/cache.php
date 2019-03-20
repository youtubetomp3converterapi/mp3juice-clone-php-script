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

function get_cache_path() {
 	return store_dir() . '/cache';
}

function create_cache( $file, $content ) {
  if ( ! get_option( 'enable_cache' ) ) {
    return;
  }

  $cache_path = dirname( $file );
  if ( ! is_dir( $cache_path ) ) {
    if ( ! @mkdir( $cache_path, 0755, true ) ) {
      exit( 'Can\'t create cache directory. Please check your folder permission.' );
    }
  }

  if ( false !== ( $f = fopen( $file, 'w' ) ) ) {
    fwrite( $f, json_encode( $content ) );
    fclose( $f );
  }
}

function get_cache( $file ) {
  $cache_file = file_get_contents( $file );
  return json_decode( $cache_file, true );
}

function delete_cache( $path, $time = 3600 ) {
  $i = 0;
  $cache_folder = $path;

  if ( file_exists( $cache_folder ) ) {
    $it = new RecursiveDirectoryIterator( $cache_folder, RecursiveDirectoryIterator::SKIP_DOTS );
    $files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
    foreach( $files as $file ) {
      if ( time() - $file->getCTime() >= $time && ! $file->isDir() ) {
        unlink( $file->getRealPath() );
        $i++;
      }
    }
  }
}
