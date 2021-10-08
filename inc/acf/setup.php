<?php 

/**
 * Saving, Loading, Synchronization of ACF field groups
 */

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
  // update path
  $path = get_stylesheet_directory() . '/inc/acf/json';
  // return
  return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
  // remove original path (optional)
  unset($paths[0]);
  // append path
  $paths[] = get_stylesheet_directory() . '/inc/acf/json';
  // return
  return $paths;
}


/**
 * Sets up the ACF Blocks
 */

add_action( 'acf/init', 'mas_acf_init' );

function mas_acf_init() {
    // Bail out if function doesn’t exist.
    if ( ! function_exists( 'acf_register_block' ) ) {
        return;
    }

		include get_template_directory() . '/inc/blocks/article.php';
		include get_template_directory() . '/inc/blocks/featured.php';
		include get_template_directory() . '/inc/blocks/hero.php';
		include get_template_directory() . '/inc/blocks/teaser.php';
    include get_template_directory() . '/inc/blocks/showcase.php';
}


function mas_allowed_block_types( $allowed_blocks ) {
	return array(
		//'core/image',
    'acf/article',
    'acf/featured',
		'acf/hero',
		'acf/teaser',
    'acf/showcase',
    'core/block',
    //'acf/relateditems',
	);
}
add_filter( 'allowed_block_types_all', 'mas_allowed_block_types' );

?>