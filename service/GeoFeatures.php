<?php
	
/**
 * Geographic layers service.
 *
 * This file contains the scripts to handle the geographic layers service.
 *
 *	@package	GEO
 *	@subpackage	Service
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 21/07/2013
 */

/*=======================================================================================
 *																						*
 *									GeoFeatures.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains all local definitions.
 */
require_once( "local.inc.php" );

/**
 * Global definitions.
 *
 * This include file contains all global definitions.
 */
require_once( kPATH_GEOFEATURES_LIBRARY_ROOT."/includes.inc.php" );

/**
 * Service class definitions.
 *
 * This include file contains the service class definitions.
 */
require_once( kPATH_GEOFEATURES_LIBRARY_CLASS."/CGeoFeatureService.php" );


/*=======================================================================================
 *	SERVICE WORLDCLIM 30 DATA															*
 *======================================================================================*/

//
// Instantiate service.
//
$wrapper = new CGeoFeatureService( kDEFAULT_SERVER, kDEFAULT_DATABASE, kDEFAULT_COLLECTION );
if( $wrapper->Status() == kAPI_STATE_ERROR )
	exit( json_encode( $wrapper->getArrayCopy() ) );								// ==>

//
// Handle request.
//
$wrapper->HandleRequest();

//
// Handle success.
//
if( $wrapper->Status() == kAPI_STATE_OK )
{
	//
	// Handle help.
	//
	if( $wrapper->Operation() == kAPI_OP_HELP )
		exit( $wrapper->getArrayCopy()[ kAPI_RESPONSE_DATA ] );						// ==>
}

exit( json_encode( $wrapper->getArrayCopy() ) );									// ==>

?>
