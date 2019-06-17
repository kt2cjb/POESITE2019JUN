<?php if ( is_home() || is_front_page() ) : ?>
    </div>
<?php endif; ?>
    <footer class="footer">
      <div class="footer-wrap">
        <ul class="footer-nav">
          <li class="footer-nav__item"><a class="footer__link" href="/about">ABOUT</a>
          </li>
          <li class="footer-nav__item"><a class="footer__link" href="/service">SERVICE</a>
          </li>
          <li class="footer-nav__item"><a class="footer__link" href="/work">WORK</a>
          </li>
          <li class="footer-nav__item"><a class="footer__link" href="/blog">BLOG</a>
          </li>
          <li class="footer-nav__item"><a class="footer__link" href="/jobs">JOBS</a>
          </li>
          <li class="footer-nav__item">
            <div class="footer__link" id="footer__space">SPACE</div>
          </li>
        </ul><a class="footer__logo" href="/"><img src="<?php echo get_template_directory_uri(); ?>/images/common/footer-logo.svg" alt="株式会社POINT EDGE"></a>
        <div class="footer-list">
          <p class="footer__address">〒150-0002<br>東京都渋谷区渋谷2-22-6 10F</p><a class="footer__coworking" href="http://pointedge.work/shibuya/" target="_blank">POINT EDGE ShibuyaBASE</a><a class="footer__foto" href="http://foto-daikanyama.com/access/" target="_blank">FOTO DAIKANYAMA</a>
          <div class="footer-social">
          <div class="footer__media">POINTEDGE ON SOCIAL MEDIA</div>
            <div class="footer-sns"><a class="facebook" href="https://www.facebook.com/pointedgeinc/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/common/facebook-icon.svg" alt="facebookアイコン"></a><a class="flickr" href="https://www.flickr.com/photos/159661353@N06/albums" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/common/flickr-icon.svg" alt="flickrアイコン"></a></div>
          </div>
        </div>
        <p class="footer__copyright"><small>&copy; 2019 POINT EDGE, Inc.</small></p>
      </div>
    </footer>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bundle.js?<?php echo time(); ?>"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/custom.js?<?php echo time(); ?>"></script>
    <?php wp_footer(); ?>
  </body>
</html>