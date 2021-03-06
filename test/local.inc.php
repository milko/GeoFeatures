<?php

/*=======================================================================================
 *																						*
 *									local.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	Local include file.
 *
 *	This file sincludes the default values used by the service, it can be customised.
 *
 *	@package	WORLDCLIM30
 *	@subpackage	Defaults
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/07/2013
 */

/*=======================================================================================
 *	LIBRARY PATH																		*
 *======================================================================================*/

/**
 * Class library root.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library root
 * directory.
 */
define( "kPATH_GEOFEATURES_LIBRARY_ROOT",	"/Library/WebServer/Library/GeoFeatures" );

/*=======================================================================================
 *	DEFAULT DEFINITIONS																	*
 *======================================================================================*/

/**
 * Default server DSN.
 *
 * This tag indicates the default MongoDB server connection string.
 */
define( "kDEFAULT_SERVER",					"mongodb://192.168.181.101:27017" );

/**
 * Default database name.
 *
 * This tag indicates the default database name.
 */
define( "kDEFAULT_DATABASE",				"GEO" );

/**
 * Default collection name.
 *
 * This tag indicates the default collection name.
 */
define( "kDEFAULT_COLLECTION",				"LAYERS-30" );

/*=======================================================================================
 *	FILE PATHS																			*
 *======================================================================================*/

/**
 * Data files base path.
 *
 * This represents the base path to all the .bil files; the script expects to find a
 * directory and within it a file names as the file key.
 */
define( "kPATH_FILES", '/Library/WebServer/Data/GeographicFeatures' );

/*=======================================================================================
 *	BUFFER SIZES																		*
 *======================================================================================*/

/**
 * Map resolution.
 *
 * This represents the tiles map resolution in seconds.
 */
define( "kBUF_TILE_REST", 30 );

//
// Origin.
//
define( "kORIGIN_LON", -180 );					// First tile longitude in degrees.
define( "kORIGIN_LAT", 90 );					// First tile latitude in degrees.

//
// Range.
//
define( "kRANGE_LON", 360 );					// Map longitude extent in absolute degrees.
define( "kRANGE_LAT", 150 );					// Map latitude extent in absolute degrees.

/**
 * Read buffer.
 *
 * This represents the number of tiles to be read each time from each file.
 */
define( "kBUF_TILE_COUNT", 21600 );

/**
 * Records buffer.
 *
 * This represents the number of records to buffer.
 */
define( "kBUF_RECORD_COUNT", 4096 );

/*=======================================================================================
 *	ENVIRONMENT																			*
 *======================================================================================*/

/**
 * Trace.
 *
 * Eventual exceptions will include file and trace information.
 */
define( "kENV_TRACE", TRUE );

/**
 * Verbose.
 *
 * Debugging information will be echoed if this flag is set and the script is called via
 * the command line.
 */
define( "kENV_VERBOSE", TRUE );

/*=======================================================================================
 *	DEFAULT LIMITS																		*
 *======================================================================================*/

/**
 * Maximum records.
 *
 * This tag identifies the default maximum records count.
 *
 * Type: integer.
 */
define( "kAPI_DEFAULT_LIMIT", 100 );

?>
