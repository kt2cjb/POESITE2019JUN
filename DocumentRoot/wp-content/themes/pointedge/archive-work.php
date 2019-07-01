<?php get_header(); ?>

    <div class="list" id="work_list">
      <div class="list-wrap">
        <form class="tag">
          <div class="tag-all">
            <input type="checkbox" name="checkbox" value="All" id="all"/>
            <label class="tag__item" for="all"> All</label>
          </div>
<?php
$c = $_GET['c'] ? $_GET['c'] : false;
$d = [];
$args = [
  'type' => 'work',
  'taxonomy' => 'work_cat',
  'parent' => 0,
  'hide_empty' => false,
];
$parents = get_categories( $args );
?>

<?php foreach($parents as $parentCategory){ ?>
<?php
$child_args = [
  'type' => 'work',
  'taxonomy' => 'work_cat',
  'parent' => $parentCategory->cat_ID,
  'hide_empty' => false,
];
$children = get_categories( $child_args );

$isChecked = false;
if($c === $parentCategory->slug){
  $isChecked = true;
}
?>
          <div class="tag-contents">
            <div class="tag__large">
              <input type="checkbox" name="checkbox" value="<?php echo $parentCategory->slug; ?>" disabled="disabled" id="<?php echo $parentCategory->slug; ?>"/>
              <label class="tag__item" for="<?php echo $parentCategory->slug; ?>"><?php echo $parentCategory->name; ?></label><p class="accordion_icon mg-block"><span></span><span></span></p>
            </div>
            <div class="tag__child">
              <?php foreach($children as $childCategory){ ?>
              <?php if($isChecked){ $d[] = $childCategory->slug; } ?>
              <input class="tag__child--item" type="checkbox" name="checkbox" value="<?php echo $childCategory->slug; ?>" id="<?php echo $childCategory->slug; ?>" <?php echo $isChecked ? 'checked':''; ?>/>
              <label class="tag__item" for="<?php echo $childCategory->slug; ?>"><?php echo $childCategory->name; ?></label>
              <?php } ?>
            </div>
          </div>
<?php } ?>

        </form>
        <div class="list-contents">

<?php
$args = [
  'post_type' => 'work',
  'posts_per_page' => 9,
];
if(count($d)){
  $args['tax_query'] = [
    [
      'taxonomy' => 'work_cat',
      'field'    => 'slug',
      'terms'    => $d,
      'operator' => 'IN',
    ]
  ];
}
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
    $cat = get_the_terms($post->ID,'work_tag');
    foreach($cat as $c){
      $title = $c->name;
  ?>
                <li class="card__list-item"> <a href="/work_tag/<?php echo $c->slug; ?>">#<?php echo $title; ?></a></li>
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