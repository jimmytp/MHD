<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <a class="blogpost"  href="<?php the_permalink(); ?>">
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
  <p class="center">You don't have any posts yet.</p>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
