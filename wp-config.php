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
define('DB_NAME', 'switchedoncoaching.com');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '1D?:rY<&m+d4j5t8K`E&3EOJ5AmJmtp.#!2NXJ]?,G9:9{&]`,y-/li|gU74.D^>');
define('SECURE_AUTH_KEY',  'n(UP6>Z,*ix2EQ{oV|]pV&)EC:J:T)eHJSXpgM_#0|N`DUF}Ao[b[$_ONF`K8T2T');
define('LOGGED_IN_KEY',    'M/yU=R< ga<.N}q:f5^!KD)92=y.1HUcq~2~h5XW3x4g6%[pYdf%-=F>KJ/M75|W');
define('NONCE_KEY',        ')Ep}puf|#._z7zAv=p/%vibk=5SD<4T9 IBtE`]una$@|d,(5+?)j---*;.ZK6+z');
define('AUTH_SALT',        'U[s3!`_i-7|9ccd-6d-zgm7Nn>?+UFvY(qUu2Y0MT_b-Pe_6E-BKALx}hgo[zAnA');
define('SECURE_AUTH_SALT', '/$F{Iusyj?Lg$?0<9hff>l2*rI:n}g3 DxyLdue8|-vTA7}o6UUU8)ZE-#3Zy(j ');
define('LOGGED_IN_SALT',   'DyvYfC-y^Tj,e&? do@5s3+uk%}h-skeVd%sG/))oPK;>3*d (akH6-<g93JPh(R');
define('NONCE_SALT',       'B,?9x1xf(wbM =Ci9PV(hzqu~rTP)S4Y1DQ#s<#v+9iKkyzZ;3}C++b$JJ]G:+}u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'nd_';

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
