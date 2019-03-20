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

return [
  '/' => [ 'name' => 'home', 'file' => 'home.php' ],
  'search/([^/_~!#$&*()+={}\[\]|;,]+)' => [ 'name' => 'search', 'file' => 'search.php' ],
  'download/([^/_~!#$&*()+={}\[\]|;,]+)-([^/_~!#$&*()+={}\[\]|;,]+)' => [ 'name' => 'download', 'file' => 'download.php' ],
  'file' => [ 'name' => 'file', 'file' => 'file.php' ],
  'sitemap/searches.xml' => [ 'name' => 'sitemap-searches', 'file' => 'sitemap.php' ],
  'sitemap/([0-9-]+).xml' => [ 'name' => 'sitemap-keywords', 'file' => 'sitemap.php' ],
  'sitemap.xml' => [ 'name' => 'sitemap-index', 'file' => 'sitemap.php' ]
];
