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
define('DB_NAME', 'sshkd');

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
define('AUTH_KEY',         '#SqB:BWLt.*m%k3PRTXUh]K^Bg:b1{6T!4{o8FE(5mV4]c@y{f)r9@1}S8+O1{.2');
define('SECURE_AUTH_KEY',  '?_@s>iTS.XTd,B[1~;eR]%}!2$ytozEFPGaYmB2DY@HWm*4#T#OCA1k/-gcq&y:x');
define('LOGGED_IN_KEY',    '86J%=WHJlV4yqpo..%>jY{)Oizp34Nvs7R%CzOx?|P4<hg_/:#EbL$:p)lz<q}U8');
define('NONCE_KEY',        'vYMbp{>Tl)T8)aNE%p.mL>XhVt=H`};D?g$+P!e}s#E!,#va4j!1odJ<088QHWX,');
define('AUTH_SALT',        '_QI=w-,Q-4<WClt_];%``!_Yw.T%k|+hQ`UGTuza,U3+imD:YsOKO$-^=?jEz<h$');
define('SECURE_AUTH_SALT', 'A!{_7sil0D~$Z6N9*qfB]yUvqL;[crl.g7_FWmoN,YF*Uu[t.a-z$B_,s+3PbP=^');
define('LOGGED_IN_SALT',   '_u?!aLz! d1#?M!@p-7y61:yibnc!7r>Zs<ZdFEi~;zkvXE.+v8 keVKO|`# PfM');
define('NONCE_SALT',       '2cgQ>H0:CS$!73(pn4uPVKAu`6?nXR4,%=kivjaozFR-IpNs<*7357#,TRDMA>*!');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
