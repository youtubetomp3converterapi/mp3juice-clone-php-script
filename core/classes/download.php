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

class Download {
  public static $url;
  public static $size;
  public static $name;

  public static function start( $url, $name ) {
    self::$url = $url;
    self::$size = self::get_size( $url );
    self::$name = $name;

    $flush_support = function_exists( 'ob_flush' ) && function_exists( 'flush' );
    $user_agent = [ 'Mozilla/5.0', '(Windows NT 6.3; WOW64)', 'AppleWebKit/537.36', '(KHTML, like Gecko)', 'Chrome/40.0.2214.115', 'Safari/537.36' ];
    $oheaders = [
      'Referer' => self::$url,
      'Accept-Language' => 'en-US,en;q=0.8,te;q=0.6',
      'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
      'User-Agent' => implode( ' ', $user_agent ),
    ];

    if ( isset( $_SERVER['HTTP_RANGE'] ) ) {
      $oheaders['range'] = $_SERVER['HTTP_RANGE'];
    }

    $oheaders['Connection'] = 'Close';
    $head_pack = '';

    foreach ( $oheaders as $key => $value ) {
      $head_pack.= "{$key}: {$value}\r\n";
    }

    $options = [
      'http' => [
        'method' => "GET",
        'header' => $head_pack,
        'timeout' => 10,
        'max_redirects' => 10,
        'ignore_errors' => true,
        'follow_location' => 1,
        'protocol_version' => '1.0',
      ]
    ];

    $context = stream_context_create( $options );

    if ( is_resource( $http = fopen( self::$url, 'r', null, $context ) ) ) {
      $meta = stream_get_meta_data( $http );
      $headers = [];

      if ( is_array( $meta ) && isset( $meta['wrapper_data'] ) && is_array( $meta['wrapper_data'] ) ) {
        $headers = $meta['wrapper_data'];
        if ( isset( $headers['headers'] ) && is_array( $headers['headers'] ) ) {
          $headers = $headers['headers'];
        }
      }

      if ( count( $headers ) == 0 && function_exists( 'curl_version' ) ) {
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, self::$url );
        curl_setopt( $curl, CURLOPT_HEADER, true );
        curl_setopt( $curl, CURLOPT_NOBODY, true );
        if ( isset( $_SERVER['HTTP_RANGE'] ) ) {
          $range = str_replace( 'bytes=', '', $_SERVER['HTTP_RANGE'] );
          curl_setopt( $curl, CURLOPT_RANGE, $range );
        }
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $oheaders );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
        $headers = explode( "\n", str_replace( "\r\n", "\n", curl_exec( $curl ) ) );
      }

      if ( count( $headers ) > 0 ) {
        $all_heads = explode( "\r\nHTTP/", implode( "\r\n", $headers ) );
        $last_head = explode( "\r\n", "HTTP/" . end( $all_heads ) );
        $eliminate = [ 'set-cookie', 'content-type', 'content-disposition', 'connection' ];

        foreach ( $last_head as $i => $h ) {
          if ( $i == 0 ) {
            header( $h );
          } elseif ( preg_match( '/^([^\:]+)/i', $h, $m ) ) {
            $k = strtolower( $m[1] );
            if ( ! in_array( $k, $eliminate ) ) {
              header( $h );
            }
          }
        }

        $download_name = self::$name;

        header( 'Content-Type: application/octet-stream' );
        header( 'Content-Disposition: attachment; filename="' . $download_name . '"' );
        header( 'Connection: Close');
      }

      if ( function_exists( 'apache_setenv' ) ) {
        apache_setenv( 'no-gzip', 1 );
      } if ( function_exists( 'ini_set' ) ) {
        ini_set( 'zlib.output_compression', false );
        ini_set( 'implicit_flush', true );
      } if ( function_exists( 'ob_implicit_flush' ) && function_exists( 'ob_end_flush' ) ) {
        ob_implicit_flush( true );
        ob_end_flush();
      }

      while ( ! feof( $http ) ) {
        echo fread( $http, 1024 * 8 );
        if ( $flush_support ) {
          @ob_flush();
          @flush();
        }
      }

      fclose( $http );
    }
  }

  public static function get_size( $url ) {
    $headers = get_headers( $url, true );
    if ( isset( $headers['Content-Length'] ) ) {
      if ( is_array( $headers['Content-Length'] ) && count( $headers['Content-Length'] ) > 1 ) {
        return $headers['Content-Length'][1];
      } else {
        return $headers['Content-Length'];
      }
    }

    return null;
  }
}
