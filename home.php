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

require 'libraries/ua.class.php';

require 'core/functions/options.php';
require 'core/functions/cache.php';
require 'core/functions/permalinks.php';
require 'core/functions/common.php';
require 'core/functions/site.php';

require 'core/classes/agc.php';

if ( isset( $_GET['search'] ) ) {
  if ( $_GET['search'] ) {
    redirect( search_permalink( $_GET['search'] ) );
  } else {
    redirect( site_url() );
  }
}

delete_cache( get_cache_path() . '/home', 43200 );

$site_title = get_option( 'site_tagline' );
$meta_description = str_replace( [ '%site_name%', '%domain%' ], [ get_option( 'site_name' ), $_SERVER['HTTP_HOST'] ], get_option( 'home_description' ) );

$top_songs = agc()->get_itunes_top_songs();
$new_releases = agc()->get_itunes_new_releases();
$top_videos = agc()->get_youtube_top_videos();

include 'includes/header.php';

?>
  <div class="tabs-nav clearfix">
    <a rel="nofollow" href="javascript:;" class="active" data-target="top-songs">Top Songs</a>
    <span>&bull;</span>
    <a rel="nofollow" href="javascript:;" data-target="new-releases">New Releases</a>
    <span>&bull;</span>
    <a rel="nofollow" href="javascript:;" data-target="top-videos">Top Videos</a>
  </div>

  <div class="main-items clearfix">
    <div class="list clearfix" id="top-songs">
      <?php if ( $top_songs ) { ?>
        <div class="items clearfix">
          <?php foreach ( $top_songs as $item ) { ?>
            <div class="item clearfix">
              <div class="image">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlentities( $item['title'], ENT_QUOTES ); ?>" />
              </div>

              <div class="info">
                <h2 class="title" title="<?php echo htmlentities( $item['title'], ENT_QUOTES ); ?>"><?php echo $item['title']; ?></h2>
                <div class="artist"><?php echo $item['artist']; ?></div>
                <div class="btn">
                  <a title="Download <?php echo htmlentities( $item['title'], ENT_QUOTES ); ?> Mp3 and Videos" href="<?php echo search_permalink( $item['title'] ); ?>">Download</a>
                </div>
              </div>
            </div>
          <?php } unset( $item ); ?>
        </div>
      <?php } ?>
    </div>

    <div class="list clearfix" id="new-releases">
      <?php if ( $new_releases ) { ?>
        <div class="items clearfix">
          <?php foreach ( $new_releases as $item ) { ?>
            <div class="item clearfix">
              <div class="image">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlentities( $item['title'], ENT_QUOTES ); ?>" />
              </div>

              <div class="info">
                <h2 class="title" title="<?php echo htmlentities( $item['title'], ENT_QUOTES ); ?>"><?php echo $item['title']; ?></h2>
                <div class="artist"><?php echo $item['artist']; ?></div>
                <div class="btn">
                  <a title="Download <?php echo htmlentities( $item['title'], ENT_QUOTES ); ?> Mp3 and Videos" href="<?php echo search_permalink( $item['title'] ); ?>">Download</a>
                </div>
              </div>
            </div>
          <?php } unset( $item ); ?>
        </div>
      <?php } ?>
    </div>

    <div class="list clearfix" id="top-videos">
      <?php if ( $top_videos ) { ?>
        <div class="items clearfix">
          <?php foreach ( $top_videos as $item ) { ?>
            <div class="item clearfix">
              <div class="image">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlentities( $item['title'], ENT_QUOTES ); ?>" />
              </div>

              <div class="info">
                <div class="title"><?php echo $item['title']; ?></div>
                <div class="artist"><?php echo $item['channel']; ?></div>
                <div class="btn">
                  <a title="Download <?php echo htmlentities( $item['title'], ENT_QUOTES ); ?> Mp3 and Videos" href="<?php echo download_permalink( $item['title'], 'yt--' . $item['id'] ); ?>">Download</a>
                </div>
              </div>
            </div>
          <?php } unset( $item ); ?>
        </div>
      <?php } ?>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>
