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

function search_permalink( $query ) {
  $query = permalink( urldecode( $query ) );
  $slug = str_replace( '%query%', $query, get_option( 'search_permalink' ) );
  return site_url() . '/' . $slug;
}

function download_permalink( $title, $id ) {
  $slug = permalink( $title );
  $id = base64_url_encode( $id );
  $full_slug = str_replace( [ '%slug%', '%id%' ], [ $slug, $id ], get_option( 'download_permalink' ) );
  return site_url() . '/' . $full_slug;
}

function file_permalink() {
  return site_url() . '/' . get_option( 'file_permalink' );
}

function sitemap_searches_permalink() {
  return site_url() . '/' . get_option( 'sitemap_searches_permalink' );
}

function sitemap_keywords_permalink( $num ) {
  $slug = str_replace( '%num%', $num, get_option( 'sitemap_keywords_permalink' ) );
  return site_url() . '/' . $slug;
}

function sitemap_permalink() {
  return site_url() . '/' . get_option( 'sitemap_permalink' );
}
