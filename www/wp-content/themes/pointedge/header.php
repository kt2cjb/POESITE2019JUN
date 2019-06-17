<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/icon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/icon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/icon/manifest.json">
    <link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#444444">
    <link rel="shortcut icon" href="/icon/favicon.ico">
    <!-- <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:site_name" content="">
    <meta property="og:type" content="">
    <meta name="twitter:card" content="">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <meta itemprop="image" content="">
    <meta name="msapplication-TileColor" content="">
    <meta name="msapplication-TileImage" content=""> -->
    <title>POINT EDGE</title>
    <meta name="keywords" content="POINT EDGE,Business Design Farm">
    <meta name="description" content="POINT EDGE | Business Design Farm">
    <!-- <link rel="icon" sizes="16x16 32x32 48x48 64x64" href="">
    <link rel="apple-touch-icon-precomposed" href="">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="">
    <link rel="apple-touch-icon-precomposed" href=""> -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo time(); ?>">
    <script>
      (function(d) {
        var config = {
            kitId: 'bpv2wsf',
            scriptTimeout: 3000,
            async: true
        },
        h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
      })(document);
    </script>
    <link rel="stylesheet" href="https://use.typekit.net/cjz2gqh.css">
	<?php wp_head(); ?>
  </head>


  <!-- <body <?php body_class(); ?> <?php if ( is_home() || is_front_page() ) : ?>style="opacity:0;"<?php endif; ?>> -->
  <body <?php body_class(); ?>>

<!-- <div style="z-index:500; position:fixed; background-color:#FFF;bottom:0px;left:0; width:100%;" id="debug">aaaa</div> -->

  <?php if ( is_home() || is_front_page() ) : ?>
    <div class="top-page">
      <div class="top-section top-section1">
  <?php endif; ?>

		    <header class="header">
          <h1 class="header__logo"><a class="logo-left" href="/"><img src="<?php echo get_template_directory_uri(); ?>/images/common/logo_left.png" alt="株式会社POINT EDGE マーク"></a>
            <div class="logo-rignt"><a class="logo-right__name" href="/"><img src="<?php echo get_template_directory_uri(); ?>/images/common/logo_right.svg" alt="株式会社POINT EDGE"></a>
              <p class="logo-right__txt sp-none">意味を,デザインする.</p>
            </div>
          </h1>
          <div class="nav-toggle pc-none">
            <div class="nav-toggle-wrap">
              <div class="toggle__item">
                <div class="toggle__animation1"></div>
              </div>
              <div class="toggle__item">
                <div class="toggle__animation2"></div>
              </div>
              <div class="toggle__item">
                <div class="toggle__animation3"></div>
              </div>
            </div>
          </div>
          <div class="nav__bg"></div>
          <div class="nav__cansel">
            <div class="cansel"></div>
          </div><a class="header__contact sp-none" href="/contact" id="contact">CONTACT</a>
          <nav class="nav">
            <ul class="nav-wrap">
              <li class="nav__item"> <a class="nav__link" href="/about" id="about">ABOUT</a>
              </li>
              <li class="nav__item"> <a class="nav__link" href="/service" id="service">SERVICE</a>
              </li>
              <li class="nav__item"> <a class="nav__link" href="/work" id="work">WORK</a>
              </li>
              <li class="nav__item"> <a class="nav__link" href="/blog" id="blog">BLOG</a>
              </li>
              <li class="nav__item"> <a class="nav__link" href="/jobs" id="jobs">JOBS</a>
              </li>
              <li class="nav__item"> 
                <div class="nav__link space__toggle">SPACE
                  <ul class="pull-down">
                    <li class="pull-down__item"><a href="https://www.pointedge.work/shibuya/" target="_blank">ShibuyaBase</a></li>
                    <li class="pull-down__item"><a href="http://foto-daikanyama.com/" target="_blank">foto</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav__item pc-none"><a class="nav__link" href="/contact">CONTACT</a></li>
            </ul>
          </nav>
        </header>
<?php if ( is_home() || is_front_page() ) : ?>
<?php
$args = [
  'post_type' => 'letter',
  'posts_per_page' => 1 
];
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {
	while ( $post = $the_query->have_posts() ) {
    $the_query->the_post();
    $postId = $post->ID;
    $image = get_field('image');
?>
        <section class="top-letter">
          <div class="top-letter-wrap">
            <div class="top-letter__slider">
              <div class="top-letter__slider-img" id="container"style="background: url('<?php echo $image['url']; ?>') center center no-repeat"></div>
            </div>
          </div>
          <div class="bookmark">
            <div class="bookmark-item">
              <p class="bookmark__description">Inspiring word  </p>
              <p class="bookmark__num"><?php the_field('vol'); ?></p>
              <h2 class="bookmark__ttl">「<?php the_field('theme'); ?>」</h2>
              <p class="bookmark__txt"><?php the_field('author'); ?><br><?php the_field('year'); ?></p><a class="bookmark__link" href="<?php the_permalink(); ?>">editor's letter</a>
            </div>
          </div>
        </section>
      </div>
<?php
	}
	wp_reset_postdata();
}
?>
<?php endif; ?>