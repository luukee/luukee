<?php
/**
 * luukee functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package luukee
 */

if (! function_exists('luukee_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function luukee_setup()
    {


        /**
         * Register custom fonts.
         */
        function luukee_fonts_url()
        {
            $fonts_url = '';

            /*
        	 * Translators: If there are characters in your language that are not
        	 * supported by M, translate this to 'off'. Do not translate
        	 * into your own language.
        	 */
            $montserrat = _x('on', 'Montserrat font: on or off', 'luukee');

            $font_families = array();

            if ('off' !== $montserrat) {
                $font_families[] = 'Montserrat:,400,700';

                $query_args = array(
                    'family' => urlencode(implode('|', $font_families)),
                    'subset' => urlencode('latin,latin-ext'),
                );

                $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
            }

            return esc_url_raw($fonts_url);
        }

        /**
         * Add preconnect for Google Fonts.
         *
         * @since Twenty Seventeen 1.0
         *
         * @param array  $urls           URLs to print for resource hints.
         * @param string $relation_type  The relation type the URLs are printed.
         * @return array $urls           URLs to print for resource hints.
         */
        function luukee_resource_hints($urls, $relation_type)
        {
            if (wp_style_is('luukee-fonts', 'queue') && 'preconnect' === $relation_type) {
                $urls[] = array(
                    'href' => 'https://fonts.gstatic.com',
                    'crossorigin',
                );
            }

            return $urls;
        }
        add_filter('wp_resource_hints', 'luukee_resource_hints', 10, 2);

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on luukee, use a find and replace
         * to change 'luukee' to the name of your theme in all the template files.
         */
        load_theme_textdomain('luukee', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'luukee'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('luukee_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'luukee_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function luukee_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('luukee_content_width', 640);
}
add_action('after_setup_theme', 'luukee_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function luukee_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'luukee'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'luukee'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'luukee_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function luukee_scripts()
{
    wp_enqueue_script('luukee-fonts', luukee_fonts_url());
    /* Register Styles */
    wp_register_style('luukee-styles', get_template_directory_uri() . '/sass/style.css'); //My Custom Styles

    /* Enqueue Styles */
    wp_enqueue_style('luukee-styles');


    wp_enqueue_script('luukee-navigation', get_template_directory_uri() . '/js/custom-nav.js', array(), '20151215', true);

    wp_enqueue_script('luukee-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'luukee_scripts');

if (!is_admin()) {
    add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
}
function my_jquery_enqueue()
{
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom post types.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}


// Show posts of 'post', 'page' and 'movie' post types on home page
function add_my_post_types_to_query($query)
{
    if (is_home() && $query->is_main_query()) {
        $query->set('post_type', array( 'product' ));
    }
    return $query;
}
add_action('pre_get_posts', 'add_my_post_types_to_query');
