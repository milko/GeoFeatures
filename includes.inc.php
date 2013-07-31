<?php

/*=======================================================================================
 *																						*
 *									includes.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Global include file.
 *
 *	This file should be included at the top level of the application or web site as the
 *	first entry, it includes the file paths to the relevant directories and the autoload
 *	function for this library.
 *
 *	@package	GEO
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Skofic <m.skofic@cgiar.org>
 *	@version	1.00 31/07/2013
 */

/*=======================================================================================
 *	NAMESPACE ROOT																		*
 *======================================================================================*/

/**
 * MyWrapper namespace root.
 *
 * This string indicates the root namespace name for this library.
 */
define( "kPATH_MYWRAPPER_NAMESPACE_ROOT",	"GeoFeatures" );

/*=======================================================================================
 *	LIBRARY PATHS																		*
 *======================================================================================*/

/**
 * Class library root.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library root
 * directory.
 */
define( "kPATH_GEOFEATURES_LIBRARY_ROOT",	"/Library/WebServer/Library/GeoFeatures" );

/*=======================================================================================
 *	LIBRARY SUB-PATHS																		*
 *======================================================================================*/

/**
 * GeoFeatures class library definitions.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library
 * definitions directory.
 */
define( "kPATH_GEOFEATURES_LIBRARY_DEFINE",		kPATH_MYWRAPPER_LIBRARY_ROOT."/defines" );

/**
 * GeoFeatures class library sources.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library sources
 * directory.
 */
define( "kPATH_GEOFEATURES_LIBRARY_CLASS",		kPATH_MYWRAPPER_LIBRARY_ROOT."/classes" );

/**
 * GeoFeatures batch scripts and files.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper library data
 * directory.
 */
define( "kPATH_GEOFEATURES_LIBRARY_BATCH",		kPATH_MYWRAPPER_LIBRARY_ROOT."/batch" );

/**
 * GeoFeatures service scripts and files.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper library service
 * directory.
 */
define( "kPATH_GEOFEATURES_LIBRARY_SERVICE",	kPATH_MYWRAPPER_LIBRARY_ROOT."/service" );

/*=======================================================================================
 *	CLASS AUTOLOADER																	*
 *======================================================================================*/

/**
 * This section allows automatic inclusion of the library classes.
 */
function MyAutoload( $theClassName )
{
	//
	// Separate namespace elements.
	//
	$namespaces = explode( '\\', $theClassName );
	
	//
	// Handle our classes.
	//
	if( (count( $namespaces ) > 1)								// Declared a namespace
	 && ($namespaces[ 0 ] == kPATH_MYWRAPPER_NAMESPACE_ROOT) )	// and corresponds.
	{
		//
		// Replace root namespace with class directory.
		//
		$namespaces[ 0 ] = kPATH_MYWRAPPER_LIBRARY_CLASS;
		
		//
		// Create path.
		//
		$path = implode( DIRECTORY_SEPARATOR, $namespaces ).'.php';
	
	} // This librarie's namespace.
	
	//
	// Handle without namespaces.
	//
	else
		$path = kPATH_MYWRAPPER_LIBRARY_CLASS."/$theClassName.php";
		
	//
	// Require class.
	//
	if( file_exists( $path ) )
		require_once( $path );

} spl_autoload_register( kPATH_MYWRAPPER_NAMESPACE_ROOT.'Autoload' );

?>
