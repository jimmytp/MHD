<?php get_header(); ?>

<div id="content">
  <?php while ( have_posts() ) : the_post(); ?>
  <div <?php post_class(); ?>>
    <?php /*
    <div id="slidecontainer">
      <ul id="slider">
        <?php minimaliste_get_images("$post->ID"); ?>
      </ul>
    </div>
    */ ?>
    <div class="entry">
      <div class="postdata">
        <?php the_date(); ?>
      </div>
      <h1 class="entry-title">
        <?php the_title(); ?>
      </h1>
      <?php the_content('read more'); ?>
      <p>
        <?php the_tags('Tags:', ', ', '<br />'); ?>
      </p>
      <?php comments_template(); ?>
    </div>
  </div>
  <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
