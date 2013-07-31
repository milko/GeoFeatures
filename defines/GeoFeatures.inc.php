<?php

/*=======================================================================================
 *																						*
 *									GeoFeatures.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	GeoFeatures definitions.
 *
 *	This file contains common definitions used by the {@link GeoFeatures.php} service.
 *
 *	@package	GEO
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 31/07/2013
 */

/*=======================================================================================
 *	FEATURE RECORD OFFSETS																*
 *======================================================================================*/

/**
 * Identifier.
 *
 * This tag represents the unique identifier of the feature set, it is ecpressed as the hash
 * of the geometry, {@link 
 *
 * <ul>
 *	<li><tt>type</tt>: The geometry type:
 *	 <ul>
 *		<li><tt>Point</tt>: A single coordinate pair as described in the GeoJSON Point
 *			specification: {@link http://geojson.org/geojson-spec.html#point}.
 *		<li><tt>LineString</tt>: A LineString is defined by an array of two or more
 *			positions. A closed LineString with four or more positions is called a
 *			LinearRing, as described in the GeoJSON LineString specification:
 *			{@link http://geojson.org/geojson-spec.html#linestring}.
 *		<li><tt>Polygon</tt>: An array of LinearRing coordinate arrays, as described in the
 *			GeoJSON Polygon specification:
 *			{@link http://geojson.org/geojson-spec.html#polygon}. For Polygons with multiple
 *			rings, the first must be the exterior ring and any others must be interior
 *			rings or holes.
 *	 </ul>
 *	<li><tt>coordinates</tt>: The list of longitude and latitude coordinatesm, in that
 *		order, expressed in decimal degrees.
 * </ul>
 *
 * All geometries are expected to be in WGS84 geodetic datum.
 *
 * Type: object.
 */
define( "kGEO_FEATURE_IDENTIFIER",					'_id' );

/**
 * Geometry.
 *
 * This tag identifies the geometry of the feature set, it is a GeoJson record structured as
 * follows:
 *
 * <ul>
 *	<li><tt>type</tt>: The geometry type:
 *	 <ul>
 *		<li><tt>Point</tt>: A single coordinate pair as described in the GeoJSON Point
 *			specification: {@link http://geojson.org/geojson-spec.html#point}.
 *		<li><tt>LineString</tt>: A LineString is defined by an array of two or more
 *			positions. A closed LineString with four or more positions is called a
 *			LinearRing, as described in the GeoJSON LineString specification:
 *			{@link http://geojson.org/geojson-spec.html#linestring}.
 *		<li><tt>Polygon</tt>: An array of LinearRing coordinate arrays, as described in the
 *			GeoJSON Polygon specification:
 *			{@link http://geojson.org/geojson-spec.html#polygon}. For Polygons with multiple
 *			rings, the first must be the exterior ring and any others must be interior
 *			rings or holes.
 *	 </ul>
 *	<li><tt>coordinates</tt>: The list of longitude and latitude coordinatesm, in that
 *		order, expressed in decimal degrees.
 * </ul>
 *
 * All geometries are expected to be in WGS84 geodetic datum.
 *
 * Type: object.
 */
define( "kGEO_FEATURE_GEOMETRY",					'geom' );

/**
 * DMS geometry.
 *
 * This tag identifies the geometry of the feature set expressed in degrees, minutes and
 * seconds notation (<tt>DDD°MM'SS.SSS"H</tt>). The structure of this item is the same as
 * the {@link kGEO_FEATURE_GEOMETRY} item, except that all coordinates must be expressed in
 * the above format. Besides providing coordinates in degrees, minutes and seconds, this
 * data item will be used to generate the feature set unique identifier.
 *
 * Besides the geometry types of the {@link kGEO_FEATURE_GEOMETRY} property, this property
 * adds another type, <tt>Rect</tt>, which represents a pairt of coordinate points
 * representing the top-left and bottom-right vertices of a rectangle: this type is
 * converted to a <tt>Polygon</tt> in the {@link kGEO_FEATURE_GEOMETRY} for data indexing
 * reasons.
 *
 * Type: object.
 */
define( "kGEO_FEATURE_GEOMETRY_DMS",				'geod' );

/**
 * Elevation.
 *
 * This tag identifies the elevation of the current geometry, it can be provided both as a
 * scalar integer value, or as the following structure if the elevation represents a range:
 *
 * <ul>
 *	<li><tt>l</tt>: Minimum elevation bound.
 *	<li><tt>h</tt>: Maximum elevation bound.
 * </ul>
 *
 * All elevations are expected to be in meters.
 *
 * Type: mixed.
 */
define( "kGEO_FEATURE_ELEVATION",					'elev' );


?>
