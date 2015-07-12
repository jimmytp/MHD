<?php
function minimaliste_setup() {
	global $content_width;
if ( ! isset( $content_width ) ){
      $content_width = 1000;
}
	add_theme_support( 'automatic-feed-links' );
	register_nav_menu( 'primary', 'Main Menu');
	add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
	) );
	add_theme_support( 'post-thumbnails' );
	add_image_size('mainthumb', 250, 250, true);
	add_image_size('slidethumb', 1000, 500, true);
}
add_action( 'after_setup_theme', 'minimaliste_setup' );
function minimaliste_scripts() {
	wp_enqueue_style( 'minimaliste-style', get_stylesheet_uri() );
	wp_enqueue_script( 'minimaliste-menu', get_template_directory_uri() . '/js/mainmenu.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'minimaliste-slideshow', get_template_directory_uri() . '/js/slippry.js', array( 'jquery' ), '', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'minimaliste_scripts' );
function minimaliste_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'minimaliste_page_menu_args' );
function minimaliste_widgets_init() {
	
	register_sidebar( array(
		'name' => 'Front Page Widget',
		'id' => 'sidebar-1',
		'description' => 'Appears on the front page of the website,below the slider',
		'before_widget' => '<div id="%1$s" class="widgets">',
      	'after_widget' => '</div>',
		'before_title' => '<h2><span>',
		'after_title' => '</span></h2>',
	) );
	
}
add_action( 'widgets_init', 'minimaliste_widgets_init' );

if ( ! function_exists( 'minimaliste_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 */
function minimaliste_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>

<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
  <h3 class="assistive-text"> Post navigation </h3>
  <div class="nav-previous">
    <?php next_posts_link('<span class="meta-nav">&larr;</span> Older posts'); ?>
  </div>
  <div class="nav-next">
    <?php previous_posts_link('Newer posts <span class="meta-nav">&rarr;</span>'); ?>
  </div>
</nav>
<!-- #<?php echo $html_id; ?> .navigation -->
<?php endif;
}
endif;

if ( ! function_exists( 'minimaliste_comment' ) ) :
function minimaliste_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <p> Pingback:
    <?php comment_author_link(); ?>
    <?php edit_comment_link('(Edit)', '<span class="edit-link">', '</span>' ); ?>
  </p>
  <?php
			break;
		default :
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <article id="comment-<?php comment_ID(); ?>" class="comment">
    <header class="comment-meta comment-author vcard">
      <?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span>' . 'Post author'. '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf('%1$s at %2$s', get_comment_date(), get_comment_time() )
					);
				?>
    </header>
    <!-- .comment-meta -->
    
    <?php if ( '0' == $comment->comment_approved ) : ?>
    <p class="comment-awaiting-moderation"> Your comment is awaiting moderation. </p>
    <?php endif; ?>
    <section class="comment-content comment">
      <?php comment_text(); ?>
      <?php edit_comment_link('Edit', '<p class="edit-link">', '</p>' ); ?>
    </section>
    <!-- .comment-content -->
    
    <div class="reply">
      <?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'Reply', 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <!-- .reply --> 
  </article>
  <!-- #comment-## -->
  <?php
		break;
	endswitch; // end comment_type check
}
endif;
add_filter( 'wp_title', 'minimaliste_title', 10, 3 );
function minimaliste_title( $title, $sep, $seplocation )
{
    global $page, $paged;
    // Don't affect in feeds.
    if ( is_feed() )
        return $title;
    // Add the blog name
    if ( 'right' == $seplocation )
        $title .= get_bloginfo( 'name' );
    else
        $title = get_bloginfo( 'name' ) . $title;
    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title .= " {$sep} {$site_description}";
    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
    return $title;
}
function minimaliste_add_first_and_last($output) {
  $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
  $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'minimaliste_add_first_and_last');
if ( ! function_exists( 'minimaliste_pagination' ) ) :
	function minimaliste_pagination() {
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
	}
endif;
function minimaliste_custom_meta () {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'minimaliste_meta',
			'Feature Post in the Slider',
			'minimaliste_meta_callback',
			$screen, 'side', 'high'
		);
	}
}
add_action( 'add_meta_boxes', 'minimaliste_custom_meta' );
function minimaliste_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'minimaliste_nonce' );
    $minimaliste_stored_meta = get_post_meta( $post->ID );
    ?>
  <p> <span class="minimaliste-row-title"> Check the box to feature post in the slider </span>
  <div class="minimaliste-row-content">
    <label for="_minimaliste-slider-checkbox">
      <input type="checkbox" name="_minimaliste-slider-checkbox" id="_minimaliste-slider-checkbox" value="yes" <?php if ( isset ( $minimaliste_stored_meta['_minimaliste-slider-checkbox'] ) ) checked( $minimaliste_stored_meta['_minimaliste-slider-checkbox'][0], 'yes' ); ?> />
    </label>
  </div>
  </p>
  <?php
}
function minimaliste_meta_save( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'minimaliste_nonce' ] ) && wp_verify_nonce( $_POST[ 'minimaliste_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    if( isset( $_POST[ '_minimaliste-slider-checkbox' ] ) ) {
    update_post_meta( $post_id, '_minimaliste-slider-checkbox', 'yes' );
} else {
    delete_post_meta( $post_id, '_minimaliste-slider-checkbox', '' );
}
}
add_action( 'save_post', 'minimaliste_meta_save' );
function minimaliste_get_images($post_id) {
    global $post;
 
     $thumbnail_ID = get_post_thumbnail_id();
 
     $images = get_children( array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
 
     if ($images) :
 
         foreach ($images as $attachment_id => $image) :
 
         if ( $image->ID ) :
 
             $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true); //alt
             if ($img_alt == '') : $img_alt = $image->post_title; endif;
 
             $big_array = image_downsize( $image->ID, 'slidethumb' );
             $img_url = $big_array[0];
 
             echo '<li>';
             echo '<img src="';
             echo $img_url;
             echo '" alt="';
             echo $img_alt;
             echo '" />';
             echo '</li>';
 
     endif; endforeach; endif; }
require get_template_directory() . '/customizer.php';


