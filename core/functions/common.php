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

function get_search_query() {
  global $route;

  return urldecode( ucwords( str_replace(
    [ 'don-t', 'can-t', '-' ],
    [ 'don\'t', 'can\'t', ' ' ],
    ( isset( $route['vars'][0] ) ? $route['vars'][0] : null )
  ) ) );
}

function store_dir() {
  if ( is_dir( BASE . '/store/' . $_SERVER['HTTP_HOST'] ) ) {
    return BASE . '/store/' . $_SERVER['HTTP_HOST'];
  } else {
    return BASE . '/store/default';
  }
}

function get_badwords() {
	if ( file_exists( store_dir() . '/badwords.txt' ) ) {
		$bad_words = file_get_contents( store_dir() . '/badwords.txt' );
		return array_filter( explode( ',', $bad_words ) );
	} elseif ( file_exists( BASE . '/store/badwords.txt' ) ) {
		$bad_words = file_get_contents( BASE . '/store/badwords.txt' );
		return array_filter( explode( ',', $bad_words ) );
	} else {
		return [];
	}
}

function filter_badwords( $haystack, $needle, $offset = 0 ) {
	if ( is_array( $needle ) && ! empty( $needle ) ) {
		foreach( $needle as $word ) {
			if ( stristr( $haystack, trim( $word ) ) ) {
				return true;
			}
		}
	}

	return false;
}

function badword_redirect() {
	if ( filter_badwords( strtolower( get_search_query() ), get_badwords(), 0 ) ) {
		$exp_title = $static_exp_title = explode( ' ', strtolower( get_search_query() ) );

		if ( count( $exp_title ) > 1 ) {
			foreach( get_badwords() as $key => $value ) {
				$exp_value = explode( ' ', trim( $value ) );
				if ( count( $exp_value ) > 1 ) {
					foreach( $exp_value as $child_value ) {
						if ( ( $key = array_search( $child_value, $exp_title ) ) !== false ) {
							unset( $exp_title[$key] );
						}
					}
				} else {
					if ( ( $key = array_search( $value, $exp_title ) ) !== false ) {
						unset( $exp_title[$key] );
					}
				}
			}

			if ( count( $exp_title ) > 0 ) {
				if ( count( $exp_title ) != count( $static_exp_title ) ) {
					$redirect = search_permalink( implode( $exp_title, '-' ) );
				}
			} else {
				$redirect = site_url();
			}
		} else {
			$redirect = site_url();
		}
	}

	return ( isset( $redirect ) ) ? $redirect : false;
}

function set_recent_user_access( $data, $key, $limit = 25000 ) {
  if ( ! get_option( 'save_recent_searches' ) ) {
    return;
  }

	$get_data = [];
	$recent_data_file = store_dir() . '/searches.json';

	if ( file_exists( $recent_data_file ) ) {
		$json = file_get_contents( $recent_data_file );
		$get_data = json_decode( $json, true );
	}

	$key = search_array( $get_data, $key, $data[$key] );
	if ( $key >= 0 ) {
		unset( $get_data[$key] );
  } if ( count( $get_data ) >= $limit ) {
		array_pop( $get_data );
  }

  if ( count( $get_data ) > 0 ) {
		$update = array_merge( [ $data ], $get_data );
	} else {
		$update = [ $data ];
  }

	if ( file_exists( $recent_data_file ) ) {
		unlink( $recent_data_file );
  }

	$output = json_encode( $update );
	$recent_data_file_update = fopen( $recent_data_file, 'w' );
	fwrite( $recent_data_file_update, $output );
	fclose( $recent_data_file_update );
}

function get_recent_user_access( $limit = 20 ) {
	$recent_data_file = store_dir() . '/searches.json';
	if ( file_exists( $recent_data_file ) ) {
		$json = file_get_contents( $recent_data_file );
		$get_data = json_decode( $json, true );

		if ( $get_data ) {
      foreach( $get_data as $key => $item ) {
  			if ( ( $key + 1 ) > $limit ) {
  				break;
        }

  			$output[] = $item;
  		}
    }
	}

  return ( isset( $output ) ) ? $output : [];
}

function dmca_redirect() {
  $dmca = store_dir() . '/dmca.txt';
  if ( file_exists( $dmca ) ) {
    $urls = array_map( 'trim', file( $dmca ) );
  } else {
    $urls = [];
  }

  if ( in_array( canonical_url(), $urls ) ) {
    redirect( site_url() );
  }
}

function search_array( $array, $key, $value ) {
  if ( $array ) {
    foreach ( $array as $array_key => $subarray ) {
      if ( isset( $subarray[$key] ) && $subarray[$key] == $value ) {
  	    return $array_key;
       }
    }
  }

	return -1;
}

function permalink( $str, $delimiter = '-', $options = [] ) {
	$str = mb_convert_encoding( ( string ) $str, 'UTF-8', mb_list_encodings() );

	$defaults = [
		'delimiter' => $delimiter,
		'limit' => null,
		'lowercase' => true,
		'replacements' => [],
		'transliterate' => false,
	];

	$options = array_merge( $defaults, $options );

	$char_map = [
		// Latin
		'ÃƒÂ€' => 'A', 'ÃƒÂ' => 'A', 'ÃƒÂ‚' => 'A', 'ÃƒÂƒ' => 'A', 'ÃƒÂ„' => 'A', 'ÃƒÂ…' => 'A', 'ÃƒÂ†' => 'AE', 'ÃƒÂ‡' => 'C',
		'ÃƒÂˆ' => 'E', 'ÃƒÂ‰' => 'E', 'ÃƒÂŠ' => 'E', 'ÃƒÂ‹' => 'E', 'ÃƒÂŒ' => 'I', 'ÃƒÂ' => 'I', 'ÃƒÂŽ' => 'I', 'ÃƒÂ' => 'I',
		'ÃƒÂ' => 'D', 'ÃƒÂ‘' => 'N', 'ÃƒÂ’' => 'O', 'ÃƒÂ“' => 'O', 'ÃƒÂ”' => 'O', 'ÃƒÂ•' => 'O', 'ÃƒÂ–' => 'O', 'Ã…Â' => 'O',
		'ÃƒÂ˜' => 'O', 'ÃƒÂ™' => 'U', 'ÃƒÂš' => 'U', 'ÃƒÂ›' => 'U', 'ÃƒÂœ' => 'U', 'Ã…Â°' => 'U', 'ÃƒÂ' => 'Y', 'ÃƒÂž' => 'TH',
		'ÃƒÂŸ' => 'ss',
		'Ãƒ ' => 'a', 'ÃƒÂ¡' => 'a', 'ÃƒÂ¢' => 'a', 'ÃƒÂ£' => 'a', 'ÃƒÂ¤' => 'a', 'ÃƒÂ¥' => 'a', 'ÃƒÂ¦' => 'ae', 'ÃƒÂ§' => 'c',
		'ÃƒÂ¨' => 'e', 'ÃƒÂ©' => 'e', 'ÃƒÂª' => 'e', 'ÃƒÂ«' => 'e', 'ÃƒÂ¬' => 'i', 'ÃƒÂ­' => 'i', 'ÃƒÂ®' => 'i', 'ÃƒÂ¯' => 'i',
		'ÃƒÂ°' => 'd', 'ÃƒÂ±' => 'n', 'ÃƒÂ²' => 'o', 'ÃƒÂ³' => 'o', 'ÃƒÂ´' => 'o', 'ÃƒÂµ' => 'o', 'ÃƒÂ¶' => 'o', 'Ã…Â‘' => 'o',
		'ÃƒÂ¸' => 'o', 'ÃƒÂ¹' => 'u', 'ÃƒÂº' => 'u', 'ÃƒÂ»' => 'u', 'ÃƒÂ¼' => 'u', 'Ã…Â±' => 'u', 'ÃƒÂ½' => 'y', 'ÃƒÂ¾' => 'th',
		'ÃƒÂ¿' => 'y',

		// Latin symbols
		'Ã‚Â©' => '(c)',

		// Greek
		'ÃŽÂ‘' => 'A', 'ÃŽÂ’' => 'B', 'ÃŽÂ“' => 'G', 'ÃŽÂ”' => 'D', 'ÃŽÂ•' => 'E', 'ÃŽÂ–' => 'Z', 'ÃŽÂ—' => 'H', 'ÃŽÂ˜' => '8',
		'ÃŽÂ™' => 'I', 'ÃŽÂš' => 'K', 'ÃŽÂ›' => 'L', 'ÃŽÂœ' => 'M', 'ÃŽÂ' => 'N', 'ÃŽÂž' => '3', 'ÃŽÂŸ' => 'O', 'ÃŽ ' => 'P',
		'ÃŽÂ¡' => 'R', 'ÃŽÂ£' => 'S', 'ÃŽÂ¤' => 'T', 'ÃŽÂ¥' => 'Y', 'ÃŽÂ¦' => 'F', 'ÃŽÂ§' => 'X', 'ÃŽÂ¨' => 'PS', 'ÃŽÂ©' => 'W',
		'ÃŽÂ†' => 'A', 'ÃŽÂˆ' => 'E', 'ÃŽÂŠ' => 'I', 'ÃŽÂŒ' => 'O', 'ÃŽÂŽ' => 'Y', 'ÃŽÂ‰' => 'H', 'ÃŽÂ' => 'W', 'ÃŽÂª' => 'I',
		'ÃŽÂ«' => 'Y',
		'ÃŽÂ±' => 'a', 'ÃŽÂ²' => 'b', 'ÃŽÂ³' => 'g', 'ÃŽÂ´' => 'd', 'ÃŽÂµ' => 'e', 'ÃŽÂ¶' => 'z', 'ÃŽÂ·' => 'h', 'ÃŽÂ¸' => '8',
		'ÃŽÂ¹' => 'i', 'ÃŽÂº' => 'k', 'ÃŽÂ»' => 'l', 'ÃŽÂ¼' => 'm', 'ÃŽÂ½' => 'n', 'ÃŽÂ¾' => '3', 'ÃŽÂ¿' => 'o', 'ÃÂ€' => 'p',
		'ÃÂ' => 'r', 'ÃÂƒ' => 's', 'ÃÂ„' => 't', 'ÃÂ…' => 'y', 'ÃÂ†' => 'f', 'ÃÂ‡' => 'x', 'ÃÂˆ' => 'ps', 'ÃÂ‰' => 'w',
		'ÃŽÂ¬' => 'a', 'ÃŽÂ­' => 'e', 'ÃŽÂ¯' => 'i', 'ÃÂŒ' => 'o', 'ÃÂ' => 'y', 'ÃŽÂ®' => 'h', 'ÃÂŽ' => 'w', 'ÃÂ‚' => 's',
		'ÃÂŠ' => 'i', 'ÃŽÂ°' => 'y', 'ÃÂ‹' => 'y', 'ÃŽÂ' => 'i',

		// Turkish
		'Ã…Âž' => 'S', 'Ã„Â°' => 'I', 'ÃƒÂ‡' => 'C', 'ÃƒÂœ' => 'U', 'ÃƒÂ–' => 'O', 'Ã„Âž' => 'G',
		'Ã…ÂŸ' => 's', 'Ã„Â±' => 'i', 'ÃƒÂ§' => 'c', 'ÃƒÂ¼' => 'u', 'ÃƒÂ¶' => 'o', 'Ã„ÂŸ' => 'g',

		// Russian
		'ÃÂ' => 'A', 'ÃÂ‘' => 'B', 'ÃÂ’' => 'V', 'ÃÂ“' => 'G', 'ÃÂ”' => 'D', 'ÃÂ•' => 'E', 'ÃÂ' => 'Yo', 'ÃÂ–' => 'Zh',
		'ÃÂ—' => 'Z', 'ÃÂ˜' => 'I', 'ÃÂ™' => 'J', 'ÃÂš' => 'K', 'ÃÂ›' => 'L', 'ÃÂœ' => 'M', 'ÃÂ' => 'N', 'ÃÂž' => 'O',
		'ÃÂŸ' => 'P', 'Ã ' => 'R', 'ÃÂ¡' => 'S', 'ÃÂ¢' => 'T', 'ÃÂ£' => 'U', 'ÃÂ¤' => 'F', 'ÃÂ¥' => 'H', 'ÃÂ¦' => 'C',
		'ÃÂ§' => 'Ch', 'ÃÂ¨' => 'Sh', 'ÃÂ©' => 'Sh', 'ÃÂª' => '', 'ÃÂ«' => 'Y', 'ÃÂ¬' => '', 'ÃÂ­' => 'E', 'ÃÂ®' => 'Yu',
		'ÃÂ¯' => 'Ya',
		'ÃÂ°' => 'a', 'ÃÂ±' => 'b', 'ÃÂ²' => 'v', 'ÃÂ³' => 'g', 'ÃÂ´' => 'd', 'ÃÂµ' => 'e', 'Ã‘Â‘' => 'yo', 'ÃÂ¶' => 'zh',
		'ÃÂ·' => 'z', 'ÃÂ¸' => 'i', 'ÃÂ¹' => 'j', 'ÃÂº' => 'k', 'ÃÂ»' => 'l', 'ÃÂ¼' => 'm', 'ÃÂ½' => 'n', 'ÃÂ¾' => 'o',
		'ÃÂ¿' => 'p', 'Ã‘Â€' => 'r', 'Ã‘Â' => 's', 'Ã‘Â‚' => 't', 'Ã‘Âƒ' => 'u', 'Ã‘Â„' => 'f', 'Ã‘Â…' => 'h', 'Ã‘Â†' => 'c',
		'Ã‘Â‡' => 'ch', 'Ã‘Âˆ' => 'sh', 'Ã‘Â‰' => 'sh', 'Ã‘ÂŠ' => '', 'Ã‘Â‹' => 'y', 'Ã‘ÂŒ' => '', 'Ã‘Â' => 'e', 'Ã‘ÂŽ' => 'yu',
		'Ã‘Â' => 'ya',

		// Ukrainian
		'ÃÂ„' => 'Ye', 'ÃÂ†' => 'I', 'ÃÂ‡' => 'Yi', 'Ã’Â' => 'G',
		'Ã‘Â”' => 'ye', 'Ã‘Â–' => 'i', 'Ã‘Â—' => 'yi', 'Ã’Â‘' => 'g',

		// Czech
		'Ã„ÂŒ' => 'C', 'Ã„ÂŽ' => 'D', 'Ã„Âš' => 'E', 'Ã…Â‡' => 'N', 'Ã…Â˜' => 'R', 'Ã… ' => 'S', 'Ã…Â¤' => 'T', 'Ã…Â®' => 'U',
		'Ã…Â½' => 'Z',
		'Ã„Â' => 'c', 'Ã„Â' => 'd', 'Ã„Â›' => 'e', 'Ã…Âˆ' => 'n', 'Ã…Â™' => 'r', 'Ã…Â¡' => 's', 'Ã…Â¥' => 't', 'Ã…Â¯' => 'u',
		'Ã…Â¾' => 'z',

		// Polish
		'Ã„Â„' => 'A', 'Ã„Â†' => 'C', 'Ã„Â˜' => 'e', 'Ã…Â' => 'L', 'Ã…Âƒ' => 'N', 'ÃƒÂ“' => 'o', 'Ã…Âš' => 'S', 'Ã…Â¹' => 'Z',
		'Ã…Â»' => 'Z',
		'Ã„Â…' => 'a', 'Ã„Â‡' => 'c', 'Ã„Â™' => 'e', 'Ã…Â‚' => 'l', 'Ã…Â„' => 'n', 'ÃƒÂ³' => 'o', 'Ã…Â›' => 's', 'Ã…Âº' => 'z',
		'Ã…Â¼' => 'z',

		// Latvian
		'Ã„Â€' => 'A', 'Ã„ÂŒ' => 'C', 'Ã„Â’' => 'E', 'Ã„Â¢' => 'G', 'Ã„Âª' => 'i', 'Ã„Â¶' => 'k', 'Ã„Â»' => 'L', 'Ã…Â…' => 'N',
		'Ã… ' => 'S', 'Ã…Âª' => 'u', 'Ã…Â½' => 'Z',
		'Ã„Â' => 'a', 'Ã„Â' => 'c', 'Ã„Â“' => 'e', 'Ã„Â£' => 'g', 'Ã„Â«' => 'i', 'Ã„Â·' => 'k', 'Ã„Â¼' => 'l', 'Ã…Â†' => 'n',
		'Ã…Â¡' => 's', 'Ã…Â«' => 'u', 'Ã…Â¾' => 'z'
	];

	$str = preg_replace( array_keys( $options['replacements'] ), $options['replacements'], $str );

	if ( $options['transliterate'] ) {
		$str = str_replace( array_keys( $char_map ), $char_map, $str );
	}

	$str = preg_replace( '/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	$str = preg_replace( '/(' . preg_quote( $options['delimiter'], '/') . '){2,}/', '$1', $str);
	$str = substr( $str, 0, ( $options['limit'] ? $options['limit'] : strlen( $str ) ) );
	$str = trim( $str, $options['delimiter'] );

	return $options['lowercase'] ? strtolower( $str ) : $str;
}

function base64_url_encode( $query ) {
	return rtrim( strtr( base64_encode( $query ), '+/', '-_' ), '=' );
}

function base64_url_decode( $query ) {
	return base64_decode( str_pad( strtr( $query, '-_', '+/' ), strlen( $query ) % 4, '=', STR_PAD_RIGHT ) );
}
