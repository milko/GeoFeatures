<?php

/*=======================================================================================
 *																						*
 *								CGeoFeatureService.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CGeoFeatureService} definitions.
 *
 *	This file contains common definitions used by the {@link CGeoFeatureService} class.
 *
 *	@package	WORLDCLIM30
 *	@subpackage	Services
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/07/2013
 */

/*=======================================================================================
 *	OPERATION PARAMETERS																*
 *======================================================================================*/

/**
 * Ping.
 *
 * This is the tag that represents the PING web-service operation, which returns 'pong'.
 *
 * Type: no data.
 */
define( "kAPI_OP_PING",					'ping' );

/**
 * Help.
 *
 * This is the tag that represents the HELP web-service operation, which returns the list
 * of supported operations and options.
 *
 * Type: no data.
 */
define( "kAPI_OP_HELP",					'help' );

/**
 * Tile.
 *
 * Retrieve tiles matching the provided list of tile identifiers.
 *
 * Type: no data.
 */
define( "kAPI_OP_TILE",					'tiles' );

/**
 * Contains.
 *
 * Retrieve tiles containing the provided point, or the tiles contained by the provided
 * rect or polygon.
 *
 * Type: no data.
 */
define( "kAPI_OP_CONTAINS",				'contains' );

/**
 * Intersects.
 *
 * Retrieve tiles intersecting the provided rect or polygon.
 *
 * Type: no data.
 */
define( "kAPI_OP_INTERSECTS",			'intersects' );

/**
 * Near.
 *
 * Retrieve tiles based on the distance from the provided geometry.
 *
 * Type: no data.
 */
define( "kAPI_OP_NEAR",					'near' );

/*=======================================================================================
 *	MODIFIERS																			*
 *======================================================================================*/

/**
 * Count.
 *
 * Return only element count and altitude range.
 *
 * Type: no data.
 */
define( "kAPI_OP_COUNT",				'count' );

/**
 * Request.
 *
 * Return a copy of the parsed request.
 *
 * Type: no data.
 */
define( "kAPI_OP_REQUEST",				'cpy-request' );

/**
 * Connection.
 *
 * Return information on the connection.
 *
 * Type: no data.
 */
define( "kAPI_OP_CONNECTION",			'cpy-connection' );

/*=======================================================================================
 *	GEOMETRY PARAMETERS																	*
 *======================================================================================*/

/**
 * Tile.
 *
 * A list of tile identifiers separated by a comma.
 *
 * Examples:
 * <tt>33065587,774896741</tt>
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_TILE",			'tile' );

/**
 * Point.
 *
 * A point is expressed as a pair of coordinates, longitude and latitude in that order,
 * separated by a comma.
 *
 * Examples:
 * <tt>-16.6422,28.2727</tt>
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_POINT",			'point' );

/**
 * Rect.
 *
 * A rect is expressed as a pair of longitude and latitude coordinates, the coordinates are
 * separated by a comma and the vertices by a semicolon.
 *
 * Examples:
 * <tt>-16.6422,28.2727;-12.22,23.55</tt>
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_RECT",			'rect' );

/**
 * Polygon.
 *
 * A polygon is expressed as a list of rings in which the first one represents the outer
 * ring and the others eventual holes. Rings are separated by colons, polygons by semicolons
 * and coordinates by commas; coordinates must be expressed as longitude and latitude pairs.
 *
 * Examples:
 * <tt>9.5387,46.2416;9.5448,46.2369;9.5536,46.2381;9.5571,46.2419;9.5507,46.2462;9.5439,46.2468;9.5387,46.2416:
 * 9.5445,46.2422;9.5481,46.2399;9.5517,46.2420;9.5463,46.2443;9.5445,46.2422</tt>
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_POLY",			'polygon' );

/**
 * Max distance.
 *
 * This parameter can be used for two purposes:
 *
 * <ul>
 *	<li><i>Convert a point</i>:: When a point is provided as a geometry and the distance is
 *		also provided, this means that we are looking at a sphere, where the distance is its
 *		radius. This is only valid when searching for tiles contained in the provided
 *		geometry, when searching for intersections, the point will be converted to a rect.
 *	<li><i>Maximum distance</i>: When requesting tiles by proximity, the distance can be
 *		used to limit the search to tiles within the provided value.
 * </ul>
 *
 * The value is expressed in kilometers.
 *
 * Examples:
 * <tt>1.250</tt>
 * <tt>5.60125</tt>
 *
 * Type: float.
 */
define( "kAPI_GEOMETRY_DISTANCE",		'distance' );

/*=======================================================================================
 *	GEOMETRY TYPES																		*
 *======================================================================================*/

/**
 * Tile.
 *
 * A list of tile identifiers.
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_TYPE_TILE",		'Tiles' );

/**
 * Point.
 *
 * A point.
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_TYPE_POINT",		'Point' );

/**
 * Rect.
 *
 * A rectangle.
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_TYPE_RECT",		'Rect' );

/**
 * Polygon.
 *
 * A polygon.
 *
 * Type: string.
 */
define( "kAPI_GEOMETRY_TYPE_POLY",		'Polygon' );

/*=======================================================================================
 *	ENVIRONMENT PARAMETERS																*
 *======================================================================================*/

/**
 * Elevation.
 *
 * Elevation range selector, provide a minimum and maximum value.
 *
 * Examples:
 * <tt>200,250</tt>
 *
 * Type: array.
 */
define( "kAPI_ENV_ELEVATION",			'elevation' );

/*=======================================================================================
 *	PAGING PARAMETERS																	*
 *======================================================================================*/

/**
 * Start.
 *
 * The starting record to retrieve.
 *
 * Type: intger.
 */
define( "kAPI_PAGE_START",				'start' );

/**
 * Limit.
 *
 * The maximum number of records to retrieve.
 *
 * Type: intger.
 */
define( "kAPI_PAGE_LIMIT",				'limit' );

/*=======================================================================================
 *	RESPONSE BLOCK PARAMETERS															*
 *======================================================================================*/

/**
 * Status.
 *
 * This tag identifies the status block.
 */
define( "kAPI_RESPONSE_STATUS",			'status' );

/**
 * Request.
 *
 * This tag identifies the parsed request block.
 */
define( "kAPI_RESPONSE_REQUEST",		'request' );

/**
 * Connection.
 *
 * This tag identifies the connection description block.
 */
define( "kAPI_RESPONSE_CONNECTION",		'connection' );

/**
 * Response.
 *
 * This tag identifies the service data response.
 */
define( "kAPI_RESPONSE_DATA",			'data' );

/*=======================================================================================
 *	STATUS BLOCK PARAMETERS																*
 *======================================================================================*/

/**
 * State.
 *
 * This tag identifies the status state, it can take two values: <tt>OK</tt> for a
 * successful operation or <tt>ERROR</tt> for a failed operation: the <tt>message</tt> field
 * will receive the error message.
 *
 * Type: string.
 */
define( "kAPI_STATUS_STATE",			'state' );

/**
 * Total.
 *
 * This tag identifies the result effective count, that is, the total number of results of
 * the query, excluding paging requests.
 *
 * Type: integer.
 */
define( "kAPI_STATUS_TOTAL",			'total' );

/**
 * Start.
 *
 * This tag identifies the result records start.
 *
 * Type: integer.
 */
define( "kAPI_STATUS_START",			'start' );

/**
 * Limit.
 *
 * This tag identifies the result maximum records count.
 *
 * Type: integer.
 */
define( "kAPI_STATUS_LIMIT",			'limit' );

/**
 * Count.
 *
 * This tag identifies the result count, that is, the total number of results returned by
 * the service.
 *
 * Type: integer.
 */
define( "kAPI_STATUS_COUNT",			'count' );

/**
 * Code.
 *
 * This tag identifies the status code, it will generally be omitted except if there is
 * an error.
 *
 * Type: int.
 */
define( "kAPI_STATUS_CODE",				'code' );

/**
 * Message.
 *
 * This tag identifies the status message, it will generally be omitted except if there is
 * an error.
 *
 * Type: string.
 */
define( "kAPI_STATUS_MESSAGE",			'message' );

/**
 * File.
 *
 * This tag identifies the exception file, it will generally be omitted except if there is
 * an error.
 *
 * Type: string.
 */
define( "kAPI_STATUS_FILE",				'file' );

/**
 * Line.
 *
 * This tag identifies the exception file line, it will generally be omitted except if there
 * is an error.
 *
 * Type: int.
 */
define( "kAPI_STATUS_LINE",				'line' );

/**
 * Trace.
 *
 * This tag identifies the exception trace, it will generally be omitted except if there is
 * an error.
 *
 * Type: array.
 */
define( "kAPI_STATUS_TRACE",			'trace' );

/*=======================================================================================
 *	STATUS STATE ENUMERATIONS															*
 *======================================================================================*/

/**
 * IDLE.
 *
 * This tag identifies an idle state.
 */
define( "kAPI_STATE_IDLE",				'IDLE' );

/**
 * OK.
 *
 * This tag identifies a successful state.
 */
define( "kAPI_STATE_OK",				'OK' );

/**
 * ERROR.
 *
 * This tag identifies an unsuccessful state.
 */
define( "kAPI_STATE_ERROR",				'ERROR' );

/*=======================================================================================
 *	REQUEST BLOCK PARAMETERS															*
 *======================================================================================*/

/**
 * OPERATION.
 *
 * This tag identifies the requested operation.
 */
define( "kAPI_REQUEST_OPERATION",		'operation' );

/**
 * MODIFIERS.
 *
 * This tag identifies the requested modifiers.
 */
define( "kAPI_REQUEST_MODIFIERS",		'modifiers' );

/**
 * GEOMETRY.
 *
 * This tag identifies the request geometry.
 */
define( "kAPI_REQUEST_GEOMETRY",		'geometry' );

/**
 * ELEVATION.
 *
 * This tag identifies the elevation range.
 */
define( "kAPI_REQUEST_ELEVATION",		'elevation' );

/*=======================================================================================
 *	CONNECTION BLOCK PARAMETERS															*
 *======================================================================================*/

/**
 * Server.
 *
 * This tag identifies the connected server.
 *
 * Type: string.
 */
define( "kAPI_CONNECTION_SERVER",		'server' );

/**
 * Database.
 *
 * This tag identifies the connected database.
 *
 * Type: string.
 */
define( "kAPI_CONNECTION_DATABASE",		'database' );

/**
 * Collection.
 *
 * This tag identifies the connected collection.
 *
 * Type: string.
 */
define( "kAPI_CONNECTION_COLLECTION",	'collection' );

/*=======================================================================================
 *	RESPONSE DATA BLOCK PARAMETERS														*
 *======================================================================================*/

/**
 * Identifier.
 *
 * This tag represents the offset of the record identifier, it is an integer representing
 * the ordinal position of the current tile.
 *
 * The data is divided in a 30 seconds grid made of 43200 longitudes and 18000 latitudes,
 * this identifier is calculated with this formula: <tt>Z = (Y * 43200) + X + 1</tt> where
 * <tt>Y</tt> represents the zero based vertical tile position and <tt>X</tt> represents
 * the zero based horizontal tile position.
 *
 * Type: integer.
 */
define( "kAPI_DATA_ID",					'_id' );

/**
 * Tile center.
 *
 * This tag represents the center point of the tile, it is an array structured as a GeoJson
 * point:
 *
 * <ul>
 *	<li><tt>type</tt>: The constant <tt>Point</tt>.
 *	<li><tt>coordinates</tt>: An array of two elements representing respectively the
 *		longitude and latitude of the point in decimal degrees.
 * </ul>
 *
 * Type: array.
 */
define( "kAPI_DATA_POINT",				'pt' );

/**
 * Tile center coordinates.
 *
 * This tag represents the center point of the tile in degrees, minutes and seconds
 * notation (<tt>DDD°MM'SS"H</tt>) as an array of two elements representing respectively
 * the longitude and latitude.
 *
 * Type: array.
 */
define( "kAPI_DATA_DMS",				'dms' );

/**
 * Tile grid coordinates.
 *
 * This tag represents the grid coordinates of the tile, it is an array in which the first
 * element represents the zero based <tt>X</tt> coordinate and the second the zero based
 * <tt>Y</tt> coordinate; both values are integers.
 *
 * Type: array.
 */
define( "kAPI_DATA_TILE",				'tile' );

/**
 * Tile decimal bounds.
 *
 * This tag represents the tile vertices in decimal degrees, it is an array of two elements
 * that respectively represent the top-left and bottom-right bounds of the rectangle that
 * encloses the tile; each element is an array of longitude and latitude coordinates in
 * decimal degrees.
 *
 * Type: array.
 */
define( "kAPI_DATA_BOX_DEC",			'bdec' );

/**
 * Tile degrees, minutes and seconds bounds.
 *
 * This tag represents the tile vertices in degrees, minutes and seconds. It is an array of
 * two elements that respectively represent the top-left and bottom-right bounds of the
 * rectangle that encloses the tile; each element is an array of longitude and latitude
 * coordinates in degrees, minutes and seconds notation (<tt>DDD°MM'SS"H</tt>).
 *
 * Type: array.
 */
define( "kAPI_DATA_BOX_DMS",			'bdms' );

/**
 * Tile elevation.
 *
 * This tag represents the tile elevation in meters.
 *
 * Type: integer.
 */
define( "kAPI_DATA_ELEVATION",			'elev' );

/**
 * Distance.
 *
 * This tag represents the distance in meters, this property is returned by services that
 * select tiles based on distance.
 *
 * Type: integer.
 */
define( "kAPI_DATA_DISTANCE",			'dist' );

/**
 * Climate section.
 *
 * This tag represents the climate data section, this section is divided in a series of
 * subsections, each referring to a period to which the climate data refers to.
 *
 * Currently there is only one subsection, <tt>2000</tt>, which refers to current climate
 * conditions, eventually other subsections could be added which refer to future climate
 * scenarios.
 *
 * Type: array.
 */
define( "kAPI_DATA_CLIMATE",			'clim' );

/*=======================================================================================
 *	CLIMATE BLOCK PARAMETERS															*
 *======================================================================================*/

/**
 * Global Environment Stratification.
 *
 * This tag represents the global environment stratification for the current tile, it is
 * an array of three elements representing:
 *
 * <ul>
 *	<li><tt>id</tt>: The global environment stratification identifier composed of the
 *		concatenation of the <i>environmental zone code</i> and the
 *		<i>stratification code</i>.
 *	<li><tt>c</tt>: The climatic zone code:
 *	 <ul>
 *		<li><tt>1</tt>: Arctic / Alpine.
 *		<li><tt>2</tt>: Boreal / Alpine.
 *		<li><tt>3</tt>: Cool temperate.
 *		<li><tt>4</tt>: Warm temperate.
 *		<li><tt>5</tt>: Sub-tropical.
 *		<li><tt>6</tt>: Drylands.
 *		<li><tt>7</tt>: Tropical.
 *	 </ul>
 *	<li><tt>c</tt>: The environmental zone code:
 *	 <ul>
 *		<li><tt>A</tt>: Arctic.
 *		<li><tt>B</tt>: Arctic.
 *		<li><tt>C</tt>: Extremely cold and wet.
 *		<li><tt>D</tt>: Extremely cold and wet.
 *		<li><tt>E</tt>: Cold and wet.
 *		<li><tt>F</tt>: Extremely cold and mesic.
 *		<li><tt>G</tt>: Cold and mesic.
 *		<li><tt>H</tt>: Cool temperate and dry.
 *		<li><tt>I</tt>: Cool temperate and xeric.
 *		<li><tt>J</tt>: Cool temperate and moist.
 *		<li><tt>K</tt>: Warm temperate and mesic.
 *		<li><tt>L</tt>: Warm temperate and xeric.
 *		<li><tt>M</tt>: Hot and mesic.
 *		<li><tt>N</tt>: Hot and dry.
 *		<li><tt>O</tt>: Hot and arid.
 *		<li><tt>P</tt>: Extremely hot and arid.
 *		<li><tt>Q</tt>: Extremely hot and xeric.
 *		<li><tt>R</tt>: Extremely hot and moist.
 *	 </ul>
 * </ul>
 *
 * Type: array.
 */
define( "kAPI_DATA_CLIMATE_GENS",		'gens' );

/**
 * Bioclimatic variables.
 *
 * This tag collects the bioclimatic variables which represent annual trends, seasonality
 * and extreme or limiting environmental factors. The secion is represented by an array of
 * 19 elements each representing a specific bioclimatic variable:
 *
 * <ul>
 *	<li><tt>1</tt>: Annual Mean Temperature [<tt>C° * 10</tt>].
 *	<li><tt>2</tt>: Mean Diurnal Range (<tt>Mean of monthly (max temp - min temp)</tt>)
 *		[<tt>C° * 10</tt>].
 *	<li><tt>3</tt>: Isothermality (<tt>bio[2]/bio[7]) (* 100)</tt>.
 *	<li><tt>4</tt>: Temperature Seasonality (<tt>standard deviation *100</tt>).
 *	<li><tt>5</tt>: Max Temperature of Warmest Month [C° * 10].
 *	<li><tt>6</tt>: Min Temperature of Coldest Month [C° * 10].
 *	<li><tt>7</tt>: Temperature Annual Range (<tt>bio[5]-bio[6]</tt>).
 *	<li><tt>8</tt>: Mean Temperature of Wettest Quarter [C° * 10].
 *	<li><tt>9</tt>: Mean Temperature of Driest Quarter [C° * 10].
 *	<li><tt>10</tt>: Mean Temperature of Warmest Quarter [C° * 10].
 *	<li><tt>11</tt>: Mean Temperature of Coldest Quarter [C° * 10].
 *	<li><tt>12</tt>: Annual Precipitation.
 *	<li><tt>13</tt>: Precipitation of Wettest Month.
 *	<li><tt>14</tt>: Precipitation of Driest Month.
 *	<li><tt>15</tt>: Precipitation Seasonality (Coefficient of Variation).
 *	<li><tt>16</tt>: Precipitation of Wettest Quarter.
 *	<li><tt>17</tt>: Precipitation of Driest Quarter.
 *	<li><tt>18</tt>: Precipitation of Warmest Quarter.
 *	<li><tt>19</tt>: Precipitation of Coldest Quarter.
 * </ul>
 *
 * Type: array.
 */
define( "kAPI_DATA_CLIMATE_BIO",		'bio' );

/**
 * Monthly precipitation.
 *
 * This tag collects the monthly precipitation, it is an array of 12 elements, one per
 * month (<tt>mm.</tt>).
 *
 * Type: array.
 */
define( "kAPI_DATA_CLIMATE_PREC",		'prec' );

/**
 * Monthly temperature.
 *
 * This tag collects the monthly temperature, it is an array of 3 elements:
 *
 * <ul>
 *	<li><tt>l</tt>: Average monthly minimum temperature [<tt>C° * 10</tt>].
 *	<li><tt>m</tt>: average monthly mean temperature [<tt>C° * 10</tt>].
 *	<li><tt>h</tt>: average monthly maximum temperature [<tt>C° * 10</tt>].
 * </ul>
 *
 * All three elements are an array of 12 elements, one per month.
 *
 * Type: array.
 */
define( "kAPI_DATA_CLIMATE_TEMP",		'temp' );


?>
