<?php
	
/**
 * Test geographic queries.
 *
 * This file contains a series of geographic queries matched upon WORLDCLIM30 data.
 *
 *	@package	Test
 *	@subpackage	TEST
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 15/07/2013
 */

/*=======================================================================================
 *																						*
 *										test_geo.php									*
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
 * Service definitions.
 *
 * This include file contains the service definitions.
 */
require_once( kPATH_GEOFEATURES_LIBRARY_CLASS."/CGeoFeatureService.inc.php" );


/*=======================================================================================
 *	TEST GEOGRAPHIC QUERIES																*
 *======================================================================================*/

//
// TRY BLOCK.
//
try
{
	//
	// Connect to database.
	//
	$client = new MongoClient( kDEFAULT_SERVER );
	$database = $client->selectDB( kDEFAULT_DATABASE );
	$collection = $database->selectCollection( kDEFAULT_COLLECTION );
	
	//
	// Test geoNear aggregated group.
	//
	echo( "\nGEONEAR (aggregated group)\n" );
	$maxdist = 1000;
	$command = array
	(
		array
		(
			'$geoNear' => array
			(
				'near' => array( -16.6422, 28.2727 ),
				'distanceField' => 'distance',
//				'limit' => 5,
				'maxDistance' => ($maxdist / 6378100),
//				'query' => array( 'alt' => array( '$gt' => 3200 ) ),
				'spherical' => TRUE,
				'distanceMultiplier' => 6378100,
				'includeLocs' => 'pt'
			)
		),
		array
		(
			'$group' => array
			(
				'_id' => 1,
				'count' => array( '$sum' => 1 ),
				'elev_min' => array( '$min' => '$elev' ),
				'elev_avg' => array( '$avg' => '$elev' ),
				'elev_max' => array( '$max' => '$elev' ),
				'gens_id' => array( '$addToSet' => '$clim.2000.gens.id' ),
				'gens_c' => array( '$addToSet' => '$clim.2000.gens.c' ),
				'gens_e' => array( '$addToSet' => '$clim.2000.gens.e' )
			)
		),
		array
		(
			'$project' => array
			(
				'_id' => 0,
				'count' => 1,
				'elev' => array( 'l' => '$elev_min',
								 'm' => '$elev_avg',
								 'h' => '$elev_max' ),
				'gens' => array( 'id' => '$gens_id',
								 'c' => '$gens_c',
								 'e' => '$gens_e' ),
				'clim' => array
				(
					'2000' => array
					(
						'bio' => array( '1' => '$elev_max' )
					)
				)
			)
		)
	);
	print_r( $command );
	echo( "\n" );
	$rs = $collection->aggregate( $command );
	var_dump( $rs );
	echo( "\n" );
	
	//
	// Test GEOWITHIN aggregated group.
	//
	echo( "\GEOWITHIN (aggregated group)\n" );
	$maxdist = 1000;
	$command = array
	(
		array
		(
			'$match' => array
			(
				'pt' => array
				(
					'$geoWithin' => array
					(
						'$geometry' => array
						(
							'type' => 'Polygon',
							'coordinates' => array
							(
								array
								(
									array( (-16.6422 - 0.0041666666667), (28.2727 + 0.0041666666667) ),
									array( (-16.6422 + 0.0041666666667), (28.2727 + 0.0041666666667) ),
									array( (-16.6422 + 0.0041666666667), (28.2727 - 0.0041666666667) ),
									array( (-16.6422 - 0.0041666666667), (28.2727 - 0.0041666666667) ),
									array( (-16.6422 - 0.0041666666667), (28.2727 + 0.0041666666667) )
								)
							)
						)
					)
				)
			)
		),
		array
		(
			'$group' => array
			(
				'_id' => 1,
				'count' => array( '$sum' => 1 ),
				'elev_min' => array( '$min' => '$elev' ),
				'elev_avg' => array( '$avg' => '$elev' ),
				'elev_max' => array( '$max' => '$elev' ),
				'gens_id' => array( '$addToSet' => '$clim.2000.gens.id' ),
				'gens_c' => array( '$addToSet' => '$clim.2000.gens.c' ),
				'gens_e' => array( '$addToSet' => '$clim.2000.gens.e' )
			)
		),
		array
		(
			'$project' => array
			(
				'_id' => 0,
				'count' => 1,
				'elev' => array( 'l' => '$elev_min',
								 'm' => '$elev_avg',
								 'h' => '$elev_max' ),
				'gens' => array( 'id' => '$gens_id',
								 'c' => '$gens_c',
								 'e' => '$gens_e' ),
				'clim' => array
				(
					'2000' => array
					(
						'bio' => array( '1' => '$elev_max' )
					)
				)
			)
		)
	);
	print_r( $command );
	echo( "\n" );
	$rs = $collection->aggregate( $command );
	var_dump( $rs );
	echo( "\n" );
	
	//
	// Test proximity.
	//
	echo( "\nNEAR\n" );
	$query = array
	(
		'pt' => array
		(
			'$near' => array
			(
				'$geometry' => array
				(
					'type' => 'Point',
					'coordinates' => array( -16.6422, 28.2727 )
				),
				'$maxDistance' => 650
			)
		)
	);
	print_r( $query );
	echo( "\n" );
	$rs = $collection->find( $query );
	$records = Array();
	foreach( $rs as $record )
	{
	/*
		$line = Array();
		$line[0] = $record[ 'pt' ][ 'coordinates' ][ 0 ];
		$line[1] = $record[ 'pt' ][ 'coordinates' ][ 1 ];
		$line[2] = $record[ 'alt' ];
		$records[] = $line;
	*/
		$records[] = $record;
	}
	print_r( $records );
	echo( "\n" );
	
	//
	// Test within.
	//
	echo( "\nGEOWITHIN\n" );
	$query = array
	(
		'pt' => array
		(
			'$geoWithin' => array
			(
				'$geometry' => array
				(
					'type' => 'Polygon',
					'coordinates' => array
					(
						array
						(
							array( (-16.6422 - 0.0041666666667), (28.2727 + 0.0041666666667) ),
							array( (-16.6422 + 0.0041666666667), (28.2727 + 0.0041666666667) ),
							array( (-16.6422 + 0.0041666666667), (28.2727 - 0.0041666666667) ),
							array( (-16.6422 - 0.0041666666667), (28.2727 - 0.0041666666667) ),
							array( (-16.6422 - 0.0041666666667), (28.2727 + 0.0041666666667) )
						)
					)
				)
			)
		)
	);
	print_r( $query );
	echo( "\n" );
	$rs = $collection->find( $query );
	$records = Array();
	foreach( $rs as $record )
	{
		$line = Array();
		$line[0] = $record[ 'pt' ][ 'coordinates' ][ 0 ];
		$line[1] = $record[ 'pt' ][ 'coordinates' ][ 1 ];
		$line[2] = $record[ 'alt' ];
		$records[] = $line;
	}
	print_r( $records );
	echo( "\n" );
	
	//
	// Test geoNear.
	//
	echo( "\nGEONEAR\n" );
	$maxdist = 1000;
	$command = array
	(
		'geoNear' => 'WORLDCLIM30',
		'near' => array( -16.6422, 28.2727 ),
		'spherical' => TRUE,
		'distanceMultiplier' => 6378100,
		'maxDistance' => ($maxdist / 6378100),
		'num' => 5
	);
	print_r( $command );
	echo( "\n" );
	$rs = $database->command( $command );
	print_r( $rs );
	echo( "\n" );
	
	//
	// Test geoNear aggregated.
	//
	echo( "\nGEONEAR (aggregated)\n" );
	$maxdist = 1000;
	$command = array
	(
		'$geoNear' => array
		(
			'near' => array( -16.6422, 28.2727 ),
			'distanceField' => 'distance',
			'limit' => 5,
			'maxDistance' => ($maxdist / 6378100),
			'query' => array( 'alt' => array( '$gt' => 3200 ) ),
			'spherical' => TRUE,
			'distanceMultiplier' => 6378100,
			'includeLocs' => 'pt'
		)
	);
	print_r( $command );
	echo( "\n" );
	$rs = $collection->aggregate( $command );
	print_r( $rs );
	echo( "\n" );
	
	echo( "\nDONE\n" );
}
catch( Exception $error )
{
	echo( "\nUnexpected exception\n" );
	echo( (string) $error );
}

?>
