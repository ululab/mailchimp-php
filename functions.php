<?php
/*--------------------------------------------------
   DEFINE COSTANT
--------------------------------------------------*/
define('THEME_URI', get_template_directory_uri() );
define('ASSETS_PATH', THEME_URI . '/assets');
define('ASSETS_DIR',  get_template_directory() . '/assets');
define('MEDIA_PATH',  THEME_URI . '/media');


/*--------------------------------------------------
   Nego l'accesso
--------------------------------------------------*/
function deny_access() {
	if ( !defined( 'ABSPATH' ) ) {
		die(); // Exit if accessed directly.
	}
}

/*--------------------------------------------------------
  Nome file nella directory assets con timestamp
	Prevenire il cancellamento della cache
--------------------------------------------------------*/
function _ver($filenamepath) {
	return ASSETS_PATH . $filenamepath . '?v=' . filemtime(ASSETS_DIR . $filenamepath);
}

/*--------------------------------------------------
	Custom file functions template
	Include script, style ecc...
--------------------------------------------------*/
function to_include_custom_scripts() {

	// wp_enqueue_style( 'swiper-style', get_template_directory_uri() . '/assets/lib/swiper/swiper-bundle.min.css?v=6.5.0');
	wp_enqueue_style( 'slick-style', ASSETS_PATH . '/lib/slick/slick.css?v=1.8.1');
	wp_enqueue_style( 'slick-style', ASSETS_PATH . '/lib/slick/slick-theme.css?v=1.8.1');
	// wp_enqueue_style( 'touch-sideswipe-style', ASSETS_PATH . '/lib/touch-sideswipe/touch-sideswipe.min.css');
	wp_enqueue_style( 'app-style',  _ver('/css/app.min.css'));
  wp_enqueue_style( 'app-style-responsive', _ver('/css/app.responsive.css'));
	wp_enqueue_style( 'style-normalize', ASSETS_PATH . '/css/normalize.css?v=1.0.0');
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400;500;600;700&display=swap', false );

	// wp_enqueue_script( 'sideswipe-js', ASSETS_PATH . '/lib/touch-sideswipe/touch-sideswipe.js' , array() , 0, false);
	wp_enqueue_script( 'vue-js', ASSETS_PATH . '/lib/vue/vue.js?v=2.6.12' , array() , 0, false);
	// wp_enqueue_script( 'swiper-js', ASSETS_PATH . '/lib/swiper/swiper-bundle.min.js?v=6.5.0' , array('jquery') , 0, false);
	wp_enqueue_script( 'slick-js', ASSETS_PATH . '/lib/slick/slick.min.js?v=1.8.1' , array('jquery') , 0, false);
  wp_enqueue_script( 'app-js', _ver('/js/app.min.js'), array('jquery') , 0, false);


	wp_localize_script('app-js', 'ajax', array(
		'wp_url' => admin_url('admin-ajax.php'),
    'wp_nonce' => wp_create_nonce(NONCE_KEY),
		) );

}
add_action( 'wp_enqueue_scripts', 'to_include_custom_scripts' );


/*--------------------------------------------------
	CUSTOM POST TYPE AND TAXONOMY
--------------------------------------------------*/
	require ASSETS_DIR . '/php/custom-post-type-taxonomy.php';


/*--------------------------------------------------
	SUPPORTO DEL RIASSUNTO NELLE PAGINE - WP Backend
--------------------------------------------------*/
add_post_type_support( 'page', 'excerpt' );


/*--------------------------------------------
	Excerpt or Content post
----------------------------------------------*/
require ASSETS_DIR . '/php/ajax.php';
