<?php /* Template Name: Parent Page */ ?>

<?php get_header(); ?>

<div class="content-parent">
  <div class="content">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>

  <ul class="children">
    <?php
      $children = get_pages( array( 'child_of' => $post->ID, 'sort_column'=>'menu_order') );

      foreach( $children as $page ) {
        $content = $page->post_content;
      ?>
        <li>
          <a href="<?php echo get_page_link( $page->ID ); ?>">
            <?php echo get_the_post_thumbnail( $page->ID, 'medium' ); ?>
            <h3><?php echo $page->post_title; ?></h3>
          </a>
        </li>
      <?php
      }
    ?>
  </ul>

</div>

<?php get_footer(); ?>
