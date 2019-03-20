      <?php
        $searches = get_recent_user_access( get_option( 'recent_searches_count' ) );
        if ( $searches ) {
      ?>
        <div class="recent-search-divider"></div>

        <div class="recent-search clearfix">
          <div class="title">Recent Search</div>

          <div class="items clearfix">
            <?php foreach( $searches as $item ) { ?>
              <a href="<?php echo search_permalink( $item['title'] ); ?>"><?php echo $item['title']; ?></a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <footer id="footer">
      <div class="container">
        <div class="credit">
          <?php echo str_replace( [ '%year%', '%site_name%' ], [ date( 'Y' ), get_option( 'site_name' ) ], get_option( 'footer_copyright' ) ); ?>
        </div>
      </div>
    </footer>

    <?php
      register_script( site_url() . '/assets/js/jquery.min.js' );

      if ( $route['name'] == 'download' ) {
        register_script( site_url() . '/assets/js/jquery.fitvids.js' );
      }

      register_script( site_url() . '/assets/js/scripts.js' );
    ?>

    <?php
      if ( file_exists( BASE . '/config/' . $_SERVER['HTTP_HOST'] . '/_footer.php' ) ) {
        include BASE . '/config/' . $_SERVER['HTTP_HOST'] . '/_footer.php';
      }
    ?>
  </body>
</html>
