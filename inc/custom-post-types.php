<?php
/**
 * Custom post types
 *
 * @link https://codex.wordpress.org/Post_Types#Custom_Post_Types
 *
 * @package luukee
 */

function create_post_type()
{
    register_post_type(
      'acme_product',
    array(
      'labels' => array(
        'name' => __('Products'),
        'singular_name' => __('Product')
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action('init', 'create_post_type');
