<?php

/**
 * Add reference polygon to records.
 *
 * This file contains the routine to create a new set of results including the tile polygon.
 * The script expects two parameters: the first being the existing collection name and the
 * second being the new collection name.
 *
 *	@package	GEOGRAPHY
 *	@subpackage	LAYERS
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/08/2013
 */

/*=======================================================================================
 *																						*
 *										AddPoly.php			    						*
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
 *	GLOBALS																				*
 *======================================================================================*/

//
// Batch records.
//
$id = 0;
$records = Array();
$limit = kBUF_RECORD_COUNT;


/*=======================================================================================
 *	TRY																					*
 *======================================================================================*/

//
// TRY BLOCK.
//
try
{
	//
	// Check parameters.
	//
	if( isset( $_SERVER['argc'] )
	 && ($_SERVER['argc'] > 2) )
	{
		//
		// Set old and new collection.
		//
		$old = $argv[ 1 ];
		$new = $argv[ 2 ];

	} // Correct number of arguments.

	else
		throw new Exception( "Usage: script.php <old collection> <new collection>" );

	//
	// Open database connection.
	//
	$mongo = new MongoClient( kDEFAULT_SERVER );
	$database = $mongo->selectDB( kDEFAULT_DATABASE );
	$collection_old = $database->selectCollection( $old );
	$collection_new = $database->selectCollection( $new );

	//
	// Drop new collection.
	//
	$collection_new->drop();

	//
	// Select first batch.
	//
	$rs = $collection_old->find()->limit( kBUF_RECORD_COUNT );

	//
	// Sort by ID.
	//
	$rs->sort( array( '_id' => 1 ) );

	//
	// Iterate batches.
	//
	while( $rs->count( FALSE ) )
	{
		//
		// Iterate records.
		//
		foreach( $rs as $record )
		{
			//
			// Init destination record.
			//
			$dest = Array();

			//
			// Iterate record fields.
			//
			foreach( $record as $key => $value )
			{
				//
				// Save identifier.
				//
				if( $key == '_id' )
					$id = $value;

				//
				// Add value.
				//
				$dest[ $key ] = $value;

				//
				// Put poly after point.
				//
				if( $key == kAPI_DATA_POINT )
				{
					//
					// Build poly.
					//
					$poly = Array();
					$poly[] = array( $record[ kAPI_DATA_BOX_DEC ][ 0 ][ 0 ],
									 $record[ kAPI_DATA_BOX_DEC ][ 0 ][ 1 ] );
					$poly[] = array( $record[ kAPI_DATA_BOX_DEC ][ 1 ][ 0 ],
									 $record[ kAPI_DATA_BOX_DEC ][ 0 ][ 1 ] );
					$poly[] = array( $record[ kAPI_DATA_BOX_DEC ][ 1 ][ 0 ],
									 $record[ kAPI_DATA_BOX_DEC ][ 1 ][ 1 ] );
					$poly[] = array( $record[ kAPI_DATA_BOX_DEC ][ 0 ][ 0 ],
									 $record[ kAPI_DATA_BOX_DEC ][ 1 ][ 1 ] );
					$poly[] = array( $record[ kAPI_DATA_BOX_DEC ][ 0 ][ 0 ],
									 $record[ kAPI_DATA_BOX_DEC ][ 0 ][ 1 ] );

					//
					// Set outer ring.
					//
					$dest[ kAPI_DATA_POLY ] = array( 'type' => 'Polygon',
													 'coordinates' => array( $poly ) );

				} // Found point.

			} // Iterating record fields.

			//
			// Add record.
			//
			$records[] = $dest;

		} // Iterating records.

		//
		// Flush records.
		//
		if( count( $records ) )
		{
			$collection_new->batchInsert( $records );
			$records = Array();
		}

		//
		// Select next batch.
		//
		$rs = $collection_old->find( array( '_id' => array( '$gt' => $id ) ) )
							 ->limit( kBUF_RECORD_COUNT );

		//
		// Sort by ID.
		//
		$rs->sort( array( '_id' => 1 ) );

	} // Found records.

	//
	// Flush records.
	//
	if( count( $records ) )
		$collection_new->batchInsert( $records );

	//
	// Show.
	//
	echo( "\n\nDone!\n" );

} // TRY BLOCK.


/*=======================================================================================
 *	CATCH																				*
 *======================================================================================*/

//
// CATCH BLOCK.
//
catch( Exception $error )
{
	echo( (string) $error );
}


?>
