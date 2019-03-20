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

class AGC {
  public function get_itunes_top_songs() {
    $cache_file = get_cache_path() . '/home/top-songs.json';
    if ( file_exists( $cache_file ) ) {
      $json = file_get_contents( $cache_file, true );
      $items = json_decode( $json, true );
    } else {
      $count = get_option( 'itunes_count', 10 );
      $country = get_option( 'itunes_country' );
      $url = 'https://itunes.apple.com/' . $country . '/rss/topsongs/limit=' . $count . '/xml';
      $curl = $this->curl( $url, 'https://www.apple.com' );

      if ( $curl['info']['http_code'] == 200 ) {
        $xml = str_replace( 'im:', '', $curl['data'] );
        $xml = json_decode( json_encode( simplexml_load_string( $xml ) ), true );

        if ( isset( $xml['entry'] ) ) {
          foreach ( $xml['entry'] as $item ) {
            $data['title'] = $item['title'];
            $data['artist'] = $item['artist'];
            $data['image'] = str_replace( '55x55bb-85', '100x100bb-100', $item['image'][0] );
            $items[] = $data;
          }

          create_cache( $cache_file, $items );
        }
      }
    }

    return ( isset( $items ) ) ? $items : [];
  }

  public function get_itunes_new_releases() {
    $cache_file = get_cache_path() . '/home/new-releases.json';
    if ( file_exists( $cache_file ) ) {
      $json = file_get_contents( $cache_file, true );
      $items = json_decode( $json, true );
    } else {
      $count = get_option( 'itunes_count', 10 );
      $url = 'https://itunes.apple.com/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=' . $count . '/rss.xml';
      $curl = $this->curl( $url, 'https://www.apple.com' );

      if ( $curl['info']['http_code'] == 200 ) {
        $xml = str_replace( 'itms:', '', $curl['data'] );
        $xml = json_decode( json_encode( simplexml_load_string( $xml ) ), true );

        if ( isset( $xml['channel']['item'] ) ) {
          foreach ( $xml['channel']['item'] as $item ) {
            $data['title'] = $item['title'];
            $data['artist'] = $item['artist'];
            $data['image'] = str_replace( '55x55bb-85', '100x100bb-100', end( $item['coverArt'] ) );
            $items[] = $data;
          }

          create_cache( $cache_file, $items );
        }
      }
    }

    return ( isset( $items ) ) ? $items : [];
  }

  public function get_youtube_top_videos() {
    $cache_file = get_cache_path() . '/home/top-videos.json';
    if ( file_exists( $cache_file ) ) {
      $json = file_get_contents( $cache_file, true );
      $items = json_decode( $json, true );
    } else {
      $api_key = $this->get_youtube_api();
      $country = get_option( 'youtube_top_videos_country', 10 );
      $count = get_option( 'youtube_top_videos_count' );
      $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&chart=mostPopular&regionCode=' . $country . '&maxResults=' . $count . '&key=' . $api_key;
      $curl = $this->curl( $url, 'https://www.youtube.com' );

      if ( $curl['info']['http_code'] == 200 ) {
        $array = json_decode( $curl['data'], true );
        if ( isset( $array['items'] ) ) {
          foreach ( $array['items'] as $item ) {
            $data['id'] = $item['id'];
            $data['title'] = $item['snippet']['title'];
            $data['channel'] = $item['snippet']['channelTitle'];
            $data['image'] = $item['snippet']['thumbnails']['medium']['url'];
            $items[] = $data;
          }

          create_cache( $cache_file, $items );
        }
      }
    }

    return ( isset( $items ) ) ? $items : [];
  }

  public function get_search() {
    $q = urlencode( get_search_query() );
    $items = [];

    $youtube__api_key = $this->get_youtube_api();
    $youtube__count = get_option( 'youtube_search_count', 5 );

    if ( $youtube__api_key ) {
      $youtube__url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&videoType=any&maxResults=' . $youtube__count . '&q=' . $q . '&key=' . $youtube__api_key;
      $youtube__curl = $this->curl( $youtube__url, 'https://www.youtube.com' );

      if ( $youtube__curl['info']['http_code'] == 200 ) {
        $youtube__array = json_decode( $youtube__curl['data'], true );
        if ( isset( $youtube__array['items'] ) ) {
          foreach ( $youtube__array['items'] as $item ) {
            $data['id'] = $item['id']['videoId'];
            $data['source'] = 'yt';
            $data['title'] = $item['snippet']['title'];
            $data['channel'] = $item['snippet']['channelTitle'];
            $data['image'] = $item['snippet']['thumbnails']['medium']['url'];
            $items[] = $data;
          } unset( $item, $data );
        }
      }
    }

    $soundcloud__client_id = $this->get_soundcloud_client_id();
    $soundcloud__count = get_option( 'soundcloud_search_count', 5 );

    if ( $soundcloud__client_id ) {
  		$soundcloud__url = 'http://api.soundcloud.com/tracks.json?q=' . $q . '&client_id=' . $soundcloud__client_id . '&limit=' . $soundcloud__count;
      $soundcloud__curl = $this->curl( $soundcloud__url, 'https://soundcloud.com' );

      if ( $soundcloud__curl['info']['http_code'] == 200 ) {
  			$soundcloud__array = json_decode( $soundcloud__curl['data'], true );
  			if ( is_array( $soundcloud__array ) ) {
  				foreach ( $soundcloud__array as $item ) {
            $data['id'] = $item['id'];
  					$data['source'] = 'sc';
  					$data['title'] = strip_tags( $item['title'] );

  					if ( isset( $item['publisher_metadata']['artist'] ) ) {
  						$data['channel'] = $item['publisher_metadata']['artist'];
  					} else {
  						$data['channel'] = $item['user']['username'];
  					}

  					$data['image'] = ( isset( $item['artwork_url'] ) ) ? $item['artwork_url'] : '';
  					$items[] = $data;
  				}
  			}
  		}
  	}

    return ( isset( $items ) ) ? $items : [];
  }

  public function get_download() {
    global $route;

    $slug = $route['vars'][0];
    $id = $route['vars'][1];
    $full_slug = $slug . '--' . $id;
    $cache_file = get_cache_path() . '/downloads/' . md5( $full_slug ) .'.json';

    if ( file_exists( $cache_file ) ) {
      $data = json_decode( file_get_contents( $cache_file ), true );
    } else {
      $decode_id = base64_url_decode( $id );
      $exp_decode_id = explode( '--', $decode_id );

      if ( count( $exp_decode_id ) == 2 ) {
        $source = $exp_decode_id[0];
        $id = $exp_decode_id[1];

        if ( $source == 'yt' ) {
          $youtube__api_key = $this->get_youtube_api();
          if ( $youtube__api_key ) {
            $youtube__url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=' . $id . '&key=' . $youtube__api_key;
            $youtube__curl = $this->curl( $youtube__url, 'https://www.youtube.com' );

            if ( $youtube__curl['info']['http_code'] == 200 ) {
              $youtube__array = json_decode( $youtube__curl['data'], true );
              if ( isset( $youtube__array['items'][0]['snippet'] ) && isset( $youtube__array['items'][0]['contentDetails'] ) ) {
                $snippet = $youtube__array['items'][0]['snippet'];
                $content_details = $youtube__array['items'][0]['contentDetails'];

                $data['source'] = 'yt';
                $data['id'] = $id;
                $data['title'] = $snippet['title'];
                $data['channel'] = $snippet['channelTitle'];
                $data['duration'] = $this->convert_youtube_time( $content_details['duration'] );
                $data['image'] = 'http://img.youtube.com/vi/' . $id . '/mqdefault.jpg';

                $exp_duration = explode( ':', $data['duration'] );
                if ( count( $exp_duration ) == 2 ) {
                  $parsed = date_parse( '00:' . $data['duration'] );
                  $seconds = ( $parsed['minute'] * 60 ) + $parsed['second'];
                } else {
                  $parsed = date_parse( $data['duration'] );
                  $seconds = ( $parsed['hour'] * 60 * 60 ) + ( $parsed['minute'] * 60 ) + $parsed['second'];
                }

                $data['size'] = $this->get_format_bytes( ( $seconds * ( 128 / 8 ) * 1000 ) );
              }
            }
          }
        } elseif ( $source == 'sc' ) {
          $soundcloud__client_id = $this->get_soundcloud_client_id();
          if ( $soundcloud__client_id ) {
            $soundcloud__url = 'http://api.soundcloud.com/tracks/' . $id . '.json?client_id=' . $soundcloud__client_id;
            $soundcloud__curl = $this->curl( $soundcloud__url, 'https://www.soundcloud.com' );

            if ( $soundcloud__curl['info']['http_code'] ) {
              $item = json_decode( $soundcloud__curl['data'], true );

              $data['source'] = 'sc';
              $data['id'] = $item['id'];
              $data['title'] = $item['title'];
              $data['channel'] = $item['user']['username'];
              $data['duration'] = gmdate( 'i:s', $item['duration'] / 1000 );
              $data['image'] = str_replace( '-large.', '-t500x500.', $item['artwork_url'] );
              $data['client_id'] = $soundcloud__client_id;
            }
          }
        }
      }

      if ( isset( $data ) ) {
        create_cache( $cache_file, $data );
      }
    }

    return ( isset( $data ) ) ? $data : [];
  }

  public function get_soundcloud_stream_url( $id, $client_id ) {
    $soundcloud__stream_url = 'https://api.soundcloud.com/i1/tracks/' . $id . '/streams?client_id=' . $client_id . '&app_version=' . time();
    $soundcloud__stream_curl = $this->curl( $soundcloud__stream_url, 'https://www.soundcloud.com' );

    if ( $soundcloud__stream_curl['info']['http_code'] ) {
      $stream = json_decode( $soundcloud__stream_curl['data'], true );
      if ( isset( $stream['http_mp3_128_url'] ) ) {
        return $stream['http_mp3_128_url'];
      }
    }

    return null;
  }

  private function get_youtube_api() {
    $api_keys = get_option( 'youtube_api_keys' );
    if ( $api_keys ) {
      $exp_api_keys = explode( ',', $api_keys );
      shuffle( $exp_api_keys );
      return $exp_api_keys[0];
    }
  }

  private function get_soundcloud_client_id() {
    $api_keys = get_option( 'soundcloud_client_ids' );
    if ( $api_keys ) {
      $exp_api_keys = explode( ',', $api_keys );
      shuffle( $exp_api_keys );
      return $exp_api_keys[0];
    }
  }

  private function curl( $url, $referer = '' ) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ua = new UA;
    $ch = curl_init();

  	curl_setopt( $ch, CURLOPT_URL, $url );
  	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_ENCODING, "gzip,deflate" );
    curl_setopt( $ch, CURLOPT_USERAGENT, $ua->get_ua() );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
  	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

    if ( $referer ) {
      curl_setopt( $ch, CURLOPT_REFERER, $referer );
    }

    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
  	curl_setopt( $ch, CURLOPT_HTTPHEADER, [ "Accept-Language: en-US;q=0.6,en;q=0.4", "REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip" ] );

    $data = curl_exec( $ch );
  	$info = curl_getinfo( $ch );

  	curl_close( $ch );

  	return [ 'info' => $info, 'data' => $data ];
  }

  private function convert_youtube_time( $time ){
    $start = new DateTime( '@0' );
    $start->add( new DateInterval( $time ) );
    return $start->format( 'i:s' );
  }

  private function get_format_bytes( $bytes, $precision = 2 ) {
  	$units = [ 'B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ];
  	$bytes = max( $bytes, 0);
  	$pow = floor( ( $bytes ? log( $bytes ) : 0) / log( 1024 ) );
  	$pow = min( $pow, count( $units ) - 1 );
  	$bytes /= pow( 1024, $pow );
  	return round( $bytes, $precision ) . '' . $units[$pow];
  }
}

function agc() {
  return new AGC;
}
