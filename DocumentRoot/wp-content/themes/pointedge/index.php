<?php get_header(); ?>
      <div class="top-section top-section2">
        <section class="top-belief">
          <div class="top-belief-wrap">
            <div class="top-belief-contents">
              <h2 class="top-belief__ttl">意味を,<br class="sp-none">デザインする.</h2>
              <div class="top-belief-word">
                <p class="top-belief__txt">私たちは、ビジネスの課題設定からコンセプトの定義、ブランディングまで、「意味をデザイン」するビジネスデザイン集団です。</p>
                <p class="top-belief__txt">私たちのアプローチは、これ一つと言えるものではなく、多様で複雑です。ビジネスの在り方や置かれた環境は一様でなく、適切なアプローチの選択を重ねることで、ゴールに到達できると信じているからです。</p>
                <p class="top-belief__txt">動かなければ、ビジネスにはならない。自明の理ですが、多くの企業が乗り越えるべき課題でもあります。だから、私たちは「言葉」を大事にします。複雑な課題も、組織のビジョンも言語化し、正しく、深く伝わるように。そして、ビジネスの未来を実現するために、どこまでも並走します。</p>
                <p class="top-belief__txt">「言葉」を武器に、ビジネスのあるべき姿を実現していく。これが、私たちの考えるビジネスデザインです。</p>
              </div>
            </div>
          </div>
        </section>
        <section class="top-work">
          <div class="top-work__bg rellax" data-rellax-percentage="0.5" data-rellax-speed="6"></div>
          <div class="top-work__parallax">
            <div class="top-work-wrap">
              <div class="top-work-contents">
                <h2 class="top-work__ttl">SERVICE</h2>
                <div class="work">
                  <div class="work-wrap">
                    <div class="work__line"></div>
                    <h3 class="work__ttl">BUSINESS</h3>
                    <h4 class="work__sbttl">management</h4>
                    <p class="work__txt">顧客体験と事業のフィージビリティが共存する生態系のデザイン</p>
                    <ul class="work__list mb40">
                      <li class="work__list-item">Business Concept</li>
                      <li class="work__list-item">Business Strategy</li>
                      <li class="work__list-item">Service Design</li>
                      <li class="work__list-item">Interface Design</li>
                      <li class="work__list-item">Business Development</li>
                    </ul>
                    <div class="btn"><a href="/service/#business">view more</a></div>
                  </div>
                  <div class="work-wrap">
                    <div class="work__line"></div>
                    <h3 class="work__ttl">BRAND</h3>
                    <h4 class="work__sbttl">management</h4>
                    <p class="work__txt">世界観を言葉・ビジュアルへと昇華させ共感を広める仕組みのデザイン</p>
                    <ul class="work__list mb40">
                      <li class="work__list-item">Brand Strategy</li>
                      <li class="work__list-item">Brand Identity</li>
                      <li class="work__list-item">Inner Branding</li>
                      <li class="work__list-item">Brand Experience</li>
                      <li class="work__list-item">Advertising</li>
                    </ul>
                    <div class="btn"><a href="/service/#brand">view more</a></div>
                  </div>
                  <div class="work-wrap">
                    <div class="work__line"></div>
                    <h3 class="work__ttl">COMMUNITY </h3>
                    <h4 class="work__sbttl">management</h4>
                    <p class="work__txt">有機的な結びつきをもたらしアイデアと文化が生まれる場のデザイン</p>
                    <ul class="work__list mb40">
                      <li class="work__list-item">Workshop</li>
                      <li class="work__list-item">Community Design</li>
                      <li class="work__list-item">Space &amp; Operation</li>
                      <li class="work__list-item">Coordination</li>
                      <li class="work__list-item">Community Branding</li>
                    </ul>
                    <div class="btn"><a href="/service/#community">view more</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="top-study">
          <div class="top-study-wrap">
            <h2 class="top-study__ttl">WORK<br>/BLOG</h2>
            <div class="top-study-contents">
              <div class="top-study-contents-in">
                
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
                <div class="top-study-contents__item">
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
              <div class="top-study__btn">
                <div class="btn"><a href="/work/">all work</a></div>
                <div class="btn"><a href="/blog/">all blog</a></div>
              </div>
            </div>
            
          </div>
          
        </section>
        <section class="top-news">
          <div class="top-news-wrap">
            <h2 class="top-news__ttl">NEWS</h2>
            <div class="news">

<?php
$args = [
  'post_type' => 'news',
  'posts_per_page' => 5,
];
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {
	while ( $post = $the_query->have_posts() ) {
    $the_query->the_post();
?>
              <a class="news__link" href="<?php the_permalink(); ?>">
                <time class="news__time"><?php the_time('Y.m.d'); ?></time>
                <p><?php echo get_the_title(); ?></p>
              </a>
<?php
	}
	wp_reset_postdata();
}
?>
            </div>
          </div>
        </section>
        <section class="top-space" id="top-space">
          <div class="top-space-wrap">
            <h2 class="top-space__ttl">SPACE</h2>
            <div class="top-space__card">
              <div class="space">
                <div class="space__contents">
                  <div class="space__logo"><img src="<?php echo get_template_directory_uri(); ?>/images/top/space-logo1.svg" alt="POINT EDGE ShibuyaBASE"/></div>
                  <h3 class="space__ttl">POINT EDGE ShibuyaBASE</h3>
                  <p class="space__txt">〒150-0002  東京都渋谷区渋谷2-22-6 10F<br/>平日:10:00 – 22:00(受付終了：20:00)<br/>土日祝日：定休日</p><a class="space__link" href="http://www.pointedge.work/shibuya/" target="_blank">http://www.pointedge.work/shibuya/</a>
                </div><a class="space__img" href="http://www.pointedge.work/shibuya/" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/top/space-img1.png')"></a>
              </div>
              <div class="space">
                <div class="space__contents">
                  <div class="space__logo"><img src="<?php echo get_template_directory_uri(); ?>/images/top/space-logo2.svg" alt="FOTO DAIKANYAMA"/></div>
                  <h3 class="space__ttl">FOTO DAIKANYAMA</h3>
                  <p class="space__txt">〒153-0042  東京都目黒区青葉台1-6-1  B1</p><a class="space__link" href="http://foto-daikanyama.com/access/" target="_blank">http://foto-daikanyama.com/access/</a>
                </div><a class="space__img" href="http://foto-daikanyama.com/access/" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/top/space-img2.png')"></a>
              </div>
            </div>
          </div>
        </section>
      </div>
<?php get_footer(); ?>