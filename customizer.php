<?php
function minimaliste_customize_register($wp_customize){
	
	$wp_customize->add_section('minimaliste_theme_options', array(
        'title'    => ('Theme Options'),
        'priority' => 125,
    ));
	$wp_customize->add_section('change_theme_colors', array(
        'title'    => ('Change Theme Colors'),
        'priority' => 130,
    ));
	
	$wp_customize->add_section('social_icons', array(
        'title'    => ('Social Media Icons'),
        'priority' => 135,
    ));
	
	
	$wp_customize->add_setting(
    'twitter_account',
    array(
        'default' => '',
		'sanitize_callback' => 'esc_url_raw',
    )
	);

	$wp_customize->add_control(
    'twitter_account',
    	array(
        	'label' => 'Twitter Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);

	$wp_customize->add_setting(
    	'facebook_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'facebook_account',
    	array(
        	'label' => 'Facebook Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'linkedin_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'linkedin_account',
    	array(
        	'label' => 'LinkedIn Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'dribble_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'dribble_account',
    	array(
        	'label' => 'Dribble Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'pinterest_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'pinterest_account',
    	array(
        	'label' => 'pInterest Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'flickr_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'flickr_account',
    	array(
        	'label' => 'Flickr Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'vimeo_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'vimeo_account',
    	array(
        	'label' => 'Vimeo Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'youtube_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'youtube_account',
    	array(
        	'label' => 'YouTube Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'tumblr_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'tumblr_account',
    	array(
        	'label' => 'Tumblr Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'instagram_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'instagram_account',
    	array(
        	'label' => 'Instagram Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);
	
	$wp_customize->add_setting(
    	'googleplus_account',
    	array(
        	'default' => '',
			'sanitize_callback' => 'esc_url_raw',
    	)
	);

	$wp_customize->add_control(
    	'googleplus_account',
    	array(
        	'label' => 'Google Plus Account URL',
        	'section' => 'social_icons',
        	'type' => 'text',
    	)
	);

$wp_customize->add_setting( 'logo_img' );
 
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'logo_img',
        array(
            'label' => 'Upload a Logo image',
            'section' => 'minimaliste_theme_options',
            'settings' => 'logo_img'
        )
    )
);

$wp_customize->add_setting(
    'menu-links',
    array(
        'default' => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'menu-links',
        array(
            'label' => 'Change Menu Links Color',
            'section' => 'change_theme_colors',
            'settings' => 'menu-links',
			'priority'   => 2
        )
    )
);

$wp_customize->add_setting(
    'icons-color',
    array(
        'default' => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'icons-color',
        array(
            'label' => 'Social Icons Color',
            'section' => 'change_theme_colors',
            'settings' => 'icons-color',
			'priority'   => 5
        )
    )
);
$wp_customize->add_setting(
    'text-color',
    array(
        'default' => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'text-color',
        array(
            'label' => 'General Text Color',
            'section' => 'change_theme_colors',
            'settings' => 'text-color',
			'priority'   => 7
        )
    )
);
$wp_customize->add_setting(
    'header-color',
    array(
        'default' => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'header-color',
        array(
            'label' => 'Headers Color',
            'section' => 'change_theme_colors',
            'settings' => 'header-color',
			'priority'   => 8
        )
    )
);
$wp_customize->add_setting(
    'footer-color',
    array(
        'default' => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'footer-color',
        array(
            'label' => 'Footer Text Color',
            'section' => 'change_theme_colors',
            'settings' => 'footer-color',
			'priority'   => 9
        )
    )
);
}
add_action('customize_register', 'minimaliste_customize_register');
function minimaliste_customizer_css() {
    ?>
    <style type="text/css">
.sf-menu a {
color: <?php echo get_theme_mod( 'menu-links', '#404040' );
?>;
}
a.socialicon {
color: <?php echo get_theme_mod( 'icons-color', '#666666' );
?>;
border: solid 1px <?php echo get_theme_mod( 'icons-color', '#666666' );
?>;
}
body {
color: <?php echo get_theme_mod( 'text-color', '#404040' );
?>;
}
h1, h2, h3, h4, h5, h1.entry-title, h2.entry-title, h2.entry-title a {
color: <?php echo get_theme_mod( 'header-color', '#404040' );
?>;
}
#footer, #footer a {
color: <?php echo get_theme_mod( 'footer-color', '#404040' );
?>;
}
</style>
    <?php
}
add_action( 'wp_head', 'minimaliste_customizer_css' );
