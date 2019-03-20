<?php

/**
 * SCRIPT INI 100% GRATIS DAN TIDAK DIPERBOLEHKAN UNTUK DIPERJUAL BELIKAN!
 * SAYA BERJANJI TIDAK AKAN MENJUAL SCRIPT INI KEPADA SIAPAPUN
 * JIKA SAYA MENJUAL SCRIPT INI MAKA REZEKI SAYA DAN KETURUNAN SAYA AKAN SERET SELAMANYA!
 * AAMIIN
 */

require 'config/init.php';

require 'core/functions/options.php';
require 'core/functions/permalinks.php';
require 'core/functions/common.php';

if ( $route['name'] == 'sitemap-searches' ) {
  header( "Content-Type: application/xml" );

  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

  echo '
  	<url>
  		<loc>' . site_url() . '</loc>
  		<changefreq>daily</changefreq>
  		<priority>0.6</priority>
  	</url>' . "\n";

  $recent_searches_file = store_dir() . '/searches.json';
  if ( file_exists( $recent_searches_file ) ) {
    $searches = json_decode( file_get_contents( $recent_searches_file ), true );
    foreach( $searches as $item ) {
  		echo '
  			<url>
  				<loc>' . search_permalink( $item['title'] ) . '</loc>
  				<changefreq>daily</changefreq>
  				<priority>0.6</priority>
  			</url>' . "\n";
  	}
  }

  echo '</urlset>';
}

elseif ( $route['name'] == 'sitemap-keywords' ) {
  $id = explode( '-', $route['vars'][0] );
  if ( isset( $id[0] ) && $id[0] > 0 && isset( $id[1] ) && $id[1] > 0 ) {
    $limit = get_option( 'sitemap_limit' );
    $file_number = $id[0];
    $page_number = $id[1];
    $start = ( $page_number - 1 ) * $limit;

    if ( get_option( 'use_default_keyword_files' ) && file_exists( BASE . '/store/default/keywords/' . $file_number . '.txt' ) ) {
      $keyword_file = file( BASE . '/store/default/keywords/' . $file_number . '.txt' );
    } elseif ( file_exists( store_dir() . '/keywords/' . $file_number . '.txt' ) ) {
      $keyword_file = file( store_dir() . '/keywords/' . $file_number . '.txt' );
    }

    if ( isset( $keyword_file ) ) {
      $keywords = array_slice( $keyword_file, $start, $limit );

      if ( $keywords ) {
        header( "Content-Type: application/xml" );

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $keywords = array_map( 'trim', $keywords );
        if ( $keywords ) {
        	foreach( $keywords as $item ) {
        		echo '
        			<url>
        				<loc>' . search_permalink( $item ) . '</loc>
        				<changefreq>daily</changefreq>
        				<priority>0.6</priority>
        			</url>
        		' . "\n";
        	}
        }

        echo '</urlset>';
      }
    }
  }
}

else {
  if ( get_option( 'use_default_keyword_files' ) ) {
    $keywords = glob( BASE . '/store/default/keywords/*.txt' );
  } else {
    $keywords = glob( store_dir() . '/keywords/*.txt' );
  }

  if ( $keywords ) {
    foreach( $keywords as $key => $keyword ) {
      $file = file( $keyword );
      $keyword_count = count( $file );
      if ( $keyword_count > 0 ) {
        for( $i = 1; $i <= ( ceil( $keyword_count / get_option( 'sitemap_limit' ) ) ); $i++ ) {
          $sitemap_by_keywords[] = '<sitemap><loc>' . sitemap_keywords_permalink( ( ( $key + 1 ) . '-' . $i ) ) . '</loc></sitemap>' . "\n";
        }
      }
    }
  }
  
  header( "Content-Type: application/xml" );

  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

  if ( file_exists( store_dir() . '/searches.json' ) ) {
  	echo '
      <sitemap>
  		  <loc>' . sitemap_searches_permalink() . '</loc>
  	  </sitemap>' . "\n";
  }

  if ( isset( $sitemap_by_keywords ) ) {
    foreach ( $sitemap_by_keywords as $sitemap ) {
      echo $sitemap . "\n";
    }
  }

  echo '</sitemapindex>';
}
