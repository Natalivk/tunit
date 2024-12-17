<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'unit' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '@5ljW#K!.QXK[Qo-!rt7R_*||QS5>Np-}+&0q=oiNgl56$aIw4{f$Pc?N8{Wm_N3' );
define( 'SECURE_AUTH_KEY',  'ETv-hbMt5-37I4[nimz;f%0!}LiQ*@ptFY5v)y~FyG.B@ZzKi9/VC,-Tu3Kz7.Id' );
define( 'LOGGED_IN_KEY',    't7;Dz5Ua.T8uD1s{yD9])YDzd$2>^X..8f_@kAD_RR/^)]DX&Nb%o(I|z|g z]wG' );
define( 'NONCE_KEY',        'MO@B/:y;E!#ew8ynXVJaV>UFN^J7Ho9dFW (burT:]sf@vgv~gp5( 0Lf,o0dJtG' );
define( 'AUTH_SALT',        '2pWE5NoNXn/=*3vBU3dd8vM8YuIfnOd_3Z_ZW{x3UuWs#it4NMMm&(kN/[59a]/S' );
define( 'SECURE_AUTH_SALT', '2D^(N>W`(-=[Qz(U.1eBhZ{1[Q?>#f&Fq25*X`(>a}fau;1VVB,>54B*#3RznC1&' );
define( 'LOGGED_IN_SALT',   '?01yF!xGLEa*AN2Wt$}7nkx3LGM<Q,}pQ^X!H()@!`tN@n!CjrQGeWJkj(WZ,G!b' );
define( 'NONCE_SALT',       'FzXT5H4si)5oS,X/^x+NHd#y`o#}EU~|)eMd|#X>zg,617BLe*@3}s8z[{}yg`HB' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
