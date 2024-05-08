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
	OPTIONS
--------------------------------------------------*/
function pbr($e){echo '<br><pre>';print_r($e);echo '</pre><br>';}

if ( function_exists('acf_add_options_page') ) {
 acf_add_options_page([
   'page_title' 	=> 'Bagno Showroom',
   'menu_title'	=> 'Bagno Showroom',
   'menu_slug' 	=> 'bsr-options',
   'capability'	=> 'edit_posts',
   'redirect'		=> true
 ]);
}


// acf_add_options_sub_page(array(
//   'page_title' 	=> 'Bagno Showroom',
//   'menu_title'	=> 'Aspetto',
//   'parent_slug'	=> 'bsr-options',
// ));
/*--------------------------------------------------
	SUPPORTO DEL RIASSUNTO NELLE PAGINE - WP Backend
--------------------------------------------------*/
add_post_type_support( 'page', 'excerpt' );

/*--------------------------------------------
		GALLERY - IMAGES
--------------------------------------------*/
function get_gallery_page_by_acf_field($slug, $page) {

	$gallery = get_field($slug, $page);

	$url_image = [];

	foreach ($gallery as $key => $image) {
		$url_image[$image['ID']] = [
			'original' 	=> $image['link'],
			'thumbnail' => $image['sizes']['thumbnail'],
			'medium' 		=> $image['sizes']['medium'],
			'large' 		=> $image['sizes']['large'],
		];
	}

	return $url_image;

}

/*--------------------------------------------
		IMAGES MENU - THUMBNAIL
--------------------------------------------*/
function get_images_menu() {

	$page = [];
	$menu_items = wp_get_nav_menu_items('menu-1');

	foreach ($menu_items as $key => $item) {
		if ($item->object != 'custom') {
			$page[] = $item;
		}
	}

	foreach ($page as $item ) :
		$post = get_post($item->object_id);
		// the_field('image_menu', $id);
		// post_excerpt, post_content
	?>
		<div class="wrap_attachment_menu" data-id="menu-item-<?php echo $item->ID ?>">
			<div class="wrap_image">
				<img src="<?php echo get_the_post_thumbnail_url($post->ID, 'large') ?>" >
			</div>

			<div class="wrap_titles">
	     <h3 class="the_sub_title title_1_2"><?php echo $post->post_title; ?></h3>
			 <div class="description"><?php echo ($post->post_excerpt) ? $post->post_excerpt : $post->post_content; ?></div>
	    </div>
		</div>

	<?php endforeach; ?>

		<div class="wrap_layer_withe"></div>

<?php

}

/*--------------------------------------------
	Excerpt or Content post
----------------------------------------------*/

function get_excerpt_or_content($post, $trunc = 100) {
	if ($post->post_excerpt) {
		return $post->post_excerpt;
	} else {
		return substr($post->post_content, 0, $trunc);
	}
}

/*--------------------------------------------

	Excerpt or Content post

----------------------------------------------*/
require ASSETS_DIR . '/php/ajax.php';
