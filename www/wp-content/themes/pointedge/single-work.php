<?php get_header(); ?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<div class="detail">
<?php the_content(); ?>

    <?php
        $articles = get_field('articles');
        if($articles){
    ?>
    <section class="detail-relation pb60">
        <h2 class="detail-relation__ttl">WHY DONT YOU READ?</h2>
        <h3 class="detail-relation__sbttl">関連記事</h3>
        <div class="detail-relation-contents">
        
        <?php foreach($articles as $article){ ?>
            <?php $ar = get_post($article['article']->ID); ?>
            <div class="detail-relation-contents__item">
                <div class="card wow fadeInUp"><a class="card__link" href="<?php the_permalink($ar); ?>">
                    <div class="card__img"><?php echo get_the_post_thumbnail($ar->ID); ?></div>
                    <h3 class="card__ttl"><?php echo get_the_title($ar->ID); ?></h3>
                    <p class="card__txt"><?php echo get_field('read',$ar->ID); ?></p></a>
                    <ul class="card__list">
                    <?php
    $cat = get_the_terms($ar->ID,'work_tag');
    foreach($cat as $c){
      $title = $c->name;
    ?>
                    <li class="card__list-item"> <a href="/work_tag/<?php echo $c->slug; ?>">#<?php echo $title; ?></a></li>
    <?php } ?>
                    </ul>
                </div>
            </div>
          <?php } ?>
          
          
        </div>
      </section>
    <?php
        }
    ?>
</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>