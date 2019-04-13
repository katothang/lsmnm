<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'shop' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`[wyNXEJZ1VwLpP0W5jnC ZoI34Bz{Q76$FGmc@>rXt5fw@LoA20Jk3`Urhjr-vZ' );
define( 'SECURE_AUTH_KEY',  '0<ym9]oqe(Z<ki{;4;OPN)P+fF`P|eC1C:<atF=c8?+mwUob/GQ=To?VwH8hD-A&' );
define( 'LOGGED_IN_KEY',    'XiUQ#XYX{9Wysve*tP{*03%|HO>@XXEd-`TkCO{f5f^K/w#NJPV+C1~R*mUE5=D+' );
define( 'NONCE_KEY',        'saRx5@12).hfpLZf7|]Wk:tRbTaAp0:-5)R/m92c1v{L|0]uplM#E4kP$o~$W/d`' );
define( 'AUTH_SALT',        '5Y&JV*S/15g@mEIpx+4*=*oH^*k}Z&>~W?@45Vq(]e*D}cm,(3rRW:xuh~S-*QG4' );
define( 'SECURE_AUTH_SALT', '/UnW`qz4/ushRSg&ep<:}CcSS9,)fRndy}*y.}9S)X{8->tazda)|Sg,8#Dm6i3k' );
define( 'LOGGED_IN_SALT',   '-j#Tz=91.bixa5]TVC[(={QlR~;+eKfMoo8~*Jx5.[~$gYs(RE9i#9G6/DcuE/w-' );
define( 'NONCE_SALT',       'C[JDU]HL-KF *W&kzIE2|F Kun-*_^06,vw1JWrJ?1s9vFdoYICHUeHH@y}H~`c$' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
