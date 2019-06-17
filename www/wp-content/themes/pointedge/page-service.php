<?php
get_header();
the_post();
?>
    <div class="service">
      <div class="service-wrap">
        <?php the_content(); ?>
        <section class="detail-relation service-new">
          <h2 class="detail-relation__ttl">What’s New?</h2>
          <h3 class="detail-relation__sbttl mb50">最新記事</h3>
          <div class="service-new-wrap">
<?php
$args = [
  'post_type' => ['blog','work'],
  'posts_per_page' => 6, 
];
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {
  while ( $post = $the_query->have_posts() ) {
    $the_query->the_post();
?>
            <div class="service-new__item">
              <div class="card wow fadeInUp"><a class="card__link" href="<?php the_permalink(); ?>">
                <div class="card__img"><?php the_post_thumbnail(); ?></div>
                <h3 class="card__ttl"><?php echo get_the_title(); ?></h3></a>
                <p class="card__txt"><?php echo get_field('read'); ?></p>
                <ul class="card__list">
                <?php if($post->post_type==='blog'): ?>
    <?php
      $cat = get_the_terms($post->ID,'blog_tag');
      foreach($cat as $c){
        $title = $c->name;
    ?>
                  <li class="card__list-item"> <a href="/blog_tag/<?php echo $c->slug; ?>">#<?php echo $title; ?></a></li>
    <?php } ?>
    <?php else: ?>
    <?php
      $cat = get_the_terms($post->ID,'work_tag');
      foreach($cat as $c){
        $title = $c->name;
    ?>
                    <li class="card__list-item"> <a href="/work_tag/<?php echo $c->slug; ?>">#<?php echo $title; ?></a></li>
    <?php } ?>
    <?php endif; ?>
                </ul>
              </div>
            </div>
<?php
	}
	wp_reset_postdata();
}
?>
            
            
            
            
          </div>
        </section>
      </div>
    </div>
<?php
get_footer();
?>