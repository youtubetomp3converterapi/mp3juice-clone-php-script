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
  'site_name' => 'MP3JUICES',
  'site_tagline' => 'Fre MP3 and Video Downloader',

  // Tag yang bisa digunakan untuk home_description: %site_name%, %domain%
  'home_description' => '',
  // Tag yang bisa digunakan untuk search_title: %query%, %domain%
  'search_title' => '%query%',
  // Tag yang bisa digunakan untuk search_description: %query%, %domain%
  'search_description' => '%query%',
  'search_robots' => 'index,follow',
  // Tag yang bisa digunakan untuk download_title: %title%, %duration%, %domain%
  'download_title' => '%title%',
  // Tag yang bisa digunakan untuk download_description: %title%, %duration%, %domain%
  'download_description' => '',
  'download_robots' => 'noindex,follow',

  // Tag yang bisa digunakan untuk search_page_title: %query%
  'search_page_title' => '%query%',
  // Tag yang bisa digunakan untuk download_page_title: %title%
  'download_page_title' => '%title%',

  /**************************************************************/

  'search_permalink' => 'search/%query%',
  'download_permalink' => 'download/%slug%-%id%',
  'file_permalink' => 'file',
  'sitemap_searches_permalink' => 'sitemap/searches.xml',
  'sitemap_keywords_permalink' => 'sitemap/%num%.xml',
  'sitemap_index_permalink' => 'sitemap.xml',

  /**************************************************************/

  /**
   * Untuk melihat kode negara yang tersedia, silahkan cek link dibawah:
   * https://rss.itunes.apple.com/
   */

  'itunes_country' => 'us',
  'itunes_count' => 10,

  /**************************************************************/

  'youtube_top_videos_count' => 10,
  'youtube_top_videos_country' => 'US',
  'youtube_search_count' => 5,
  // Pisahkan dengan koma untuk menggunakan banyak API
  'youtube_api_keys' => 'AIzaSyAWyaRXvLXja8YUefAjwbSeFQONgqigvOg',

  'soundcloud_search_count' => 5,
  // Pisahkan dengan koma untuk menggunakan banyak API / Client ID
  'soundcloud_client_ids' => '',

  // Maksimal sitemap perhalaman adalah 50000,
  // Sengaja ane buat 10000 biar ngga terlalu berat
  'sitemap_limit' => 10000,

  /**************************************************************/

  /**
   * Jika agan menggunakan konfigurasi multisite,
   * maka otomatis akan tergenerate direktori sesuai nama domain di direktori /store.
   * Direktori ini berfungsi untuk tempat penyimpanan data seperti cache, pencarian terbaru
   * dan file untuk inject keyword
   * Gunakan nilai 'true' (tanpa tanda petik) jika agan ingin menggunakan direktori berdasarkan domain
   * Tapi gunakan nilai 'false' (tanpa tanda petik) jika agan ingin menggunakan direktori default
   */

  'use_default_store' => false,

  /**************************************************************/

  'enable_cache' => true,

  'save_recent_searches' => true,
  'recent_searches_limit' => 25000,
  'recent_searches_count' => 15,

  /**************************************************************/

  /**
   * Option ini berfungsi memeriksa apakah anda ingin menggunakan direktori keyword dari direktori default
   * atau dari direktori domain (jika 'use_default_store' = true)
   */

  'use_default_keyword_files' => true,

  /**************************************************************/

  'footer_copyright' => '&copy; %year% %site_name%. All rights reserved.'
];
