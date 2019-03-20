<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />

    <title><?php echo site_title( $site_title ); ?></title>

    <?php if ( isset( $meta_description ) ) { ?>
      <meta name="description" content="<?php echo $meta_description; ?>" />
      <meta property="og:description" content="<?php echo $meta_description; ?>" />
    <?php } ?>

    <meta property="og:site_name" content="<?php echo get_option( 'site_name' ); ?>" />
    <meta property="og:title" content="<?php echo $site_title; ?>" />
    <meta property="og:url" content="<?php echo canonical_url(); ?>" />

    <?php if ( isset( $meta_robots ) ) { ?>
      <meta name="robots" content="<?php echo $meta_robots; ?>" />
    <?php } ?>

    <?php if ( isset( $result[0]['image'] ) ) { ?>
      <meta property="og:image" content="<?php echo $result[0]['image']; ?>" />
    <?php } elseif ( isset( $result['image'] ) ) { ?>
      <meta property="og:image" content="<?php echo $result['image']; ?>" />
    <?php } ?>

    <?php register_stylesheet( site_url() . '/assets/css/style.css' ); ?>

    <?php
      if ( file_exists( BASE . '/config/' . $_SERVER['HTTP_HOST'] . '/_header.php' ) ) {
        include BASE . '/config/' . $_SERVER['HTTP_HOST'] . '/_header.php';
      }
    ?>
<style>
.button-api-frame{
height : 85px;
}
@media only screen and (max-width: 500px) {
    .button-api-frame{
    height : 100%;
    }
}
</style>
  </head>

  <body>
    <div class="container">
      <header id="header" class="clearfix">
        <div class="site-info">
          <div class="site-name">
            <a href="<?php echo site_url(); ?>"><?php echo get_option( 'site_name' ); ?></a>
          </div>

          <div class="site-tagline"><?php echo get_option( 'site_tagline' ); ?></div>
        </div>
      </header>

      <form method="get" action="<?php echo site_url(); ?>" class="search-form clearfix">
        <input value="<?php echo get_search_query(); ?>" autocomplete="off" type="text" name="search" placeholder="Type text and hit enter to search ..." />
      </form>
