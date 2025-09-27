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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nz_prodsz' );

/** MySQL database username */
define( 'DB_USER', 'nz_prodsz' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Oxvv42@5' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'ugfld8jIy2Ol:pg7bg6~d3/m(75+I2ZIvoz/MjbD78#2t35yGC4P35PX:kxhPUX1');
define('SECURE_AUTH_KEY', '6+J#f2Ipm|!KvLOsa|[-21Y5[9&r0(Xal)A_~zgD2I)75*[Rz!gX;BnBVB57:5eW');
define('LOGGED_IN_KEY', ':seKb0YNMMqhs05jaV:4[4cC;@*V!AG*yh;D1Z1!p&1|3/:U940[2mb93/p70L-O');
define('NONCE_KEY', '#z7Gcj8)752S50IZZq3&vgl_|@Ne2HYzcC[Ykz1w9F/[ONdDV!GFL%7M&3#_/]Mx');
define('AUTH_SALT', '1/k%6*O!m]m++vM!:16+0zDn70B_]MGCc_[47i1XVC059:h04s7w/!H_c43a]mM#');
define('SECURE_AUTH_SALT', '+m1Y2E0Z+_o@m*+fuS+!%;3F3Bn(Tnfu105d9-HcFjPD;y#VD[]+*06du8HPU4Vr');
define('LOGGED_IN_SALT', 'tk*JaaJ#MGEN#005_F(Picefv]2[3ho7t|Y/8!dM945q75%q20bT#N2i4mx6e845');
define('NONCE_SALT', 'EDS-3)Q1N2WafZ1J:DR2J[rS52*;)|80;]v@8kz39f9UUWb[2!1]3N@G4ZSq41EA');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'nz_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */
define( "WP_DEBUG", false );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
