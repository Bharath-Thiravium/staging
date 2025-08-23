<?php
define( 'WP_CACHE', true );


 // Added by WP Rocket


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u494785662_BtwRq' );

/** Database username */
define( 'DB_USER', 'u494785662_MRfr3' );

/** Database password */
define( 'DB_PASSWORD', 'UNERdxWq5R' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'MxRqlz754XQHY)%kaD4$58gT] czZ^eBF|myqB]12h=M_#BJmxJt(XOFtV]Avrs(' );
define( 'SECURE_AUTH_KEY',   ',6aE2dl(!0!f+=2f6(&DVZ|>l4>Pn&kIdoR}QFRIIk1Jd{ZAhHhKl>e)bk~%kLy1' );
define( 'LOGGED_IN_KEY',     'grV8mYH/zQ&|`x@@X;A^H2n(w9b=(/fitbVK9&/q/7 g<60C1EBzxb _Fua*?5jL' );
define( 'NONCE_KEY',         'ZWtv]azrQg}3*eQT{XXg?S/p[6/-<rm.tNyE;)/>n,&#gwld]-eM^JqQ(`S[2xab' );
define( 'AUTH_SALT',         'D1d:M0`?ruf:;?~sW9XyRc_OU%!VaeEj,GiG(X0IWTfv.<&Sey yrS&on7pRt7#{' );
define( 'SECURE_AUTH_SALT',  'CZL6DDNCq8yR-wc^RL!jS(VQ|3.e87PrD8SW$&D~|K]2HGA|OWimu &0[q3yM7v=' );
define( 'LOGGED_IN_SALT',    'UKj`z/B:|={m>_Wi_^G:2;TuWQ7|X`)vt%uOJI)*Fh1#ofGLGSYWw3q;I6%RT2)L' );
define( 'NONCE_SALT',        '@M+8bI?3{pIY2oxmDr><qzgZcgJrkm#8%#az$<=V5Xq,Sy<}_VAnTyuY~vj#7UtE' );
define( 'WP_CACHE_KEY_SALT', 'u9-J[Nmh!evYZ@ZmN#T_D}mnkqi~^$K*r}X:)U}E1)l6P{D4JJg5--<~[lY=fHTq' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
