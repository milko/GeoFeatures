<?php

/**
 * GeoFeatures limits test suite.
 *
 * This file contains routines to test the limits of the service request.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 05/08/2013
 */

/*=======================================================================================
 *																						*
 *							test_CGeoFeatureService.limits.php							*
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
 * Class definitions.
 *
 * This include file contains the class definitions.
 */
require_once( kPATH_GEOFEATURES_LIBRARY_CLASS."/CGeoFeatureService.php" );


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Test service URL.
//
$url = "http://localhost/lib/GeoFeatures/service/GeoFeatures.php";
 
//
// Test rect.
//
$geo = kAPI_GEOMETRY_RECT.'='
	.implode( ',', array( 5,25 ) )
	.';'
	.implode( ',', array( 8,28 ) );

//
// Test class.
//
try
{
	//
	// Test COUNT CONTAINS rect.
	//
	echo( '<h4>Test COUNT CONTAINS rect</h4>' );
	$op = kAPI_OP_CONTAINS;
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION, kAPI_OP_COUNT ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test RANGE CONTAINS rect.
	//
	echo( '<h4>Test RANGE CONTAINS rect</h4>' );
	$op = kAPI_OP_CONTAINS;
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION, kAPI_OP_RANGE ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test RANGE NEAR (max distance).
	//
	echo( '<h4>Test RANGE NEAR (max distance)</h4>' );
	$op = kAPI_OP_NEAR;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION, kAPI_OP_RANGE ) );
	$distance = kAPI_GEOMETRY_DISTANCE.'=2000000';
	$request = "$url?$op&$mod&$geo&$distance";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( \Exception $error )
{
	echo( '<h3><font color="red">Unexpected exception</font></h3>' );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
