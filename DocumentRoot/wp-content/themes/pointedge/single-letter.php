<?php get_header(); ?>
    <div class="letter">

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<?php
$image = get_field('image');
?>

      <div class="letter-contents">
        <div class="letter__inner">
          <p class="letter__description">editor's letter</p>
          <p class="letter__num"><?php the_field('vol'); ?></p>
          <p class="letter__writer">text: <?php the_author(); ?></p>
          <h1 class="letter__ttl">「<?php the_field('theme'); ?>」</h1>
          <div class="letter__txt">
            <?php the_content(); ?>
          </div>
          <time class="letter__time" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
          <div class="introduction">
            <div class="introduction__img"><img src="<?php echo $image['url']; ?>" alt="「<?php the_field('theme'); ?>」の作品"></div>
            <div class="introduction-contents">
              <h2 class="introduction-contents__ttl mb10"><?php the_title(); ?></h2>
              <p class="introduction-contents__txt"><?php the_field('year'); ?><br><?php the_field('spec'); ?></p><a class="introduction-contents__name mt20 mb20" href="<?php the_field('url'); ?>" target="_blanck"><?php the_field('author'); ?></a>
              <p class="introduction-contents__career"><?php the_field('profile'); ?></p>
            </div>
          </div>
        </div>
        <div class="letter__bg" style="background-image:url('<?php echo $image['url']; ?>');"></div>
      </div>

<?php endwhile; endif; ?>

      <div class="letter-gallery">
        <h2 class="letter-gallery__ttl">POINT EDGE  Gallery</h2>
        <div class="gallery">
<?php
$args = [
  'post_type' => 'letter',
  'posts_per_page' => 9
];
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {
	while ( $post = $the_query->have_posts() ) {
    $the_query->the_post();
    $postId = $post->ID;
    $image = get_field('image');
?>
          <div class="gallery-wrap wow fadeInUp"><a class="gallery__link" href="<?php the_permalink(); ?>">
              <div class="gallery__img"><img src="<?php echo $image['url']; ?>"/></div>
              <h3 class="gallery__ttl"><?php the_title(); ?></h3>
              <p class="gallery__txt"><?php the_field('year'); ?></p>
              <p class="gallery__txt"><?php the_field('spec'); ?></p>
            </a></div>
<?php
	}
	wp_reset_postdata();
}
?>
        </div>
      </div>
    </div>
<?php get_footer(); ?>