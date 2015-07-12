<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
    <div id="slidecontainer">
      <ul id="slider">
        <?php minimaliste_get_images("$post->ID"); ?>
      </ul>
    </div>
    <div class="entry">
      <h1 class="entry-title">
        <?php the_title(); ?>
      </h1>
      <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
      <?php comments_template( '', true ); ?>
      <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    </div>
  </div>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
