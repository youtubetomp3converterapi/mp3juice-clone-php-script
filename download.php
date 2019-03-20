<?php

/**
 * SCRIPT INI 100% GRATIS DAN TIDAK DIPERBOLEHKAN UNTUK DIPERJUAL BELIKAN!
 * SAYA BERJANJI TIDAK AKAN MENJUAL SCRIPT INI KEPADA SIAPAPUN
 * JIKA SAYA MENJUAL SCRIPT INI MAKA REZEKI SAYA DAN KETURUNAN SAYA AKAN SERET SELAMANYA!
 * AAMIIN
 */

require 'config/init.php';

require 'libraries/ua.class.php';
require 'libraries/simple_html_dom.php';

require 'core/functions/options.php';
require 'core/functions/cache.php';
require 'core/functions/permalinks.php';
require 'core/functions/common.php';
require 'core/functions/site.php';

require 'core/classes/agc.php';

dmca_redirect();

delete_cache( get_cache_path() . '/downloads', 43200 );

$result = agc()->get_download();
if ( $result ) {
  $site_title = str_replace( [ '%title%', '%duration%', '%domain%' ], [ $result['title'], $result['duration'], $_SERVER['HTTP_HOST'] ], get_option( 'download_title' ) );
  $meta_description = str_replace( [ '%title%', '%duration%', '%domain%' ], [ $result['title'], $result['duration'], $_SERVER['HTTP_HOST'] ], get_option( 'download_description' ) );
  $meta_robots = get_option( 'download_robots' );

  if ( $result['source'] == 'yt' ) {
  } elseif ( $result['source'] == 'sc' ) {
    $audio_url = agc()->get_soundcloud_stream_url( $result['id'], $result['client_id'] );
    $result['audio_url'] = $audio_url;
  }
} else {
  redirect( site_url() );
}

include 'includes/header.php';

?>
  <h1 class="page-title"><?php echo str_replace( '%title%', $result['title'], get_option( 'download_page_title' ) ); ?></h1>

  <div class="download clearfix">
    <?php if ( $result['source'] == 'yt' ) { ?>
      <div class="embed clearfix">
	  <center><iframe src="https://stream.download-lagu-mp3.com/video.php?id=<?php echo $result['id']; ?>" width="100%" height="316" frameBorder="0" scrolling="no" allowfullscreen></iframe></center>
      <center><iframe src="https://stream.download-lagu-mp3.com/audio.php?id=<?php echo $result['id']; ?>" width="100%" height="65"></iframe></center>
      </div>
    <?php } else { ?>
      <div class="image">
        <img src="<?php echo $result['image']; ?>" alt="<?php echo htmlentities( $result['title'], ENT_QUOTES ); ?>" />
      </div>

      <?php if ( isset( $result['audio_url'] ) ) { ?>
        <div class="audio-player">
          <audio controls><source src="<?php echo $result['audio_url']; ?>" type="audio/mpeg">Your browser does not support the audio element.</audio>
        </div>
      <?php } ?>
    <?php } ?>

    <div class="info">
      <table>
        <tr>
          <td width="30%">Title</td>
          <td><strong><?php echo $result['title']; ?></strong></td>
        </tr>
        <tr>
          <td>Uploader</td>
          <td><strong><?php echo $result['channel']; ?></strong></td>
        </tr>
        <tr>
          <td>Duration</td>
          <td><strong><?php echo $result['duration']; ?></strong></td>
        </tr>
        <tr>
          <td>Type of File</td>
          <td><strong>Audio (.mp3)<?php echo ( $result['source'] == 'yt' ) ? ' and Video (.mp4)' : ''; ?></strong></td>
        </tr>
      </table>
    </div>

    <div class="text">
      The song of <strong><?php echo $result['title']; ?></strong> is just for review only. If you really love this song
      <em>"<?php echo $result['title']; ?>"</em>, please buy the original song to support author or singer of this song.
    </div>

    <?php if ( $result['source'] == 'sc' && isset( $result['audio_url'] ) ) { ?>
      <div class="buttons clearfix">
        <a class="mp3" rel="nofollow" href="<?php echo file_permalink() . '?u=' . base64_url_encode( $result['audio_url'] ) . '&ti=' . urlencode( $result['title'] ) . '&s=1&ty=mp3'; ?>">Download Mp3</a>
      </div>
    <?php } else { ?>
	<br>
	  <iframe class="button-api-frame" src="https://api.download-lagu-mp3.com/@api/button/mp3/<?php echo $result['id']; ?>" width="100%" height="100%" allowtransparency="true" scrolling="no" style="border:none"></iframe>
	  <iframe class="button-api-frame" src="https://api.download-lagu-mp3.com/@api/button/videos/<?php echo $result['id']; ?>" width="100%" height="100%" allowtransparency="true" scrolling="no" style="border:none"></iframe>
    <?php } ?>
  </div>
<?php include 'includes/footer.php'; ?>
