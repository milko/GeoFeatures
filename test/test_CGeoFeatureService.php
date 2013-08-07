<?php

/**
 * {@link CGeoFeatureService.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CGeoFeatureService class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/07/2013
 */

/*=======================================================================================
 *																						*
 *								test_CGeoFeatureService.php								*
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
// Test polygon.
//
$poly = '12.18814136408749,42.16922854769521;12.1780986639399,42.15980639083888;12.16520915191844,42.14539192048365;12.15999119503149,42.12728461782839;12.16243949921718,42.11502184616261;12.16862557644289,42.0997201503404;12.18466629967448,42.087875210761;12.20033904228633,42.07588119326365;12.21228118795865,42.07192080877221;12.24051602624714,42.06934932250406;12.26925351870727,42.07445828676936;12.28837208129978,42.08627253828246;12.29624011365534,42.09845021170261;12.30061495154963,42.11135640030903;12.30493262535236,42.12385526916884;12.30382005883976,42.14366108406921;12.29398176417432,42.15814108138106;12.27825742861666,42.16832005373425;12.24676819421733,42.17737035268902;12.21280221307993,42.17708356208818;12.18814136408749,42.16922854769521:12.25899737514696,42.15239960321546;12.25967266329218,42.1555214869443;12.25929411218912,42.1594219376441;12.25435821661503,42.16078021519105;12.25194135894104,42.15805579821561;12.24882626292854,42.15506674192704;12.23148250771473,42.15807771921787;12.21418796327089,42.15553426771232;12.20058993736331,42.15220490150215;12.19124792011669,42.14552382140648;12.18659881432416,42.13876202614075;12.1762656003023,42.12923882791883;12.1779410233036,42.12225885967813;12.17546851778841,42.11474845466174;12.1899995491099,42.10668670308421;12.18904636249434,42.10269504145102;12.21007712671289,42.09015467887552;12.2269232350827,42.0830562153721;12.24262504169375,42.0816503602146;12.24874568009939,42.08961162861392;12.26412981861359,42.09127464264013;12.2673577795436,42.09308887014733;12.2730269479264,42.09352307263171;12.27761967681911,42.09532566221606;12.27919668480095,42.10034877314572;12.27807128651477,42.10694484774903;12.28468910266525,42.12503948727093;12.28516009763436,42.1352833119735;12.27942033624204,42.14128461881369;12.25899737514696,42.15239960321546';


//
// Test class.
//
try
{
	//
	// Test PING.
	//
	echo( '<h4>Test PING</h4>' );
	$op = kAPI_OP_PING;
	$geo = kAPI_GEOMETRY_RECT.'=-16.6463,28.2768;-16.6380,28.2685';
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test HELP.
	//
/*
	echo( '<h4>Test HELP</h4>' );
	$op = kAPI_OP_HELP;
	$request = "$url?$op";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );
*/
	
	//
	// Test unsupported operation.
	//
	echo( '<h4>Test unsupported operation</h4>' );
	$op = 'unsupported';
	$geo = kAPI_GEOMETRY_TILE.'=33065587,774896741';
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test TILE.
	//
	echo( '<h4>Test TILE</h4>' );
	$op = kAPI_OP_TILE;
	$geo = kAPI_GEOMETRY_TILE.'=33065587,774896741';
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test TILE (with selection).
	//
	echo( '<h4>Test TILE (with selection)</h4>' );
	$op = kAPI_OP_TILE;
	$geo = kAPI_GEOMETRY_TILE.'=33065587,774896741';
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$selection = kAPI_ENV_SELECTION.'=elev,1;clim.2000.prec,1';
	$request = "$url?$op&$mod&$geo&$selection";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test RANGE TILE.
	//
	echo( '<h4>Test RANGE TILE</h4>' );
	$op = kAPI_OP_TILE;
	$geo = kAPI_GEOMETRY_TILE.'=33065587,774896741';
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
	// Test COUNT TILE.
	//
	echo( '<h4>Test COUNT TILE</h4>' );
	$op = kAPI_OP_TILE;
	$geo = kAPI_GEOMETRY_TILE.'=33065587,774896741';
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
	// Test CONTAINS point.
	//
	echo( '<h4>Test CONTAINS point</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test CONTAINS rect.
	//
	echo( '<h4>Test CONTAINS rect</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -16.6463,28.2768 ) )
		.';'
		.implode( ',', array( -16.6380,28.2685 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
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
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
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
	// Test CONTAINS polygon.
	//
	echo( '<h4>Test CONTAINS polygon</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_POLY."=$poly";
	$geo = kAPI_GEOMETRY_POLY.'='
		.implode( ',', array( 12.8199,42.8422 ) )
		.';'
		.implode( ',', array( 12.8207,42.8158 ) )
		.';'
		.implode( ',', array( 12.8699,42.8166 ) )
		.';'
		.implode( ',', array( 12.8678,42.8398 ) )
		.';'
		.implode( ',', array( 12.8199,42.8422 ) )
		.':'
		.implode( ',', array( 12.8344,42.8347 ) )
		.';'
		.implode( ',', array( 12.8348,42.8225 ) )
		.';'
		.implode( ',', array( 12.8570,42.8223 ) )
		.';'
		.implode( ',', array( 12.8566,42.8332 ) )
		.';'
		.implode( ',', array( 12.8344,42.8347 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$selection = kAPI_ENV_SELECTION.'=elev,1';
	$request = "$url?$op&$mod&$geo&$selection";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test CONTAINS (count).
	//
	echo( '<h4>Test CONTAINS (count)</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
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
	// Test CONTAINS (default limits).
	//
	echo( '<h4>Test CONTAINS (default limits)</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response, TRUE );</h5>' );
	$response = json_decode( $response, TRUE );
	echo( 'Response<pre>' ); print_r( $response[ 'status' ] ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test CONTAINS (enforced limits).
	//
	echo( '<h4>Test CONTAINS (enforced limits)</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$limit = kAPI_PAGE_LIMIT.'=200000';
	$request = "$url?$op&$mod&$geo&$limit";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response, TRUE );</h5>' );
	$response = json_decode( $response, TRUE );
	echo( 'Response<pre>' ); print_r( $response[ 'status' ] ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test CONTAINS (provided limits).
	//
	echo( '<h4>Test CONTAINS (provided limits)</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$start = kAPI_PAGE_START.'=230';
	$limit = kAPI_PAGE_LIMIT.'=5';
	$request = "$url?$op&$mod&$geo&$start&$limit";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response, TRUE );
	echo( 'Response<pre>' ); print_r( $response[ 'status' ] ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test CONTAINS (elevation range).
	//
	echo( '<h4>Test CONTAINS (elevation range)</h4>' );
	$op = kAPI_OP_CONTAINS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$elevation = kAPI_ENV_ELEVATION.'=1000,1050';
	$selection = kAPI_ENV_SELECTION.'=elev,1';
	$request = "$url?$op&$mod&$geo&$elevation&$selection";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Test NEAR.
	//
	echo( '<h4>Test NEAR</h4>' );
	$op = kAPI_OP_NEAR;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$limit = kAPI_PAGE_LIMIT.'=5';
	$request = "$url?$op&$mod&$geo&$limit";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test NEAR (max distance).
	//
	echo( '<h4>Test NEAR (max distance)</h4>' );
	$op = kAPI_OP_NEAR;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$distance = kAPI_GEOMETRY_DISTANCE.'=2000';
	$limit = kAPI_PAGE_LIMIT.'=5';
	$request = "$url?$op&$mod&$geo&$distance&$limit";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test NEAR (elevation range).
	//
	echo( '<h4>Test NEAR (elevation range)</h4>' );
	$op = kAPI_OP_NEAR;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$distance = kAPI_GEOMETRY_DISTANCE.'=2000';
	$elevation = kAPI_ENV_ELEVATION.'=3300,4000';
	$request = "$url?$op&$mod&$geo&$distance&$elevation";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test RANGE NEAR (elevation range).
	//
	echo( '<h4>Test RANGE NEAR (elevation range)</h4>' );
	$op = kAPI_OP_NEAR;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION, kAPI_OP_RANGE ) );
	$distance = kAPI_GEOMETRY_DISTANCE.'=4000';
	$elevation = kAPI_ENV_ELEVATION.'=2000,4000';
	$request = "$url?$op&$mod&$geo&$distance&$elevation";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test INTERSECTS point.
	//
	echo( '<h4>Test INTERSECTS point</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_POINT.'='.implode( ',', array( -16.6463, 28.2768 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test INTERSECTS rect.
	//
	echo( '<h4>Test INTERSECTS rect</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -16.6463,28.2768 ) )
		.';'
		.implode( ',', array( -16.6380,28.2685 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test AGGREGATE INTERSECTS rect.
	//
	echo( '<h4>Test AGGREGATE INTERSECTS rect</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
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
	// Test INTERSECTS polygon.
	//
	echo( '<h4>Test INTERSECTS polygon</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_POLY.'='
		.implode( ',', array( 9.5387,46.2416 ) )
		.';'
		.implode( ',', array( 9.5448,46.2369 ) )
		.';'
		.implode( ',', array( 9.5536,46.2381 ) )
		.';'
		.implode( ',', array( 9.5571,46.2419 ) )
		.';'
		.implode( ',', array( 9.5507,46.2462 ) )
		.';'
		.implode( ',', array( 9.5439,46.2468 ) )
		.';'
		.implode( ',', array( 9.5387,46.2416 ) )
		.':'
		.implode( ',', array( 9.5445,46.2422 ) )
		.';'
		.implode( ',', array( 9.5481,46.2399 ) )
		.';'
		.implode( ',', array( 9.5517,46.2420 ) )
		.';'
		.implode( ',', array( 9.5463,46.2443 ) )
		.';'
		.implode( ',', array( 9.5445,46.2422 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$request = "$url?$op&$mod&$geo";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test INTERSECTS (count).
	//
	echo( '<h4>Test INTERSECTS (count)</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
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
	// Test INTERSECTS (elevation range).
	//
	echo( '<h4>Test INTERSECTS (elevation range)</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION ) );
	$elevation = kAPI_ENV_ELEVATION.'=1000,1050';
	$request = "$url?$op&$mod&$geo&$elevation";
	echo( "Request: <code>$request</code><br />" );
	echo( '<h5>$response = file_get_contents( $request );</h5>' );
	$response = file_get_contents( $request );
	echo( '<h5>$response = json_decode( $response );</h5>' );
	$response = json_decode( $response );
	echo( 'Response<pre>' ); print_r( $response ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test AGGREGATE INTERSECTS (elevation range).
	//
	echo( '<h4>Test AGGREGATE INTERSECTS (elevation range)</h4>' );
	$op = kAPI_OP_INTERSECTS;
	$geo = kAPI_GEOMETRY_RECT.'='
		.implode( ',', array( -10,30 ) )
		.';'
		.implode( ',', array( -11,29 ) );
	$mod = implode( '&', array( kAPI_OP_REQUEST, kAPI_OP_CONNECTION, kAPI_OP_RANGE ) );
	$elevation = kAPI_ENV_ELEVATION.'=1000,1050';
	$request = "$url?$op&$mod&$geo&$elevation";
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
