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
define('DB_NAME', 'amazon');


/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'harekrishnaharekrishna1594');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}EPE 6?dpq<S8~a_|-g]+o~eRt/k+=myJ]uG6YJgZPFR;3ZmsbM[6EMad67nFAxw');
define('SECURE_AUTH_KEY',  's>y~o`|~MyG>C,<=x[t<TA+~=k+kg8%u3z0+cwO/hh^3ZJ-tRL O}~~+@y+9Z2fm');
define('LOGGED_IN_KEY',    '-XGsg6!}.:+QgMXG374A$E~k~&Qub!HY/Jj+b-z<bT&xh|.8C<8mMu|jLy-{(x1h');
define('NONCE_KEY',        't{R1ajMi[tiNkl ;fwDpk}Ep%ZiVC=UJ+dKMuW,zY|-j_7TI!:#7m&j1VgTi<L9u');
define('AUTH_SALT',        '3oI?dSz/-7@=leH=,>VPg)!+D+,woA8O7Q4|Z|xh~bvl5!iN(_6:jR5C)tJV/Qsd');
define('SECURE_AUTH_SALT', 'F+g{Gt5Y`+rQx5wl[r!:G7|Wi@[E=REi@ur+|-qtu1LYx2#PH;J/Bp=`I.p5yFt?');
define('LOGGED_IN_SALT',   '|O?#5?;%a_J3X[SuFBMBnw,-b$T?7BL37W3Qwld;V}j>U`A{rwl|z?P|a`oViUQ:');
define('NONCE_SALT',       'GV)).tp8]|-Ec4/<z%lwkI,K<_%|`6=[BsI{(?:|t^^GI*o^9q>#2O0{nK%crwiy');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wplp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

