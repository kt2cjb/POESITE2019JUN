<?php get_header(); ?>

    <div class="list mt40" id="blog_list">
      <div class="list-wrap">
        <div class="list-contents">

<?php
$args = [
  'post_type' => 'blog',
  'posts_per_page' => 9,
];
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {
	while ( $post = $the_query->have_posts() ) {
    $the_query->the_post();
?>
          <div class="list-contents__item">
            <div class="card"><a class="card__link" href="<?php the_permalink(); ?>">
                <div class="card__img"><?php the_post_thumbnail(); ?></div>
                <h3 class="card__ttl"><?php echo get_the_title(); ?></h3></a>
                <p class="card__txt"><?php echo get_field('read'); ?></p>
              <ul class="card__list">
  <?php
    $cat = get_the_terms($post->ID,'blog_tag');
    foreach($cat as $c){
      $title = $c->name;
  ?>
                <li class="card__list-item"> <a href="/blog_tag/<?php echo $c->slug; ?>">#<?php echo $title; ?></a></li>
  <?php } ?>
              </ul>
            </div>
          </div>
<?php
	}
	wp_reset_postdata();
}
?>      
        </div>
      </div>
    </div>

<?php get_footer(); ?>