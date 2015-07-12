<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : ?>
  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
  <?php /* If this is a category archive */ if (is_category()) { ?>
  <h2 class="pagetitle">Archive for the &#8216;
    <?php single_cat_title(); ?>
    &#8217; Category</h2>
  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
  <h2 class="pagetitle">Posts Tagged &#8216;
    <?php single_tag_title(); ?>
    &#8217;</h2>
  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
  <h2 class="pagetitle">Archive for
    <?php the_time('F jS, Y'); ?>
  </h2>
  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
  <h2 class="pagetitle">Archive for
    <?php the_time('F, Y'); ?>
  </h2>
  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
  <h2 class="pagetitle">Archive for
    <?php the_time('Y'); ?>
  </h2>
  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
  <h2 class="pagetitle">Author Archive</h2>
  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="pagetitle">Blog Archives</h2>
    <?php } ?>
  <?php while (have_posts()) : the_post(); ?>
  <a class="blogpost"  href="<?php the_permalink() ?>">
   <?php the_post_thumbnail('mainthumb'); ?>
  <div class="mask">
    <h2 class="entry-title">
      <?php the_title(); ?>
    </h2>
  </div>
  </a>
  <?php endwhile; ?>
  <div id="blognav">
    <?php minimaliste_pagination(); ?>
  </div>
  <?php else : ?>
  <h2 class="center">Not Found</h2>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
