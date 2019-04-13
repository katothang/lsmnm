<?php
/**
 * aloshop functions and definitions
 *
 * @version 1.0
 *
 * @date 12.08.2015
 */

load_theme_textdomain( 'aloshop', get_template_directory() . '/languages' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

require_once( trailingslashit( get_template_directory() ). '/7upframe/index.php' );