<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u407937142_k0dgk' );

/** Database username */
define( 'DB_USER', 'u407937142_1qckT' );

/** Database password */
define( 'DB_PASSWORD', 'YM04Wc1Mkr' );

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
define( 'AUTH_KEY',          'A/Y^^7]Qi1&DuwggTRc_^xY?d!jr*WnX*o{/Uv}_lj0dM/8]Sa%(9:T$Qv{oTNBU' );
define( 'SECURE_AUTH_KEY',   '_vcMR$v/|XB~M+u:hc1lGqi)x?&sRTOP{CjsY+Zo/:[xGQ&$1J-LF.8`z6ch^5k ' );
define( 'LOGGED_IN_KEY',     'Ih_1f-U|KKb1RI(SmS.H81KngGNq@:(7Ao!~8D&EN.voOZ<Gq%e?w![Y t(@f+j)' );
define( 'NONCE_KEY',         'q^KH$7c2JUyjNQoi0|T`TV<PC[I:Sn3NG[G0{tr4,49;9+P,O?OFlB{$*7r@K~t*' );
define( 'AUTH_SALT',         'jc3^l!2ccsR5w3u|zg`oQ}ryB+#a3{c|Kn8Vb;<4XHwofifV}9H!x>em`geZ]we&' );
define( 'SECURE_AUTH_SALT',  'M!u-]GfReSz3%`a+/CfBwfv3m |b@794!B.TjH7`I_l#Zp7ikM^=C/vsJ_YKcxqY' );
define( 'LOGGED_IN_SALT',    ']vRKJ[dEG_*w_os3T3%&/KBxwa1xGC}lKYq0,,RD`}`Ao!h#UOpe~Z=Pw.Zhjk8z' );
define( 'NONCE_SALT',        'd*nOo(ygR1nAV!|0ZVF@E(H]teMciWYP#1Yjfv:%7&wlfcn}kg [Uc(*Gu13+{|w' );
define( 'WP_CACHE_KEY_SALT', 'u`{|[[jcmeB9Ob9&n{]!L;^fctF$6Hm5I]%*1@!$PQ1$iTdfU;)#Elsqxwyx{yNE' );


/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
