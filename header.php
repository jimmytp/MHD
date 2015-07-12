<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=yes" />
<title>
<?php wp_title('|',true,'right'); ?>
</title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="container">
<div id="wrapper">
<div id="header">
  <div id="socialize">
    <?php if (get_theme_mod( 'googleplus_account' )) : ?>
    <a class="socialicon googleplusicon" href="<?php echo esc_url(get_theme_mod( 'googleplus_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'instagram_account' )) : ?>
    <a class="socialicon instagramicon" href="<?php echo esc_url(get_theme_mod( 'instagram_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'tumblr_account' )) : ?>
    <a class="socialicon tumblricon" href="<?php echo esc_url(get_theme_mod( 'tumblr_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'youtube_account' )) : ?>
    <a class="socialicon youtubeicon" href="<?php echo esc_url(get_theme_mod( 'youtube_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'vimeo_account' )) : ?>
    <a class="socialicon vimeoicon" href="<?php echo esc_url(get_theme_mod( 'vimeo_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'flickr_account' )) : ?>
    <a class="socialicon flickricon" href="<?php echo esc_url(get_theme_mod( 'flickr_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'pinterest_account' )) : ?>
    <a class="socialicon pinteresticon" href="<?php echo esc_url(get_theme_mod( 'pinterest_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'dribble_account' )) : ?>
    <a class="socialicon dribbleicon" href="<?php echo esc_url(get_theme_mod( 'dribble_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'linkedin_account' )) : ?>
    <a class="socialicon linkedinicon" href="<?php echo esc_url(get_theme_mod( 'linkedin_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'facebook_account' )) : ?>
    <a class="socialicon facebookicon" href="<?php echo esc_url(get_theme_mod( 'facebook_account')); ?>" target="blank"></a>
    <?php endif ?>
    <?php if (get_theme_mod( 'twitter_account' )) : ?>
    <a class="socialicon twittericon" href="<?php echo esc_url(get_theme_mod( 'twitter_account')); ?>" target="blank"></a>
    <?php endif ?>
  </div>
  <div id="logo"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
    <?php if (get_theme_mod( 'logo_img' )) : ?>
    <img src="<?php echo esc_url(get_theme_mod( 'logo_img')); ?>">
    <?php else : ?>
    <h1 class="site-title">
      <?php bloginfo('name'); ?>
    </h1>
    <?php endif; ?>
    </a>
    <div id="site-description">
      <?php bloginfo( 'description' ); ?>
    </div>
  </div>
  <div id="mainmenu">
    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id'=>'nav', 'menu_class' => 'sf-menu superfish' ) ); ?>
  </div>
</div>
<?php if (is_front_page()) : ?>
<?php
   				$args = array(
   							'posts_per_page' =>-1,
							'post_type' => 'any',
	  						'post__not_in' => get_option( 'sticky_posts' ),
      						'meta_query' => array(
         					array(
            					'key' => '_minimaliste-slider-checkbox',
            					'value' => 'yes'
         						)
      							)
   							);
  				$slider_posts = new WP_Query($args);
			?>
<div id="slidecontainer">
  <?php if($slider_posts->have_posts()) : ?>
  <ul id='slider'>
    <?php while($slider_posts->have_posts()) : $slider_posts->the_post() ?>
    <li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
      <?php the_post_thumbnail('slidethumb'); ?>
      </a></li>
    <?php endwhile ?>
  </ul>
  <?php wp_reset_postdata(); ?>
  <?php endif ?>
</div>
<div id="frontwidget">
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
<?php endif; ?>
