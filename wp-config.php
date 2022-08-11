<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'v119576_wp1' );

/** Database username */
define( 'DB_USER', 'v119576_wp1' );

/** Database password */
define( 'DB_PASSWORD', 'ebjfmNabfN7Kz6L@' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'Lx0PQVVg3LqamkGWfIAKJrsNlpaZnKljEnfWWufAbiAbW7HLhAsVEFvJysRXk5zF');
define('SECURE_AUTH_KEY',  'ha0VXOYCehA2ilYHocjk9ajuHxYubr9fnvunNyRSv3D0p4J9yyPfOaXCOsVvRvU8');
define('LOGGED_IN_KEY',    'TBffNUzZ50EXFmlaPhJs9ljaFnjwSmNTwQ6c5i4NgJTXwZqFt62nn7jX5K0a53e9');
define('NONCE_KEY',        'ShY3PVI6zkvutoGevGjy4lfyM0QDBdI8yZnRe6iwqVVMC0Es0iH6Ap9fxLj8XVq6');
define('AUTH_SALT',        'Qa0ddji2KirMIllsUPXMVSLC1jU2adrvtB87tPxhleDxt8ncR0NucgHyNt3ilYEj');
define('SECURE_AUTH_SALT', '8Lba3zIGZLweXXeM22PQGgu1u1YAa7euM3TDKlB7knYvl1Xyrb7mWhIi2idqucw9');
define('LOGGED_IN_SALT',   'CCoA9gwxbRKbhksR0DYWgWOloXgiUG02FEfmc5YLoDlHzfyw7D1iIaI5iMfft96R');
define('NONCE_SALT',       'uJvuZI7P9P9XeVkU4nZ9CUD1NztHjBgjUopTPMK2IYPx5zdfdProEIPmTE4VHUpt');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');


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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';