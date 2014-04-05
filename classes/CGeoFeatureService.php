<?php

/**
 * <i>CGeoFeatureService</i> class definition.
 *
 * This file contains the class definition of <b>CGeoFeatureService</b> which represents a
 * web-service that can be used to query WORLDCLIM data.
 *
 *	@package	WORLDCLIM30
 *	@subpackage	Services
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/07/2013
 */

/*=======================================================================================
 *																						*
 *								CGeoFeatureService.php									*
 *																						*
 *======================================================================================*/

/**
 * Class definitions.
 *
 * This include file contains all class definitions.
 */
require_once( "CGeoFeatureService.inc.php" );

/**
 * <h4>WORLDCLIM web-service</h4>
 *
 * This class represents a web-service, it defines the parameter classes and the methods
 * that implement a WORLDCLIM 30 seconds service.
 *
 *	@package	WORLDCLIM30
 *	@subpackage	Services
 */
class CGeoFeatureService extends ArrayObject
{
	/**
	 * <b>Server</b>
	 *
	 * This data member will hold the server reference.
	 *
	 * @var MongoClient
	 */
	 protected $mServer = NULL;

	/**
	 * <b>Database</b>
	 *
	 * This data member will hold the database reference.
	 *
	 * @var mixed
	 */
	 protected $mDatabase = NULL;

    /**
     * <b>Collection</b>
     *
     * This data member will hold the collection reference.
     *
     * @var mixed
     */
    protected $mCollection = NULL;

    /**
     * <b>Grid size</b>
     *
     * This data member will hold the grid size in seconds.
     *
     * @var integer
     */
    protected $mGridSize = NULL;

	/**
	 * <b>Status</b>
	 *
	 * This data member will hold the service status.
	 *
	 * @var array
	 */
	 protected $mStatus = Array();

	/**
	 * <b>Connection</b>
	 *
	 * This data member will hold the service connection.
	 *
	 * @var array
	 */
	 protected $mConnection = Array();

	/**
	 * <b>Request</b>
	 *
	 * This data member will hold the service request.
	 *
	 * @var array
	 */
	 protected $mRequest = Array();

	/**
	 * <b>Response</b>
	 *
	 * This data member will hold the service data response.
	 *
	 * @var array
	 */
	 protected $mResponse = Array();

	/**
	 * <b>Operation</b>
	 *
	 * This data member will hold the service operation code.
	 *
	 * @var string
	 */
	 protected $mOperation = NULL;

	/**
	 * <b>Modifiers</b>
	 *
	 * This data member will hold the service request modifiers list.
	 *
	 * @var array
	 */
	 protected $mModifiers = Array();

	/**
	 * <b>Geometry</b>
	 *
	 * This data member will hold the service request geometry.
	 *
	 * @var array
	 */
	 protected $mGeometry = NULL;

	/**
	 * <b>Elevation</b>
	 *
	 * This data member will hold the elevation range.
	 *
	 * @var array
	 */
	 protected $mElevation = NULL;

	/**
	 * <b>Distance</b>
	 *
	 * This data member will hold the service request distance.
	 *
	 * @var integer
	 */
	 protected $mDistance = NULL;

	/**
	 * <b>Start</b>
	 *
	 * This data member will hold the service record start.
	 *
	 * @var integer
	 */
	 protected $mStart = NULL;

    /**
     * <b>Limit</b>
     *
     * This data member will hold the service maximum record count.
     *
     * @var integer
     */
    protected $mLimit = NULL;

    /**
     * <b>Selection</b>
     *
     * This data member will hold the service response parameters selection.
     *
     * @var array
     */
    protected $mSelection = Array();

	/**
	 * kDistMult.
	 *
	 * This integer value represents the distance multiplier: when requesting tiles based
	 * on the distance, this value is used to obtain a distance in meters.
	 *
	 * Type: double.
	 */
	const kDistMult = 6371000;

	/**
	 * kKilometerDegs.
	 *
	 * This double value represents 1 kilometer in degrees.
	 *
	 * Type: double.
	 */
	const kKilometerDegs = 0.00898270828655;



/*=======================================================================================
 *																						*
 *										MAGIC											*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	__construct																		*
	 *==================================================================================*/

	/**
	 * Instantiate class.
	 *
	 * The constructor will set-up the environment by setting the eventual server, database
	 * and collection and parse the request collecting the service parameters.
	 *
	 * @param mixed					$theServer			Server reference.
	 * @param mixed					$theDatabase		Database reference.
     * @param mixed					$theCollection		Collection reference.
     * @param integer				$theGrid    		Grid size in seconds.
	 */
	public function __construct( $theServer = NULL,
								 $theDatabase = NULL,
								 $theCollection = NULL,
                                 $theGrid = 30 )
	{
		//
		// Catch help request.
		// Copied here to prevent errors if database is busy.
		//
		if( isset( $_REQUEST )
			&& array_key_exists( kAPI_OP_HELP, $_REQUEST ) )
			$this->_RequestHelp();

		//
		// Call parent constructor.
		//
		parent::__construct();

		//
		// Initialise service.
		//
		$this->_InitService();

        //
        // Set grid size.
        //
        $this->mGridSize = $theGrid;

		//
		// TRY BLOCK
		//
		try
		{
			//
			// Catch service maintenance.
			//
			if( kAPI_SERVICE_STATUS_MAINTENANCE )
				throw new Exception(
					"The service is under maintenance, "
				   ."please try later." );				  						// !@! ==>

			//
			// Set server.
			//
			if( $theServer !== NULL )
				$this->Server( $theServer );

			//
			// Set database.
			//
			if( $theDatabase !== NULL )
				$this->Database( $theDatabase );

			//
			// Set collection.
			//
			if( $theCollection !== NULL )
				$this->Collection( $theCollection );

			//
			// Parse request.
			//
			$this->_ParseRequest( $_REQUEST );
		}

		//
		// CATCH BLOCK
		//
		catch( Exception $error )
		{
			//
			// Load exception in status.
			//
			$this->_Exception2Status( $error );

			//
			// Build response.
			//
			$this->_BuildResponse();
		}

	} // Constructor.



/*=======================================================================================
 *																						*
 *							PUBLIC DATA MEMBER ACCESSOR METHODS							*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	Server																			*
	 *==================================================================================*/

	/**
	 * Manage server.
	 *
	 * This method can be used to set, retrieve and delete the server reference.
	 *
	 * It accepts two parameters:
	 *
	 * <ul>
	 *	<li><b>$theValue</b>: Value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Retrieve current value (DEFAULT).
	 *		<li><tt>MongoClient</tt>: Set with the provided value.
	 *		<li><i>other</i>: Any other value will be cast to a string and used to
	 *			instantiate the server.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * When providing a new value, if a database exists, it will be replaced by a
	 * reference to a database with the same name in the newly provided server.
	 *
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 *
	 * @uses Database()
	 * @uses _ManageMember()
	 */
	public function Server( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle new value.
		//
		if( $theValue !== NULL )
		{
			//
			// Instantiate server.
			//
			if( ! ($theValue instanceof MongoClient) )
				$theValue = new MongoClient( (string) $theValue );

			//
			// Handle database.
			//
			if( ($tmp = $this->Database()) !== NULL )
				$this->Database( $theValue->selectDB( (string) $tmp ) );

		} // New value.

		return $this->_ManageMember( $this->mServer, $theValue, $getOld );			// ==>

	} // Server.


	/*===================================================================================
	 *	Database																		*
	 *==================================================================================*/

	/**
	 * Manage database.
	 *
	 * This method can be used to set, retrieve and delete the database reference.
	 *
	 * It accepts two parameters:
	 *
	 * <ul>
	 *	<li><b>$theValue</b>: Value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Retrieve current value (DEFAULT).
	 *		<li><tt>MongoDB</tt>: Set with the provided value.
	 *		<li><i>other</i>: Any other value will be cast to a string and used to
	 *			instantiate the database.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * If a database object is provided, the method will clear the eventual existing server.
	 * When providing a new value, if a collection exists, it will be replaced by a
	 * reference to a collection with the same name in the newly provided database.
	 * If a database name is provided and no server is set, the method will raise an
	 * exception.
	 *
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 *
	 * @uses Server()
	 * @uses Collection()
	 * @uses _ManageMember()
	 */
	public function Database( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle new value.
		//
		if( $theValue !== NULL )
		{
			//
			// Save server.
			//
			$server = $this->Server();

			//
			// Handle database reference.
			//
			if( $theValue instanceof MongoDB )
			{
				//
				// Handle server.
				//
				if( $server !== NULL )
					$this->mServer = NULL;

			} // Provided object.

			//
			// Instantiate database.
			//
			else
			{
				//
				// Check server.
				//
				if( $server !== NULL )
					$theValue = $server->selectDB( (string) $theValue );

				else
					throw new Exception
						( "Unable to set database reference: "
						 ."missing server reference." );						// !@! ==>

			} // Provided name.

			//
			// Handle existing collection.
			//
			if( ($tmp = $this->Collection()) !== NULL )
				$this->mCollection = $theValue->selectCollection( $tmp->getName() );

		} // New value.

		return $this->_ManageMember( $this->mDatabase, $theValue, $getOld );		// ==>

	} // Database.


	/*===================================================================================
	 *	Collection																		*
	 *==================================================================================*/

	/**
	 * Manage collection.
	 *
	 * This method can be used to set, retrieve and delete the collection reference.
	 *
	 * It accepts two parameters:
	 *
	 * <ul>
	 *	<li><b>$theValue</b>: Value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Retrieve current value (DEFAULT).
	 *		<li><tt>MongoCollection</tt>: Set with the provided value.
	 *		<li><i>other</i>: Any other value will be cast to a string and used to
	 *			instantiate the collection.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * If a collection object is provided, the method will replace the eventual existing
	 * database reference with the collection's database.
	 * If a collection name is provided and no database is set, the method will raise an
	 * exception.
	 *
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 *
	 * @uses Database()
	 * @uses _ManageMember()
	 */
	public function Collection( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle new value.
		//
		if( $theValue !== NULL )
		{
			//
			// Handle collection reference.
			//
			if( $theValue instanceof MongoCollection )
			{
				//
				// Handle database.
				//
				if( $this->Database() !== NULL )
					$this->Database( $theValue->db );

			} // Provided object.

			//
			// Instantiate collection.
			//
			else
			{
				//
				// Check database.
				//
				if( ($tmp = $this->Database()) !== NULL )
					$theValue = $tmp->selectCollection( (string) $theValue );

				else
					throw new Exception
						( "Unable to set collection reference: "
						 ."missing database reference." );						// !@! ==>

			} // Provided name.

		} // New value.

		return $this->_ManageMember( $this->mCollection, $theValue, $getOld );		// ==>

	} // Collection.


	/*===================================================================================
	 *	Operation																		*
	 *==================================================================================*/

	/**
	 * Return service operation.
	 *
	 * This method will return the current service operation code.
	 *
	 * @access public
	 * @return string
	 */
	public function Operation()								{	return $this->_Operation();	}



/*=======================================================================================
 *																						*
 *								PUBLIC HANDLER INTERFACE								*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	HandleRequest																	*
	 *==================================================================================*/

	/**
	 * Handle request.
	 *
	 * This method will handle the request.
	 *
	 * @access public
	 *
	 * @uses Collection()
	 * @uses _Ping()
	 * @uses _Help()
	 * @uses _Operation()
	 */
	public function HandleRequest()
	{
		//
		// TRY BLOCK
		//
		try
		{
			//
			// Execute command.
			//
			switch( $tmp = $this->mOperation )
			{
				case kAPI_OP_PING:
					$this->_RequestPing();
					break;

				case kAPI_OP_HELP:
					$this->_RequestHelp();
					break;

				case kAPI_OP_TILE:
					$this->_RequestTile();
					break;

				case kAPI_OP_CONTAINS:
					$this->_RequestContains();
					break;

				case kAPI_OP_INTERSECTS:
					$this->_RequestIntersects();
					break;

				case kAPI_OP_NEAR:
					$this->_RequestNear();
					break;

				default:
					throw new Exception
						( "Unable to handle request: "
						 ."missing or unsupported operation." );				// !@! ==>
			}
		}

		//
		// CATCH BLOCK
		//
		catch( Exception $error )
		{
			//
			// Load exception in status.
			//
			$this->_Exception2Status( $error );

			//
			// Build response.
			//
			$this->_BuildResponse();
		}

	} // HandleRequest.



/*=======================================================================================
 *																						*
 *									PUBLIC STATUS INTERFACE								*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	Status																			*
	 *==================================================================================*/

	/**
	 * Return object status.
	 *
	 * This method will return the object status, if it returns {@link kAPI_STATE_ERROR}
	 * it means that there was an error.
	 *
	 * @access public
	 * @return string
	 */
	public function Status()
	{
		return $this->_Status()[ kAPI_STATUS_STATE ];								// ==>

	} // Status.



/*=======================================================================================
 *																						*
 *							PROTECTED INITIALISATION INTERFACE							*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_InitService																	*
	 *==================================================================================*/

	/**
	 * Initialise service.
	 *
	 * This method will initialise the servicestructures.
	 *
	 * @access protected
	 */
	protected function _InitService()
	{
		//
		// Set idle status.
		//
		$this->_Status( FALSE );

	} // _InitService.


	/*===================================================================================
	 *	_ParseRequest																	*
	 *==================================================================================*/

	/**
	 * Parse request.
	 *
	 * This method will parse the request and fill all the object parameters.
	 *
	 * @param reference			   &$theRequest			Request.
	 *
	 * @access protected
	 */
	protected function _ParseRequest( &$theRequest )
	{
		//
		// Parse operation.
		//
		$this->_Operation( $theRequest );

		//
		// Parse modifiers.
		//
		$this->_Modifiers( $theRequest );

		//
		// Parse geometry.
		//
		$this->_Geometry( $theRequest );

		//
		// Parse elevation.
		//
		$this->_Elevation( $theRequest );

		//
		// Parse distance.
		//
		$this->_Distance( $theRequest );

		//
		// Parse paging.
		//
		if( (! $this->_Modifiers( kAPI_OP_COUNT ))
		 || (! $this->_Modifiers( kAPI_OP_RANGE )) )
		{
			$this->_Start( $theRequest );
			$this->_Limit( $theRequest );
		}

        //
        // Parse selection.
        //
        $this->_Selection( $theRequest );

		//
		// Store request.
		//
		$this->_StoreRequest();

		//
		// Assume successful operation.
		//
		$this->_Status( kAPI_STATUS_STATE, kAPI_STATE_OK );
		
		//
		// Check area.
		//
		$area = $this->_Area();
		if( $area !== NULL )
		{
			//
			// Convert.
			//
			$area /= self::kKilometerDegs;
			
			//
			// Check.
			//
			if( $area > kAPI_DEFAULT_MAX_AREA )
				throw new Exception(
					"Unable to execute service: "
				   ."the area of the geometry must be "
				   ."less than 1000 square kilometers, "
				   ."provided $area." );										// !@! ==>
		
		} // Has area.

	} // _ParseRequest.



/*=======================================================================================
 *																						*
 *						PROTECTED DATA MEMBER ACCESSOR METHODS							*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_Status																			*
	 *==================================================================================*/

	/**
	 * Manage service status.
	 *
	 * This method can be used to set or retrieve the service status.
	 *
	 * It accepts three parameters:
	 *
	 * <ul>
	 *	<li><b>$theIndex</b>: Element index:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Consider the whole property.
	 *		<li><tt>FALSE</tt>: Reset status to idle..
	 *		<li><i>other</i>: Any other value will be cast to a string and used as the key
	 *			to the specific property element.
	 *	 </ul>
	 *	<li><b>$theValue</b>: Property element value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return current element or property.
	 *		<li><tt>FALSE</tt>: Delete current element or property.
	 *		<li><i>other</i>: Set element or property with the provided value; when setting
	 *			the whole property, you must provide an array.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theIndex			Status element index.
	 * @param mixed					$theValue			Status element value.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @uses _ManageArrayMember()
	 */
	protected function _Status( $theIndex = NULL, $theValue = NULL, $getOld = FALSE )
	{
		//
		// Set or retrieve status.
		//
		if( $theIndex !== FALSE )
			return $this->_ManageArrayMember(
					$this->mStatus, $theIndex, $theValue, $getOld );				// ==>

		//
		// Reset status.
		//
		$this->_Status( NULL, FALSE );

		//
		// Set to idle.
		//
		$this->_Status( kAPI_STATUS_STATE, kAPI_STATE_IDLE );

		return $this->_Status( NULL, NULL, $getOld );								// ==>

	} // _Status.


	/*===================================================================================
	 *	_Connection																		*
	 *==================================================================================*/

	/**
	 * Manage service connection.
	 *
	 * This method can be used to set or retrieve the service connection.
	 *
	 * It accepts three parameters:
	 *
	 * <ul>
	 *	<li><b>$theIndex</b>: Element index:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Consider the whole property.
	 *		<li><i>other</i>: Any other value will be cast to a string and used as the key
	 *			to the specific property element.
	 *	 </ul>
	 *	<li><b>$theValue</b>: Property element value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return current element or property.
	 *		<li><tt>FALSE</tt>: Delete current element or property.
	 *		<li><i>other</i>: Set element or property with the provided value; when setting
	 *			the whole property, you must provide an array; when setting an element the
	 *			value will be cast to string.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theIndex			Connection element index.
	 * @param mixed					$theValue			Connection element value.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @uses _ManageArrayMember()
	 */
	protected function _Connection( $theIndex = NULL, $theValue = NULL, $getOld = FALSE )
	{
		//
		// Cast to string.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
			$theValue = (string) $theValue;

		return $this->_ManageArrayMember(
				$this->mConnection, $theIndex, $theValue, $getOld );				// ==>

	} // _Connection.


	/*===================================================================================
	 *	_Request																		*
	 *==================================================================================*/

	/**
	 * Manage service request.
	 *
	 * This method can be used to set or retrieve the service request.
	 *
	 * It accepts three parameters:
	 *
	 * <ul>
	 *	<li><b>$theIndex</b>: Element index:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Consider the whole property.
	 *		<li><i>other</i>: Any other value will be cast to a string and used as the key
	 *			to the specific property element.
	 *	 </ul>
	 *	<li><b>$theValue</b>: Property element value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return current element or property.
	 *		<li><tt>FALSE</tt>: Delete current element or property.
	 *		<li><i>other</i>: Set element or property with the provided value; when setting
	 *			the whole property, you must provide an array.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theIndex			Request element index.
	 * @param mixed					$theValue			Request element value.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @uses _ManageArrayMember()
	 */
	protected function _Request( $theIndex = NULL, $theValue = NULL, $getOld = FALSE )
	{
		return $this->_ManageArrayMember(
				$this->mRequest, $theIndex, $theValue, $getOld );					// ==>

	} // _Request.


	/*===================================================================================
	 *	_Operation																		*
	 *==================================================================================*/

	/**
	 * Get, set or rettrieve the service operation.
	 *
	 * This method manages the service operation code, it accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: The operation value or method operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current operation value.
	 *		<li><tt>FALSE</tt>: Reset the current operation (defaults to HELP).
	 *		<li><tt>array</tt>: An array indicates that we provided the request and this
	 *			must be parsed to set the requested value.
	 *		<li><i>other</i>: Any other value will be cast to string and interpreted as the
	 *			operation code.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _Operation( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Parse request.
		//
		if( is_array( $theValue ) )
		{
			//
			// Check PING.
			//
			if( array_key_exists( kAPI_OP_PING, $theValue ) )
				$theValue = kAPI_OP_PING;

			//
			// Check HELP.
			//
			elseif( array_key_exists( kAPI_OP_HELP, $theValue ) )
				$theValue = kAPI_OP_HELP;

			//
			// Check TILE.
			//
			elseif( array_key_exists( kAPI_OP_TILE, $theValue ) )
				$theValue = kAPI_OP_TILE;

			//
			// Check CONTAINS.
			//
			elseif( array_key_exists( kAPI_OP_CONTAINS, $theValue ) )
				$theValue = kAPI_OP_CONTAINS;

			//
			// Check INTERSECTS.
			//
			elseif( array_key_exists( kAPI_OP_INTERSECTS, $theValue ) )
				$theValue = kAPI_OP_INTERSECTS;

			//
			// Check NEAR.
			//
			elseif( array_key_exists( kAPI_OP_NEAR, $theValue ) )
				$theValue = kAPI_OP_NEAR;

			//
			// Ignore.
			//
			else
				$theValue = NULL;

		} // Provided request.

		return $this->_ManageMember( $this->mOperation, $theValue, $getOld );		// ==>

	} // _Operation.


	/*===================================================================================
	 *	_Modifiers																		*
	 *==================================================================================*/

	/**
	 * Set retrieve and delete modifiers.
	 *
	 * This method can be used to manage the service modifiers.
	 *
	 * The method accepts three parameters:
	 *
	 * <ul>
	 *	<li><b>$theIndex</b>: Element index:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Consider the whole property.
	 *		<li><tt>array</tt>: An array indicates that we provided the request and this
	 *			must be parsed to set the requested value; in this case the next parameter
	 *			is ignored.
	 *		<li><i>other</i>: Any other value will be cast to a string and used as the key
	 *			to the specific property element.
	 *	 </ul>
	 *	<li><b>$theValue</b>: Property element value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return current element or property.
	 *		<li><tt>FALSE</tt>: Delete current element or property.
	 *		<li><i>other</i>: Any other value means we want to set a new modifier: if the
	 *			index is <tt>NULL</tt>, the value must be an array; if the index is not
	 *			<tt>NULL</tt>, the value will be set to that index to prevent duplicate
	 *			modifiers. 
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * If no command was provided, {@link kAPI_OP_WITHIN} is assumed by default.
	 *
	 * @param string				$theIndex			Modifier index.
	 * @param mixed					$theValue			Modifier value.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return string
	 */
	protected function _Modifiers( $theIndex = NULL, $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle member.
		//
		if( ! is_array( $theIndex ) )
			return $this->_ManageArrayMember(
					$this->mModifiers, $theIndex, $theValue, $getOld );				// ==>

		//
		// Get old modifiers.
		//
		$old = $this->_Modifiers();

		//
		// Check COUNT.
		//
		if( array_key_exists( kAPI_OP_COUNT, $theIndex ) )
			$this->_Modifiers( kAPI_OP_COUNT, TRUE );

		//
		// Check RANGE.
		//
		elseif( array_key_exists( kAPI_OP_RANGE, $theIndex ) )
			$this->_Modifiers( kAPI_OP_RANGE, TRUE );

		//
		// Check REQUEST.
		//
		if( array_key_exists( kAPI_OP_REQUEST, $theIndex ) )
			$this->_Modifiers( kAPI_OP_REQUEST, TRUE );

		//
		// Check CONNECTION.
		//
		if( array_key_exists( kAPI_OP_CONNECTION, $theIndex ) )
			$this->_Modifiers( kAPI_OP_CONNECTION, TRUE );

		//
		// Get current modifiers.
		//
		$new = $this->_Modifiers();

		return ( $getOld ) ? $old													// ==>
						   : $new;													// ==>

	} // _Modifiers.


	/*===================================================================================
	 *	_Geometry																		*
	 *==================================================================================*/

	/**
	 * Handle service geometry.
	 *
	 * This method can be used to manage the service geometry.
	 *
	 * The method accepts three parameters:
	 *
	 * <ul>
	 *	<li><b>$theType</b>: Geometry type:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Retrieve the current geometry; the next parameter will be
	 *			ignored.
	 *		<li><tt>array</tt>: Interpret the parameter as the request.
	 *		<li><i>other</i>: Any other value will be cast to a string and used as the
	 *			geometry type, while the next parameter will be interpreted as the geometry
	 *			value.
	 *	 </ul>
	 *	<li><b>$theValue</b>: Geometry value or coordinates:
	 *	 <ul>
	 *		<li><tt>array</tt>: Geometry coordinates.
	 *		<li><i>other</i>: Any other value will be cast to a string and parsed according
	 *			to the geometry type.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Which value to return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theType			Geometry type or operation.
	 * @param mixed					$theValue			Geometry value.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _Geometry( $theType = NULL, $theValue = NULL, $getOld = FALSE )
	{
		//
		// Return geometry.
		//
		if( $theType === NULL )
			return $this->mGeometry;												// ==>

		//
		// Parse request.
		//
		if( is_array( $theType ) )
		{
			//
			// Check tile.
			//
			if( array_key_exists( kAPI_GEOMETRY_TILE, $theType ) )
				return $this->_Geometry( kAPI_GEOMETRY_TILE,
										 $theType[ kAPI_GEOMETRY_TILE ],
										 $getOld );									// ==>

			//
			// Check point.
			//
			if( array_key_exists( kAPI_GEOMETRY_POINT, $theType ) )
				return $this->_Geometry( kAPI_GEOMETRY_POINT,
										 $theType[ kAPI_GEOMETRY_POINT ],
										 $getOld );									// ==>

			//
			// Check rect.
			//
			if( array_key_exists( kAPI_GEOMETRY_RECT, $theType ) )
				return $this->_Geometry( kAPI_GEOMETRY_RECT,
										 $theType[ kAPI_GEOMETRY_RECT ],
										 $getOld );									// ==>

			//
			// Check polygon.
			//
			if( array_key_exists( kAPI_GEOMETRY_POLY, $theType ) )
				return $this->_Geometry( kAPI_GEOMETRY_POLY,
										 $theType[ kAPI_GEOMETRY_POLY ],
										 $getOld );									// ==>

			return $this->mGeometry;												// ==>

		} // Parsed request.

		//
		// Save geometry.
		//
		$save = $this->mGeometry;

		//
		// Set geometry.
		//
		switch( $type = (string) $theType )
		{
			case kAPI_GEOMETRY_TILE:
				$this->mGeometry = $this->_Tile( $theValue );
				break;

			case kAPI_GEOMETRY_POINT:
				$this->mGeometry = $this->_Point( $theValue );
				break;

			case kAPI_GEOMETRY_RECT:
				$this->mGeometry = $this->_Rect( $theValue );
				break;

			case kAPI_GEOMETRY_POLY:
				$this->mGeometry = $this->_Polygon( $theValue );
				break;

			default:
				throw new Exception
					( "Unable to handle request: "
					 ."unsupported geometry type [$type]." );					// !@! ==>

		} // Parsing type.

		return ( $getOld )
			 ? $save																// ==>
			 : $this->mGeometry;													// ==>

	} // _Geometry.


	/*===================================================================================
	 *	_Area																			*
	 *==================================================================================*/

	/**
	 * Return the area of the current geometry.
	 *
	 * This method can be used to retrieve the area of the current rect or polygon, other
	 * geometry types will return <tt>NULL</tt>.
	 *
	 * This method assumes that the current geometry is set.
	 *
	 * The returned value is in square kilometers.
	 *
	 * @access protected
	 * @return double
	 */
	protected function _Area()
	{
		//
		// Get geometry.
		//
		$geom = $this->_Geometry();
		if( is_array( $geom ) )
		{
			//
			// Handle Rect.
			//
			if( $geom[ 'type' ] == kAPI_GEOMETRY_TYPE_RECT )
				return abs( $geom[ 'coordinates' ][ 1 ][ 0 ]
						  - $geom[ 'coordinates' ][ 0 ][ 0 ] )
					 * abs( $geom[ 'coordinates' ][ 1 ][ 1 ]
					 	  - $geom[ 'coordinates' ][ 0 ][ 1 ] );						// ==>
		
			//
			// Handle polygons.
			//
			if( $geom[ 'type' ] == kAPI_GEOMETRY_TYPE_POLY )
			{
				//
				// Calculate area.
				//
				$total = NULL;
				foreach( $geom[ 'coordinates' ] as $ring )
				{
					//
					// Calculate ring area.
					//
					for( $x = $y = $i = 0;
						 $i < (count( $ring ) - 2);
						 $i++ )
					{
						$x += ($ring[ $i ][ 0 ] * $ring[ $i + 1 ][ 1 ]);
						$y += ($ring[ $i ][ 1 ] * $ring[ $i + 1 ][ 0 ]);
				
					} $area = ($x - $y) / 2;
					
					//
					// Set outer ring area.
					//
					if( $total === NULL )
						$total = $area;
					
					//
					// Handle inner ring area.
					//
					else
						$total -= $area;
				
				} // Iterating rings.
				
				return $total;														// ==>
		
			} // Polygon.
		
		} // Has geometry.
		
		return NULL;																// ==>

	} // _Area.


	/*===================================================================================
	 *	_Elevation																		*
	 *==================================================================================*/

	/**
	 * Get, set or rettrieve the elevation range.
	 *
	 * This method manages the elevation range selector, it accepts the following
	 * parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: The elevation range or method operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current elevation range values.
	 *		<li><tt>FALSE</tt>: Reset the current value (defaults to <tt>NULL</tt>).
	 *		<li><tt>array</tt>: An array indicates that we provided the request and this
	 *			must be parsed to set the requested value.
	 *		<li><i>other</i>: Any other value will be cast to string and interpreted as the
	 *			list of elevation values separated by a comma; only the first two values
	 *			are considered.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * Note that you can only set a new value by either providing the request or a string.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _Elevation( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Parse request.
		//
		if( is_array( $theValue ) )
		{
			//
			// Check ELEVATION.
			//
			if( array_key_exists( kAPI_ENV_ELEVATION, $theValue ) )
				$theValue = $theValue[ kAPI_ENV_ELEVATION ];

			//
			// Ignore.
			//
			else
				$theValue = NULL;

		} // Provided request.

		//
		// Handle string.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Extract.
			//
			$theValue = $this->_List2Array( (string) $theValue );

			//
			// Reduce.
			//
			if( count( $theValue ) > 2 )
				array_splice( $theValue, 2 );

			//
			// Complete.
			//
			elseif( count( $theValue ) == 1 )
				$theValue = array( ((int) $theValue[ 0 ]) - 50,
								   ((int) $theValue[ 0 ]) + 50 );

			//
			// Cast.
			//
			$theValue[ 0 ] = (int) $theValue[ 0 ];
			$theValue[ 1 ] = (int) $theValue[ 1 ];

			//
			// Order.
			//
			if( $theValue[ 0 ] > $theValue[ 1 ] )
			{
				$tmp = $theValue[ 0 ];
				$theValue[ 0 ] = $theValue[ 1 ];
				$theValue[ 1 ] = $tmp;
			}

		} // Provided list.

		return $this->_ManageMember( $this->mElevation, $theValue, $getOld );		// ==>

	} // _Elevation.


	/*===================================================================================
	 *	_Distance																		*
	 *==================================================================================*/

	/**
	 * Get, set or retrieve the maximum distance.
	 *
	 * This method manages the maximum distance value, it accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: The distance in kilometers or method operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current distance.
	 *		<li><tt>FALSE</tt>: Reset the current value (defaults to <tt>NULL</tt>).
	 *		<li><tt>array</tt>: An array indicates that we provided the request and this
	 *			must be parsed to set the requested value.
	 *		<li><i>other</i>: Any other value will be considered the maximum distance.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * The method accepts float and integer distances, any other type will be cast to
	 * float.
	 * 
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _Distance( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Parse request.
		//
		if( is_array( $theValue ) )
		{
			//
			// Check DISTANCE.
			//
			if( array_key_exists( kAPI_GEOMETRY_DISTANCE, $theValue ) )
				$theValue = $theValue[ kAPI_GEOMETRY_DISTANCE ];

			//
			// Ignore.
			//
			else
				$theValue = NULL;

		} // Provided request.

		//
		// Handle value.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Cast.
			//
			if( (! is_int( $theValue ))
			 && (! is_float( $theValue )) )
				$theValue = (double) $theValue;

		} // Provided list.

		return $this->_ManageMember( $this->mDistance, $theValue, $getOld );		// ==>

	} // _Distance.


	/*===================================================================================
	 *	_Start																			*
	 *==================================================================================*/

	/**
	 * Get, set or rettrieve the record start.
	 *
	 * This method manages the service record start, it accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: The record start or method operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current start value.
	 *		<li><tt>FALSE</tt>: Reset the current start (defaults to 0).
	 *		<li><tt>array</tt>: An array indicates that we provided the request and this
	 *			must be parsed to set the requested value.
	 *		<li><i>other</i>: Any other value will be cast to integer and interpreted as the
	 *			record start.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _Start( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Parse request.
		//
		if( is_array( $theValue ) )
		{
			//
			// Check request.
			//
			if( array_key_exists( kAPI_PAGE_START, $theValue ) )
				$theValue = (int) $theValue[ kAPI_PAGE_START ];

			//
			// Ignore.
			//
			else
				$theValue = NULL;

		} // Provided request.

		return $this->_ManageMember( $this->mStart, $theValue, $getOld );			// ==>

	} // _Start.


	/*===================================================================================
	 *	_Limit																			*
	 *==================================================================================*/

	/**
	 * Get, set or rettrieve the maximum record count.
	 *
	 * This method manages the service maximum record count, it accepts the following
	 * parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: The maximum record count or method operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current maximum record count value.
	 *		<li><tt>FALSE</tt>: Reset the current maximum record count (defaults to
	 *			{@link kAPI_DEFAULT_LIMIT}.
	 *		<li><tt>array</tt>: An array indicates that we provided the request and this
	 *			must be parsed to set the requested value.
	 *		<li><i>other</i>: Any other value will be cast to integer and interpreted as the
	 *			maximum record count.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * If the {@link _Start()} parameter was provided and this onitted, the value will be
	 * set to {@link kAPI_DEFAULT_LIMIT}.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _Limit( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Parse request.
		//
		if( is_array( $theValue ) )
		{
			//
			// Check request.
			//
			if( array_key_exists( kAPI_PAGE_LIMIT, $theValue ) )
				$theValue = (int) $theValue[ kAPI_PAGE_LIMIT ];

			//
			// Set default.
			//
			elseif( $this->_Start() !== NULL )
				$theValue = kAPI_DEFAULT_LIMIT;

			//
			// Ignore.
			//
			else
				$theValue = NULL;

		} // Provided request.

		return $this->_ManageMember( $this->mLimit, $theValue, $getOld );			// ==>

	} // _Limit.


    /*===================================================================================
     *	_Selection																		*
     *==================================================================================*/

    /**
     * Set retrieve and delete properties selection.
     *
     * This method can be used to manage the service properties selection.
     *
     * The method accepts three parameters:
     *
     * <ul>
     *	<li><b>$theIndex</b>: Element index:
     *	 <ul>
     *		<li><tt>NULL</tt>: Consider the whole property.
     *		<li><tt>array</tt>: An array indicates that we provided the request and this
     *			must be parsed to set the requested values; in this case the next parameter
     *			is ignored.
     *		<li><i>other</i>: Any other value will be cast to a string and used as the key
     *			to the specific property element.
     *	 </ul>
     *	<li><b>$theValue</b>: Property element value or operation:
     *	 <ul>
     *		<li><tt>NULL</tt>: Return current element or property switch value.
     *		<li><tt>FALSE</tt>: Delete current element or property.
     *		<li><i>other</i>: Any other value means we want to set a new modifier: if the
     *			index is <tt>NULL</tt>, the value must be an array; if the index is not
     *			<tt>NULL</tt>, the value will be cast to a boolean value that will represent
     *          the switch value.
     *	 </ul>
     *	<li><tt>$getOld</tt>: Which value to return:
     *	 <ul>
     *		<li><tt>TRUE</tt>: <i>Before</i> it was eventually modified.
     *		<li><tt>FALSE</tt>: <i>After</i> it was eventually modified (DEFAULT).
     *	 </ul>
     * </ul>
     *
     * @param string				$theIndex			Property tag.
     * @param mixed					$theValue			Property selection switch.
     * @param boolean				$getOld				TRUE get old value.
     *
     * @access protected
     * @return string
     */
    protected function _Selection( $theIndex = NULL, $theValue = NULL, $getOld = FALSE )
    {
		//
	    // Parse request.
	    //
	    if( is_array( $theIndex ) )
	    {
		    //
		    // Check for parameter.
		    //
		    if( array_key_exists( kAPI_ENV_SELECTION, $theIndex ) )
		    {
			    //
			    // Init local storage.
			    //
			    $selection = Array();

			    //
			    // Parse parameter blocks.
			    //
			    $blocks = explode( ';', $theIndex[ kAPI_ENV_SELECTION ] );
			    foreach( $blocks as $block )
			    {
				    //
				    // Parse parameter.
				    //
				    $tmp = explode( ',', $block );
				    if( count( $tmp ) == 2 )
				    {
					    //
					    // Trim.
					    //
					    $tmp[ 0 ] = trim( $tmp[ 0 ] );
					    $tmp[ 1 ] = trim( $tmp[ 1 ] );

					    //
					    // Check if not empty.
					    //
					    if( strlen( $tmp[ 0 ] )
					     && strlen( $tmp[ 1 ] ) )
							$selection[ $tmp[ 0 ] ] = (boolean) $tmp[ 1 ];

				    } // At least a parameter/switch block.

			    } // Iterating parameter blocks.

			    //
			    // Set member.
			    //
			    if( count( $selection ) )
				    return $this->_ManageArrayMember(
					    $this->mSelection, NULL, $selection, $getOld );     	// ==>

		    } // Found parameter.

		    return $this->_ManageArrayMember(
				$this->mSelection, NULL, NULL, $getOld );                      // ==>

	    } // Provided request.

        return $this->_ManageArrayMember(
            $this->mSelection, $theIndex, $theValue, $getOld );             	// ==>

    } // _Selection.



/*=======================================================================================
 *																						*
 *								PROTECTED HANDLER INTERFACE								*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_RequestPing																	*
	 *==================================================================================*/

	/**
	 * Handle ping service.
	 *
	 * This method will respond with the status and any other parameter.
	 *
	 * @access protected
	 */
	protected function _RequestPing()
	{
		$this->_BuildResponse( 'pong' );

	} // _RequestPing.


	/*===================================================================================
	 *	_RequestHelp																	*
	 *==================================================================================*/

	/**
	 * Handle help service.
	 *
	 * This method will return an HTML help page.
	 *
	 * @access protected
	 */
	protected function _RequestHelp()
	{
		header( 'Location: help/index.html' ) ;
		exit;

	} // _RequestHelp.


	/*===================================================================================
	 *	_RequestTile																	*
	 *==================================================================================*/

	/**
	 * Handle tile service.
	 *
	 * This method will return all tiles matching the provided identifiers list in the
	 * geometry.
	 *
	 * @access protected
	 */
	protected function _RequestTile()
	{
		//
		// Check geometry.
		//
		if( ($geometry = $this->_Geometry()) !== NULL )
		{
			//
			// Parse by geometry.
			//
			switch( $type = $geometry[ 'type' ] )
			{
				case kAPI_GEOMETRY_TYPE_TILE:
					break;

				default:
					throw new Exception
						( "Unable to handle request: "
						 ."invalid geometry type [$type] for operation." );		// !@! ==>

			} // Checked geometry.

			//
			// Init query.
			//
			$query = array( kAPI_DATA_ID => array( '$in' => $geometry[ 'coordinates' ] ) );

			//
			// Add elevation.
			//
			if( ($elevation = $this->_Elevation()) !== NULL )
				$query[ kAPI_DATA_ELEVATION ]
					= array( '$gte' => $elevation[ 0 ],
							 '$lte' => $elevation[ 1 ] );

			//
			// Perform aggregate.
			//
			if( $this->_Modifiers( kAPI_OP_RANGE ) !== NULL )
			{
				//
				// Init pipeline.
				//
				$pipeline = Array();

				//
				// Add query.
				//
				$this->_AggregateMatch( $pipeline, $query );

				//
				// Add initial project.
				//
				$this->_AggregateStart( $pipeline, $query );

				//
				// Add group.
				//
				$this->_AggregateGroup( $pipeline );

				//
				// Add output project.
				//
				$this->_AggregateEnd( $pipeline );

				//
				// Perform aggregation.
				//
			//	$results = $this->Collection()->aggregate( $pipeline );
				$results
					= $this->Database()
						->command(
							array( 'aggregate' => kDEFAULT_COLLECTION,
								   'pipeline' => $pipeline ),
							array( 'timeout' => kDEFAULT_TIMEOUT ) );
				if( $results[ 'ok' ] )
				{
					//
					// Handle results.
					//
					if( array_key_exists( 'result', $results ) )
					{
						//
						// Set results.
						//
						$results = $results[ 'result' ];

						//
						// Found results.
						//
						if( count( $results ) )
						{
							//
							// Use first element.
							//
							$results = $results[ 0 ];

							//
							// Set total.
							//
							$this->_Status( kAPI_STATUS_TOTAL, $results[ kAPI_AGGREGATE_COUNT ] );
							unset( $results[ kAPI_AGGREGATE_COUNT ] );

							//
							// Round values.
							//
							$values = array( kAPI_DATA_ELEVATION, kAPI_DATA_DISTANCE );
							foreach( $values as $value )
							{
								//
								// Check value.
								//
								if( array_key_exists( $value, $results ) )
								{
									//
									// Round ranges.
									//
									$keys = array( kAPI_AGGREGATE_MINIMUM,
										kAPI_AGGREGATE_MEAN,
										kAPI_AGGREGATE_MAXIMUM );
									foreach( $keys as $key )
										$results[ $value ][ $key ]
											= (int) round( $results[ $value ][ $key ] );
								}
							}

						} // Found results.

						else
							$this->_Status( kAPI_STATUS_TOTAL, 0 );

					} // Received results.

					else
						$this->_Status( kAPI_STATUS_TOTAL, 0 );
					
					//
					// Filter empty elements.
					//
					$ref = & $results[ kAPI_DATA_CLIMATE ];
					$ref = & $ref[ '2000' ];
					if( ! count( $ref[ kAPI_DATA_CLIMATE_HWSD ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_HWSD ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GHF ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GHF ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GCOV ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GCOV ] );

					//
					// Set results.
					//
					$this->_BuildResponse( $results );

				} // Successful.

			} // Aggregation.

			//
			// Perform query.
			//
			else
			{
				//
				// Perform query.
				//
				$results = $this->Collection()->find( $query, $this->_Selection() );

				//
				// Set total.
				//
				$this->_Status( kAPI_STATUS_TOTAL, $results->count( FALSE ) );

				//
				// Handle count.
				//
				if( $this->_Modifiers( kAPI_OP_COUNT ) !== NULL )
					$this->_BuildResponse();

				//
				// Load results.
				//
				else
				{
					//
					// Skip to start.
					//
					if( ($start = $this->_Start()) !== NULL )
					{
						$this->_Status( kAPI_STATUS_START, $start );
						if( $start )
							$results->skip( $start );

					} // Provided start.

					//
					// Set limit.
					//
					if( ($limit = $this->_Limit()) !== NULL )
					{
						$this->_Status( kAPI_STATUS_LIMIT, $limit );
						$results->limit( $limit );

					} // Provided start.

					//
					// Set count.
					//
					if( $start || $limit )
						$this->_Status( kAPI_STATUS_COUNT, $results->count( TRUE ) );

					//
					// Set results.
					//
					$this->_BuildResponse( iterator_to_array( $results ) );

				} // Not a count.

			} // Regular query

		} // Provided geometry.

		else
			throw new Exception
				( "Unable to handle request: "
				 ."missing tiles list." );										// !@! ==>

	} // _RequestTile.


	/*===================================================================================
	 *	_RequestContains																*
	 *==================================================================================*/

	/**
	 * Handle contains service.
	 *
	 * This method will return the tile that contains the provided point, or all tiles
	 * contained by the provided rect or polygon.
	 *
	 * If you provide a point this will be converted to a sphere, if also the distance was
	 * provided, or to a rect extending 15 seconds in all sides if no distance was provided.
	 *
	 * @access protected
	 */
	protected function _RequestContains()
	{
		//
		// Check geometry.
		//
		if( ($geometry = $this->_Geometry()) !== NULL )
		{
			//
			// Init local storage.
			//
			$do_limits
				= ! ( $this->_Modifiers( kAPI_OP_COUNT )
				   || $this->_Modifiers( kAPI_OP_RANGE ) );

			//
			// Parse by geometry.
			//
			switch( $type = $geometry[ 'type' ] )
			{
				case kAPI_GEOMETRY_TYPE_POINT:
					if( ($dist = $this->_Distance()) !== NULL )
						$geometry = $this->_Point2Sphere( $geometry, $dist );
					else
					{
						$geometry = $this->_Point2Rect( $geometry );
						$geometry = $this->_Rect2Polygon( $geometry );
					}
					break;

				case kAPI_GEOMETRY_TYPE_RECT:
					$geometry = $this->_Rect2Polygon( $geometry );

				case kAPI_GEOMETRY_TYPE_POLY:
					break;

				default:
					throw new Exception
						( "Unable to handle request: "
						 ."invalid geometry type [$type] for operation." );		// !@! ==>

			} // Checked geometry.

			//
			// Enforce limits.
			// Note that we do not enforce limits if the provided geometry is a point.
			//
			if( $do_limits
			 && ($type != kAPI_GEOMETRY_TYPE_POINT) )
			{
				//
				// Get limits.
				//
				$start = $this->_Start();
				$limit = $this->_Limit();

				//
				// Enforce limits.
				//
				if( $start === NULL )
					$start = $this->_Start( 0 );
				if( $limit === NULL )
				{
					$this->_Status( kAPI_STATUS_MESSAGE, 'Enforced paging.' );
					$limit = $this->_Limit( kAPI_DEFAULT_LIMIT );
				}

				//
				// Check limits.
				//
				if( $limit > kAPI_DEFAULT_LIMIT )
				{
					$this->_Status( kAPI_STATUS_MESSAGE, 'Reduced limit to default.' );
					$limit = $this->_Limit( kAPI_DEFAULT_LIMIT );
					$this->_Limit( $limit );
				}

			} // Not counting.

			//
			// Init query.
			//
			$query = ( isset( $dist ) )
				   ? array( kAPI_DATA_POINT =>
						array( '$geoWithin' =>
							array( '$centerSphere' => $geometry ) ) )
				   : array( kAPI_DATA_POINT =>
						array( '$geoWithin' =>
							array( '$geometry' => $geometry ) ) );

			//
			// Add elevation.
			//
			if( ($elevation = $this->_Elevation()) !== NULL )
				$query[ kAPI_DATA_ELEVATION ]
					= array( '$gte' => $elevation[ 0 ],
							 '$lte' => $elevation[ 1 ] );

			//
			// Aggregate.
			//
			if( $this->_Modifiers( kAPI_OP_RANGE ) !== NULL )
			{
				//
				// Init pipeline.
				//
				$pipeline = Array();

				//
				// Add query.
				//
				$this->_AggregateMatch( $pipeline, $query );

				//
				// Add initial project.
				//
				$this->_AggregateStart( $pipeline, $query );

				//
				// Add group.
				//
				$this->_AggregateGroup( $pipeline );

				//
				// Add output project.
				//
				$this->_AggregateEnd( $pipeline );

				//
				// Perform aggregation.
				//
				$results = $this->Collection()->aggregate( $pipeline );
				if( $results[ 'ok' ] )
				{
					//
					// Set results.
					//
					if( array_key_exists( 'result', $results )
					 && count( $results[ 'result' ] ) )
						$results = $results[ 'result' ][ 0 ];
					else
						$results = Array();

					//
					// Set total.
					//
					if( count( $results ) )
					{
						$this->_Status( kAPI_STATUS_TOTAL,
										$results[ kAPI_AGGREGATE_COUNT ] );
						unset( $results[ kAPI_AGGREGATE_COUNT ] );
					}
					else
						$this->_Status( kAPI_STATUS_TOTAL, 0 );

					//
					// Round values.
					//
					$values = array( kAPI_DATA_ELEVATION, kAPI_DATA_DISTANCE );
					foreach( $values as $value )
					{
						//
						// Check value.
						//
						if( array_key_exists( $value, $results ) )
						{
							//
							// Round ranges.
							//
							$keys = array( kAPI_AGGREGATE_MINIMUM,
								kAPI_AGGREGATE_MEAN,
								kAPI_AGGREGATE_MAXIMUM );
							foreach( $keys as $key )
								$results[ $value ][ $key ]
									= (int) round( $results[ $value ][ $key ] );
						}
					}
					
					//
					// Filter empty elements.
					//
					$ref = & $results[ kAPI_DATA_CLIMATE ];
					$ref = & $ref[ '2000' ];
					if( ! count( $ref[ kAPI_DATA_CLIMATE_HWSD ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_HWSD ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GHF ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GHF ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GCOV ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GCOV ] );

					//
					// Set results.
					//
					$this->_BuildResponse( $results );

				} // Successful.

			} // Aggregate.

			//
			// Query.
			//
			else
			{
				//
				// Perform query.
				//
				$results = $this->Collection()->find( $query, $this->_Selection() );

				//
				// Set total.
				//
				$this->_Status( kAPI_STATUS_TOTAL, $results->count( FALSE ) );

				//
				// Handle count.
				//
				if( $this->_Modifiers( kAPI_OP_COUNT ) !== NULL )
					$this->_BuildResponse();

				//
				// Load results.
				//
				else
				{
					//
					// Handle limits.
					// Note that we do not enforce limits if the provided geometry is a point.
					//
					if( $do_limits
					 && ($type != kAPI_GEOMETRY_TYPE_POINT) )
					{
						//
						// Skip to start.
						//
						$this->_Status( kAPI_STATUS_START, $start );
						if( $start )
							$results->skip( $start );

						//
						// Set limit.
						//
						$this->_Status( kAPI_STATUS_LIMIT, $limit );
						$results->limit( $limit );

						//
						// Set count.
						//
						$this->_Status( kAPI_STATUS_COUNT, $results->count( TRUE ) );

					} // Not a count, aggregate or provided point.

					//
					// Set results.
					//
					$this->_BuildResponse( iterator_to_array( $results ) );

				} // Not a count.

			} // Query.

		} // Provided geometry.

		else
			throw new Exception
				( "Unable to handle request: "
				 ."missing geometry." );										// !@! ==>

	} // _RequestContains.


	/*===================================================================================
	 *	_RequestIntersects																*
	 *==================================================================================*/

	/**
	 * Handle intersects service.
	 *
	 * This method will return the tiles that intersect with the provided geometry.
	 *
	 * If you provide a point this will be converted to a rect, if no distance was provided,
	 * the rect will extend 15 seconds in all directions, if the distance was provided, the
	 * rect will span that distance in all directions from the provided point..
	 *
	 * @access protected
	 */
	protected function _RequestIntersects()
	{
		//
		// Check geometry.
		//
		if( ($geometry = $this->_Geometry()) !== NULL )
		{
			//
			// Init local storage.
			//
			$do_limits
				= ! ( $this->_Modifiers( kAPI_OP_COUNT )
				|| $this->_Modifiers( kAPI_OP_RANGE ) );

			//
			// Parse by geometry.
			//
			switch( $type = $geometry[ 'type' ] )
			{
				case kAPI_GEOMETRY_TYPE_POINT:
					$geometry = $this->_Point2Rect( $geometry, $this->_Distance() );

				case kAPI_GEOMETRY_TYPE_RECT:
					$geometry = $this->_Rect2Polygon( $geometry );

				case kAPI_GEOMETRY_TYPE_POLY:
					break;

				default:
					throw new Exception
						( "Unable to handle request: "
						 ."invalid geometry type [$type] for operation." );		// !@! ==>

			} // Checked geometry.

			//
			// Enforce limits.
			// Note that we do not enforce limits if the provided geometry is a point.
			//
			if( $do_limits
			 && ($type != kAPI_GEOMETRY_TYPE_POINT) )
			{
				//
				// Get limits.
				//
				$start = $this->_Start();
				$limit = $this->_Limit();

				//
				// Enforce limits.
				//
				if( $start === NULL )
					$start = $this->_Start( 0 );
				if( $limit === NULL )
				{
					$this->_Status( kAPI_STATUS_MESSAGE, 'Enforced paging.' );
					$limit = $this->_Limit( kAPI_DEFAULT_LIMIT );
				}

				//
				// Check limits.
				//
				if( $limit > kAPI_DEFAULT_LIMIT )
				{
					$this->_Status( kAPI_STATUS_MESSAGE, 'Reduced limit to default.' );
					$limit = $this->_Limit( kAPI_DEFAULT_LIMIT );
					$this->_Limit( $limit );
				}

			} // Not counting.

			//
			// Init query.
			//
			$query = array( kAPI_DATA_POINT =>
						array( '$geoIntersects' =>
							array( '$geometry' => $geometry ) ) );

			//
			// Add elevation.
			//
			if( ($elevation = $this->_Elevation()) !== NULL )
				$query[ kAPI_DATA_ELEVATION ]
					= array( '$gte' => $elevation[ 0 ],
							 '$lte' => $elevation[ 1 ] );

			//
			// Aggregate.
			//
			if( $this->_Modifiers( kAPI_OP_RANGE ) !== NULL )
			{
				//
				// Init pipeline.
				//
				$pipeline = Array();

				//
				// Add query.
				//
				$this->_AggregateMatch( $pipeline, $query );

				//
				// Add initial project.
				//
				$this->_AggregateStart( $pipeline, $query );

				//
				// Add group.
				//
				$this->_AggregateGroup( $pipeline );

				//
				// Add output project.
				//
				$this->_AggregateEnd( $pipeline );

				//
				// Perform aggregation.
				//
				$results = $this->Collection()->aggregate( $pipeline );
				if( $results[ 'ok' ] )
				{
					//
					// Set results.
					//
					$results = ( array_key_exists( 'result', $results ) )
						? $results[ 'result' ][ 0 ]
						: Array();

					//
					// Set total.
					//
					$this->_Status( kAPI_STATUS_TOTAL, $results[ kAPI_AGGREGATE_COUNT ] );
					unset( $results[ kAPI_AGGREGATE_COUNT ] );

					//
					// Round values.
					//
					$values = array( kAPI_DATA_ELEVATION, kAPI_DATA_DISTANCE );
					foreach( $values as $value )
					{
						//
						// Check value.
						//
						if( array_key_exists( $value, $results ) )
						{
							//
							// Round ranges.
							//
							$keys = array( kAPI_AGGREGATE_MINIMUM,
								kAPI_AGGREGATE_MEAN,
								kAPI_AGGREGATE_MAXIMUM );
							foreach( $keys as $key )
								$results[ $value ][ $key ]
									= (int) round( $results[ $value ][ $key ] );
						}
					}
					
					//
					// Filter empty elements.
					//
					$ref = & $results[ kAPI_DATA_CLIMATE ];
					$ref = & $ref[ '2000' ];
					if( ! count( $ref[ kAPI_DATA_CLIMATE_HWSD ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_HWSD ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GHF ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GHF ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GCOV ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GCOV ] );

					//
					// Set results.
					//
					$this->_BuildResponse( $results );

				} // Successful.

			} // Aggregate.

			//
			// Query.
			//
			else
			{
				//
				// Perform query.
				//
				$results = $this->Collection()->find( $query, $this->_Selection() );

				//
				// Set total.
				//
				$this->_Status( kAPI_STATUS_TOTAL, $results->count( FALSE ) );

				//
				// Handle count.
				//
				if( $this->_Modifiers( kAPI_OP_COUNT ) !== NULL )
					$this->_BuildResponse();

				//
				// Load results.
				//
				else
				{
					//
					// Handle limits.
					// Note that we do not enforce limits if the provided geometry is a point.
					//
					if( $do_limits
					 && ($type != kAPI_GEOMETRY_TYPE_POINT) )
					{
						//
						// Skip to start.
						//
						$this->_Status( kAPI_STATUS_START, $start );
						if( $start )
							$results->skip( $start );

						//
						// Set limit.
						//
						$this->_Status( kAPI_STATUS_LIMIT, $limit );
						$results->limit( $limit );

						//
						// Set count.
						//
						$this->_Status( kAPI_STATUS_COUNT, $results->count( TRUE ) );

					} // Not a count, aggregate or provided point.

					//
					// Set results.
					//
					$this->_BuildResponse( iterator_to_array( $results ) );

				} // Not a count.

			} // Query.

		} // Provided geometry.

		else
			throw new Exception
				( "Unable to handle request: "
				 ."missing geometry." );										// !@! ==>

	} // _RequestIntersects.


	/*===================================================================================
	 *	_RequestNear																	*
	 *==================================================================================*/

	/**
	 * Handle in service.
	 *
	 * This method will return the tile that contains the provided point, or all tiles
	 * contained by the provided rect or polygon.
	 *
	 * @access protected
	 */
	protected function _RequestNear()
	{
		//
		// Check geometry.
		//
		if( ($geometry = $this->_Geometry()) !== NULL )
		{
			//
			// Init local storage.
			//
			$do_limits
				= ! ( $this->_Modifiers( kAPI_OP_COUNT )
				|| $this->_Modifiers( kAPI_OP_RANGE ) );

			//
			// Parse by geometry.
			//
			switch( $type = $geometry[ 'type' ] )
			{
				case kAPI_GEOMETRY_TYPE_POINT:
					break;

				default:
					throw new Exception
						( "Unable to handle request: "
						 ."invalid geometry type [$type] for operation." );		// !@! ==>

			} // Checked geometry.

			//
			// Init operation.
			//
			$query = array(
				'includeLocs' => kAPI_DATA_POINT,
				'near' => $geometry[ 'coordinates' ],
				'spherical' => TRUE,
				'distanceMultiplier' => self::kDistMult,
				'distanceField' => kAPI_DATA_DISTANCE );

			//
			// Enforce limits.
			//
			if( $do_limits )
			{
				//
				// Reset start.
				//
				$this->_Start( FALSE );

				//
				// Get limits.
				//
				$limit = $this->_Limit();
				if( $limit === NULL )
				{
					$this->_Status( kAPI_STATUS_MESSAGE, 'Enforced paging.' );
					$limit = $this->_Limit( kAPI_DEFAULT_LIMIT );
				}

				//
				// Check limits.
				//
				if( $limit > kAPI_DEFAULT_LIMIT )
				{
					$this->_Status( kAPI_STATUS_MESSAGE, 'Reduced limit to default.' );
					$limit = $this->_Limit( kAPI_DEFAULT_LIMIT );
					$this->_Limit( $limit );
				}
				
				//
				// Set limit.
				//
				$query[ 'limit' ] = $limit;

			} // Not counting.

			//
			// Add distance.
			//
			if( ($tmp = $this->_Distance()) !== NULL )
				$query[ 'maxDistance' ] = ($tmp / self::kDistMult);

			//
			// Add elevation.
			//
			if( ($tmp = $this->_Elevation()) !== NULL )
			{
				if( ! array_key_exists( 'query', $query ) )
					$query[ 'query' ] = Array();
				$query[ 'query' ][ kAPI_DATA_ELEVATION ]
					= array( '$gte' => $tmp[ 0 ],
							 '$lte' => $tmp[ 1 ] );
			}

			//
			// Init pipeline.
			//
			$pipeline = Array();

			//
			// Add match block.
			//
			$this->_AggregateNear( $pipeline, $query );

			//
			// Aggregate results.
			//
			if( $this->_Modifiers( kAPI_OP_RANGE ) !== NULL )
			{
				//
				// Add initial project.
				//
				$this->_AggregateStart( $pipeline, TRUE );

				//
				// Add group.
				//
				$this->_AggregateGroup( $pipeline, TRUE );

				//
				// Add output project.
				//
				$this->_AggregateEnd( $pipeline, TRUE );

				//
				// Perform query.
				//
			//	$results = $this->Collection()->aggregate( $pipeline );
				$results
					= $this->Database()
						->command(
							array( 'aggregate' => kDEFAULT_COLLECTION,
								   'pipeline' => $pipeline ),
							array( 'socketTimeoutMS' => kDEFAULT_TIMEOUT ) );
				if( $results[ 'ok' ] )
				{
					//
					// Set results.
					//
					if( array_key_exists( 'result', $results ) )
						$results = ( count( $results[ 'result' ] ) )
								 ? $results[ 'result' ][ 0 ]
								 : Array();
					else
						$results = Array();
					
					//
					// Handle results.
					//
					if( count( $results ) )
					{
						//
						// Set total.
						//
						$this->_Status( kAPI_STATUS_TOTAL,
										$results[ kAPI_AGGREGATE_COUNT ] );
						unset( $results[ kAPI_AGGREGATE_COUNT ] );

						//
						// Round values.
						//
						$values = array( kAPI_DATA_ELEVATION, kAPI_DATA_DISTANCE );
						foreach( $values as $value )
						{
							//
							// Check value.
							//
							if( array_key_exists( $value, $results ) )
							{
								//
								// Round ranges.
								//
								$keys = array( kAPI_AGGREGATE_MINIMUM,
											   kAPI_AGGREGATE_MEAN,
											   kAPI_AGGREGATE_MAXIMUM );
								foreach( $keys as $key )
									$results[ $value ][ $key ]
										= (int) round( $results[ $value ][ $key ] );
							}
						}
					}
					
					//
					// Filter empty elements.
					//
					$ref = & $results[ kAPI_DATA_CLIMATE ];
					$ref = & $ref[ '2000' ];
					if( ! count( $ref[ kAPI_DATA_CLIMATE_HWSD ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_HWSD ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GHF ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GHF ] );
					if( ! count( $ref[ kAPI_DATA_CLIMATE_GCOV ] ) )
						unset( $ref[ kAPI_DATA_CLIMATE_GCOV ] );

					//
					// Set results.
					//
					$this->_BuildResponse( $results );

				} // Successful query.

			} // Aggregate results.

			//
			// Regular query.
			//
			else
			{
				//
				// Perform query.
				//
				$results = $this->Collection()->aggregate( $pipeline );
				if( $results[ 'ok' ] )
				{
					//
					// Set results.
					//
					$results = ( array_key_exists( 'result', $results ) )
						? $results[ 'result' ]
						: Array();

					//
					// Set total.
					//
					$this->_Status( kAPI_STATUS_TOTAL, count( $results ) );

					//
					// Handle count.
					//
					if( $this->_Modifiers( kAPI_OP_COUNT ) !== NULL )
						$this->_BuildResponse();

					//
					// Load results.
					//
					else
					{
						//
						// Round distances.
						//
						$keys = array_keys( $results );
						foreach( $keys as $key )
							$results[ $key ][ kAPI_DATA_DISTANCE ]
								= (int) round( $results[ $key ][ kAPI_DATA_DISTANCE ] );

						//
						// Set limit.
						//
						$this->_Status( kAPI_STATUS_LIMIT, $limit );

						//
						// Set count.
						//
						$this->_Status( kAPI_STATUS_COUNT, count( $results ) );

						//
						// Set results.
						//
						$this->_BuildResponse( $results );

					} // Not a count.

				} // Successful query.

			} // Regular query.

		} // Provided geometry.

		else
			throw new Exception
				( "Unable to handle request: "
				 ."missing geometry." );										// !@! ==>

	} // _RequestNear.



/*=======================================================================================
 *																						*
 *								PROTECTED AGGREGATE INTERFACE							*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_AggregateMatch																	*
	 *==================================================================================*/

	/**
	 * Add match to pipeline.
	 *
	 * This method will add the provided match query to the provided pipeline.
	 *
	 * The method expects the provided pipeline to be an array.
	 *
	 * @param array				   &$thePipeline		Request pipeline.
	 * @param array					$theQuery			Request query.
	 *
	 * @access protected
	 */
	protected function _AggregateMatch( &$thePipeline, $theQuery = Array() )
	{
		//
		// Add match to pipeline.
		//
		if( count( $theQuery ) )
			$thePipeline[] = array( '$match' => $theQuery );

	} // _AggregateMatch.


	/*===================================================================================
	 *	_AggregateNear																	*
	 *==================================================================================*/

	/**
	 * Add geoNear match to pipeline.
	 *
	 * This method will add the provided geoNear match query block to the provided pipeline.
	 *
	 * The method expects the provided pipeline to be an array.
	 *
	 * @param array				   &$thePipeline		Request pipeline.
	 * @param array					$theQuery			Request query.
	 *
	 * @access protected
	 */
	protected function _AggregateNear( &$thePipeline, $theQuery = Array() )
	{
		//
		// Add match to pipeline.
		//
		if( count( $theQuery ) )
			$thePipeline[] = array( '$geoNear' => $theQuery );

	} // _AggregateNear.


	/*===================================================================================
	 *	_AggregateStart																	*
	 *==================================================================================*/

	/**
	 * Select relevant fields for pipeline.
	 *
	 * This method will add the initial project to the provided pipeline, this operation
	 * will select only the relevant fields that will go through the pipeline:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_DATA_ELEVATION}</tt>: Elevation, values range.
	 *	<li><tt>{@link kAPI_DATA_DISTANCE}</tt>: Distance, values range (this only if the
	 *      second parameter is <tt>TRUE</tt>.
	 *	<li><tt>{@link kAPI_DATA_CLIMATE_GENS}</tt>: Global environment stratification,
	 *		distinct values.
	 *	<li><tt>{@link kAPI_DATA_CLIMATE_GENS}</tt>: Global environment stratification,
	 *		distinct values.
	 *	<li><tt>{@link kAPI_DATA_CLIMATE_BIO}</tt>: Bioclimatic variables, values range.
	 *	<li><tt>{@link kAPI_DATA_CLIMATE_PREC}</tt>: Precipitation, values range.
	 *	<li><tt>{@link kAPI_DATA_CLIMATE_TEMP}</tt>: Temperature, values range.
	 * </ul>
	 *
	 * The method expects the provided pipeline to be an array.
	 *
	 * @param array				   &$thePipeline		Request pipeline.
	 * @param boolean		        $doDistance 		Add distance.
	 *
	 * @access protected
	 */
	protected function _AggregateStart( &$thePipeline, $doDistance = FALSE )
	{
		//
		// Init local storage.
		//
		$pipeline = Array();

		//
		// Add elevation.
		//
		$pipeline[ kAPI_DATA_ELEVATION ] = 1;

		//
		// Add distance.
		//
		if( $doDistance )
			$pipeline[ kAPI_DATA_DISTANCE ] = 1;

		//
		// Add global environment stratification.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_GENS ] = 1;

		//
		// Add harmonized world soil database.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_HWSD ] = 1;

		//
		// Add global human footprint.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_GHF ] = 1;

		//
		// Add cover 2009.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_GCOV ] = 1;

		//
		// Add bioclimatic variables.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_BIO ] = 1;

		//
		// Add precipitation.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_PREC ] = 1;

		//
		// Add temperature.
		//
		$pipeline[ 'clim.2000.'.kAPI_DATA_CLIMATE_TEMP ] = 1;

		//
		// Add to pipeline.
		//
		$thePipeline[] = array( '$project' => $pipeline );

	} // _AggregateStart.


	/*===================================================================================
	 *	_AggregateGroup																	*
	 *==================================================================================*/

	/**
	 * Add group to pipeline.
	 *
	 * This method will add the group to the provided pipeline.
	 *
	 * The method expects the provided pipeline to be an array.
	 *
	 * @param array				   &$thePipeline		Request pipeline.
	 * @param boolean		        $doDistance 		Add distance.
	 *
	 * @access protected
	 */
	protected function _AggregateGroup( &$thePipeline, $doDistance = FALSE )
	{
		//
		// Init local storage.
		//
		$pipeline = Array();
		$gens_struct = array( 'id', 'c', 'e' );
		$range_struct = array( kAPI_AGGREGATE_MINIMUM=> '$min',
							   kAPI_AGGREGATE_MEAN => '$avg',
							   kAPI_AGGREGATE_MAXIMUM => '$max' );

		//
		// Add identifier.
		//
		$pipeline[ kAPI_DATA_ID ] = 1;

		//
		// Add count.
		//
		$pipeline[ kAPI_AGGREGATE_COUNT ] = array( '$sum' => 1 );

		//
		// Add elevation.
		//
		foreach( $range_struct as $tag => $cmd )
			$pipeline[ kAPI_DATA_ELEVATION.'_'.$tag ]
				= array( $cmd => '$'.kAPI_DATA_ELEVATION );

		//
		// Add distance.
		//
		if( $doDistance )
		{
			foreach( $range_struct as $tag => $cmd )
				$pipeline[ kAPI_DATA_DISTANCE.'_'.$tag ]
					= array( $cmd => '$'.kAPI_DATA_DISTANCE );
		}

		//
		// Add global environment stratification.
		//
		foreach( $gens_struct as $tag )
			$pipeline[ kAPI_DATA_CLIMATE_GENS.'_'.$tag ]
				= array( '$addToSet' => '$clim.2000.'.kAPI_DATA_CLIMATE_GENS.'.'.$tag );

		//
		// Add harmonized world soil database.
		//
		$pipeline[ kAPI_DATA_CLIMATE_HWSD ]
			= array( '$addToSet' => '$clim.2000.'.kAPI_DATA_CLIMATE_HWSD );

		//
		// Add global human footprint.
		//
		$pipeline[ kAPI_DATA_CLIMATE_GHF ]
			= array( '$addToSet' => '$clim.2000.'.kAPI_DATA_CLIMATE_GHF );

		//
		// Add global cover 2009.
		//
		$pipeline[ kAPI_DATA_CLIMATE_GCOV ]
			= array( '$addToSet' => '$clim.2000.'.kAPI_DATA_CLIMATE_GCOV );

		//
		// Add bioclimatic variables.
		//
		for( $idx = 1; $idx < 20; $idx++ )
		{
			foreach( $range_struct as $tag => $cmd )
				$pipeline[ kAPI_DATA_CLIMATE_BIO.'_'.$idx.'_'.$tag ]
					= array( $cmd => '$clim.2000.'.kAPI_DATA_CLIMATE_BIO.'.'.$idx );
		}

		//
		// Add precipitation.
		//
		for( $idx = 1; $idx < 13; $idx++ )
		{
			foreach( $range_struct as $tag => $cmd )
				$pipeline[ kAPI_DATA_CLIMATE_PREC.'_'.$idx.'_'.$tag ]
					= array( $cmd => '$clim.2000.'.kAPI_DATA_CLIMATE_PREC.'.'.$idx );
		}

		//
		// Add temperature.
		//
		foreach( $range_struct as $tag1 => $cmd1 )
		{
			for( $idx = 1; $idx < 13; $idx++ )
			{
				foreach( $range_struct as $tag2 => $cmd2 )
				{
					$pipeline[ kAPI_DATA_CLIMATE_TEMP.'_'.$tag1.'_'.$idx.'_'.$tag2 ]
						= array( $cmd2 => '$clim.2000.'.kAPI_DATA_CLIMATE_TEMP.'.'.$tag1.'.'.$idx );
				}
			}
		}

		//
		// Add to pipeline.
		//
		$thePipeline[] = array( '$group' => $pipeline );

	} // _AggregateGroup.


	/*===================================================================================
	 *	_AggregateEnd																	*
	 *==================================================================================*/

	/**
	 * Add final project to pipeline.
	 *
	 * This method will add the final project to the provided pipeline.
	 *
	 * The method expects the provided pipeline to be an array.
	 *
	 * @param array				   &$thePipeline		Request pipeline.
	 * @param boolean		        $doDistance 		Add distance.
	 *
	 * @access protected
	 */
	protected function _AggregateEnd( &$thePipeline, $doDistance = FALSE )
	{
		//
		// Init local storage.
		//
		$pipeline = Array();
		$gens_struct = array( 'id', 'c', 'e' );
		$range_struct = array( kAPI_AGGREGATE_MINIMUM,
							   kAPI_AGGREGATE_MEAN,
							   kAPI_AGGREGATE_MAXIMUM );

		//
		// Skip identifier.
		//
		$pipeline[ kAPI_DATA_ID ] = 0;

		//
		// Add count.
		//
		$pipeline[ kAPI_AGGREGATE_COUNT ] = 1;

		//
		// Add elevation.
		//
		$tmp = Array();
		foreach( $range_struct as $tag )
			$tmp[ $tag ] = '$'.kAPI_DATA_ELEVATION.'_'.$tag;
		$pipeline[ kAPI_DATA_ELEVATION ] = $tmp;

		//
		// Add distance.
		//
		if( $doDistance )
		{
			$tmp = Array();
			foreach( $range_struct as $tag )
				$tmp[ $tag ] = '$'.kAPI_DATA_DISTANCE.'_'.$tag;
			$pipeline[ kAPI_DATA_DISTANCE ] = $tmp;
		}

		//
		// Add global environment stratification.
		//
		$tmp = Array();
		foreach( $gens_struct as $tag )
			$tmp[ $tag ] = '$'.kAPI_DATA_CLIMATE_GENS.'_'.$tag;
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_GENS ] = $tmp;

		//
		// Add harmonized world soil database.
		//
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_HWSD ]
			= '$'.kAPI_DATA_CLIMATE_HWSD;

		//
		// Add global human footprint.
		//
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_GHF ]
			= '$'.kAPI_DATA_CLIMATE_GHF;

		//
		// Add global cover 2009.
		//
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_GCOV ]
			= '$'.kAPI_DATA_CLIMATE_GCOV;

		//
		// Add bioclimatic variables.
		//
		$tmp = Array();
		for( $idx = 1; $idx < 20; $idx++ )
		{
			$tmp_bis = Array();
			foreach( $range_struct as $tag )
				$tmp_bis[ $tag ] = '$'.kAPI_DATA_CLIMATE_BIO.'_'.$idx.'_'.$tag;
			$tmp[ $idx ] = $tmp_bis;
		}
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_BIO ] = $tmp;

		//
		// Add precipitation.
		//
		$tmp = Array();
		for( $idx = 1; $idx < 13; $idx++ )
		{
			$tmp_bis = Array();
			foreach( $range_struct as $tag )
				$tmp_bis[ $tag ] = '$'.kAPI_DATA_CLIMATE_PREC.'_'.$idx.'_'.$tag;
			$tmp[ $idx ] = $tmp_bis;
		}
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_PREC ] = $tmp;

		//
		// Add temperature.
		//
		$tmp = Array();
		foreach( $range_struct as $tag )
		{
			$tmp_bis = Array();
			for( $idx = 1; $idx < 13; $idx++ )
			{
				$tmp_tris = Array();
				foreach( $range_struct as $tag_bis )
					$tmp_tris[ $tag_bis ]
						= '$'.kAPI_DATA_CLIMATE_TEMP.'_'.$tag.'_'.$idx.'_'.$tag_bis;
				$tmp_bis[ $idx ] = $tmp_tris;
			}
			$tmp[ $tag ] = $tmp_bis;
		}
		$pipeline[ kAPI_DATA_CLIMATE ][ '2000' ][ kAPI_DATA_CLIMATE_TEMP ] = $tmp;

		//
		// Add to pipeline.
		//
		$thePipeline[] = array( '$project' => $pipeline );

	} // _AggregateEnd.



/*=======================================================================================
 *																						*
 *							PROTECTED HANDLER PARSING INTERFACE							*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_Tile																			*
	 *==================================================================================*/

	/**
	 * Get tile.
	 *
	 * This method will parse the provided parameter and return an array of tile
	 * identifiers.
	 *
	 * The provided value may either be an array that will be interpreted as the tiles
	 * list, or a string representing the list of tile identifiers.
	 *
	 * The method will return a GeoJSON tile and will not check the validity of the
	 * geometry.
	 *
	 * @param mixed					$theCoordinates		Tile identifiers.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Tile( $theCoordinates )
	{
		//
		// Handle coordinates value.
		//
		if( is_array( $theCoordinates ) )
		{
			//
			// Cast.
			//
			foreach( $theCoordinates as $key => $value )
				$theCoordinates[ $key ] = (int) $value;

			return array( 'type' => kAPI_GEOMETRY_TYPE_TILE,
						  'coordinates' => $theCoordinates );						// ==>
		}

		return $this->_Tile( $this->_List2Array( $theCoordinates ) );				// ==>

	} // _Tile.


	/*===================================================================================
	 *	_Point																			*
	 *==================================================================================*/

	/**
	 * Get point.
	 *
	 * This method will parse the provided parameter and return a GeoJSON point, or raise
	 * an exception if the point cannot be parsed.
	 *
	 * The provided value may either be an array that will be interpreted as the point
	 * coordinates, or a string representing the longitude and latitude separated by a
	 * comma and expressed in decimal degrees.
	 *
	 * The method will return a GeoJSON point and will not check the validity of the
	 * geometry.
	 *
	 * @param mixed					$theCoordinates		Longitude and latitude.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Point( $theCoordinates )
	{
		//
		// Handle coordinates value.
		//
		if( is_array( $theCoordinates ) )
		{
			//
			// Cast.
			//
			$this->_CastCoordinates( $theCoordinates );

			return array( 'type' => kAPI_GEOMETRY_TYPE_POINT,
						  'coordinates' => $theCoordinates );						// ==>
		}

		return $this->_Point( $this->_List2Array( $theCoordinates ) );				// ==>

	} // _Point.


	/*===================================================================================
	 *	_Rect																			*
	 *==================================================================================*/

	/**
	 * Get rect.
	 *
	 * This method will parse the provided parameter and return a GeoJSON rect, or raise
	 * an exception if the rect cannot be parsed.
	 *
	 * The provided value may either be an array that will be interpreted as the rect
	 * coordinates, or a string representing two blocks of longitude and latitude
	 * representing respectively the left-top and right-bottom vertices.
	 *
	 * The coordinates must be separated by commas and the blocks by semicolon
	 * <tt>lon,lat;lon.lat</tt>.
	 *
	 * The method will return a GeoJSON rect and will not check the validity of the
	 * geometry.
	 *
	 * @param mixed					$theCoordinates		Rect vertices.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Rect( $theCoordinates )
	{
		//
		// Handle coordinates value.
		//
		if( is_array( $theCoordinates ) )
		{
			//
			// Cast.
			//
			$this->_CastCoordinates( $theCoordinates );

			return array( 'type' => kAPI_GEOMETRY_TYPE_RECT,
						  'coordinates' => $theCoordinates );						// ==>
		}

		return $this->_Rect( $this->_List2Array( $theCoordinates, ';,' ) );			// ==>

	} // _Rect.


	/*===================================================================================
	 *	_Polygon																		*
	 *==================================================================================*/

	/**
	 * Get polygon.
	 *
	 * This method will parse the provided parameter and return a GeoJSON polygon, or raise
	 * an exception if the polygon cannot be parsed.
	 *
	 * The provided value may either be an array that will be interpreted as the polygon
	 * rings, or a string representing a list of rings and vertices of the polygon.
	 *
	 * Rings are separated by a colon, vertices by semicolons and coordinates by commas.
	 * <tt>9.5387,46.2416;9.5448,46.2369;9.5536,46.2381;9.5571,46.2419;9.5507,46.2462;9.5439,46.2468;9.5387,46.2416:
	 * 9.5445,46.2422;9.5481,46.2399;9.5517,46.2420;9.5463,46.2443;9.5445,46.2422</tt>
	 *
	 * The method will return a GeoJSON polygon and will not check the validity of the
	 * geometry.
	 *
	 * @param mixed					$theCoordinates		Polygon rings.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Polygon( $theCoordinates )
	{
		//
		// Handle coordinates value.
		//
		if( is_array( $theCoordinates ) )
		{
			//
			// Cast.
			//
			$this->_CastCoordinates( $theCoordinates );

			return array( 'type' => kAPI_GEOMETRY_TYPE_POLY,
						  'coordinates' => $theCoordinates );						// ==>
		}

		return $this->_Polygon( $this->_List2Array( $theCoordinates, ':;,' ) );		// ==>

	} // _Polygon.



/*=======================================================================================
 *																						*
 *								PROTECTED HANDLER UTILITIES								*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_StoreRequest																	*
	 *==================================================================================*/

	/**
	 * Store request.
	 *
	 * This method will store the connection and request according to the modifiers.
	 *
	 * @access protected
	 */
	protected function _StoreRequest()
	{
		//
		// Handle connection.
		//
		if( $this->_Modifiers( kAPI_OP_CONNECTION ) )
		{
			//
			// Store server.
			//
			if( strlen( $tmp = (string) $this->Server() ) )
				$this->_Connection( kAPI_CONNECTION_SERVER, $tmp );

			//
			// Store database.
			//
			if( strlen( $tmp = (string) $this->Database() ) )
				$this->_Connection( kAPI_CONNECTION_DATABASE, $tmp );

			//
			// Store collection.
			//
			if( strlen( $tmp = (string) $this->Collection() ) )
				$this->_Connection( kAPI_CONNECTION_COLLECTION, $tmp );

		} // Store connection.

		//
		// Handle request.
		//
		if( $this->_Modifiers( kAPI_OP_REQUEST ) )
		{
			//
			// Store operation.
			//
			$this->_Request( kAPI_REQUEST_OPERATION, $this->_Operation() );

			//
			// Store modifiers.
			//
			if( count( $tmp = $this->_Modifiers() ) )
				$this->_Request( kAPI_REQUEST_MODIFIERS, $tmp );

			//
			// Store geometry.
			//
			$geom = $this->_Geometry();
			$area = $this->_Area();
			if( $area !== NULL )
				$geom[ 'area' ] = $area / self::kKilometerDegs;
			$this->_Request( kAPI_REQUEST_GEOMETRY, $geom );

			//
			// Store distance.
			//
			$this->_Request( kAPI_GEOMETRY_DISTANCE, $this->_Distance() );

			//
			// Store elevation.
			//
			$this->_Request( kAPI_REQUEST_ELEVATION, $this->_Elevation() );

			//
			// Store selection.
			//
			if( count( $tmp = $this->_Selection() ) )
				$this->_Request( kAPI_ENV_SELECTION, $tmp );

		} // Store request.

	} // _StoreRequest.


	/*===================================================================================
	 *	_BuildResponse																	*
	 *==================================================================================*/

	/**
	 * Build service response.
	 *
	 * This method will build the service response by adding the eventual provided data.
	 *
	 * @param mixed					$theData			Response data.
	 *
	 * @access protected
	 */
	protected function _BuildResponse( $theData = NULL )
	{
		//
		// Init local storage.
		//
		$response = Array();

		//
		// Add status.
		//
		$response[ kAPI_RESPONSE_STATUS ] = & $this->mStatus;

		//
		// Add request.
		//
		if( count( $this->mRequest ) )
			$response[ kAPI_RESPONSE_REQUEST ] = & $this->mRequest;

		//
		// Add connection.
		//
		if( count( $this->mConnection ) )
			$response[ kAPI_RESPONSE_CONNECTION ] = & $this->mConnection;

		//
		// Add data.
		//
		if( $theData !== NULL )
		{
			//
			// Filter empty elements.
			//
			$this->mResponse = $theData;
			$response[ kAPI_RESPONSE_DATA ] = & $this->mResponse;
		}

		$this->exchangeArray( $response );

	} // _BuildResponse.



/*=======================================================================================
 *																						*
 *								PROTECTED FORMATTING INTERFACE							*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_Point2Rect																		*
	 *==================================================================================*/

	/**
	 * Transform a point into a rect.
	 *
	 * This method will transform the provided point into a rect with a dimension depending
	 * on the second provided parameter:
	 *
	 * <ul>
	 *	<li><tt>0</tt>: A zero distance means that we want a rect the size of a tile, where
	 *		the vertices are 15 seconds in either direction.
	 *	<li><i>other</i>: Any other value will be converted to a floar and used to calculate
	 *		the rect that will expand by the provided value in all directions.
	 *
	 * The method will return a GeoJSON rect.
	 *
	 * @param array					$theCoordinate		GeoJson point.
	 * @param float					$theRadius			Radius in kilometers.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Point2Rect( $theCoordinate, $theRadius = 0 )
	{
		//
		// Check point.
		//
		if( ($tmp = $theCoordinate[ 'type' ]) == kAPI_GEOMETRY_TYPE_POINT )
		{
			//
			// Init local storage.
			//
			$ptcoords = & $theCoordinate[ 'coordinates' ];
			$offset = ( $theRadius )
					? self::kKilometerDegs
					: (((1 / 3600) * $this->mGridSize) / 2);

			//
			// Set left.
			//
			$left = $ptcoords[ 0 ] - $offset;
			if( $left < -180 )
				$left = 180 - ($left + 180);

			//
			// Set right.
			//
			$right = $ptcoords[ 0 ] + $offset;
			if( $right > 180 )
				$right = -180 + ($right - 180);

			//
			// Set top.
			//
			$top = $ptcoords[ 1 ] + $offset;
			if( $top > 90 )
				$top = -90 + ($top - 90);

			//
			// Set bottom.
			//
			$bottom = $ptcoords[ 1 ] - $offset;
			if( $bottom < -90 )
				$bottom = 90 - ($bottom + 90);

			return array(
				'type' => kAPI_GEOMETRY_TYPE_RECT,
				'coordinates' => array(
					array( $left, $top ),
					array( $right, $bottom ) ) );									// ==>

		} // Provided a point.

		throw new Exception
			( "Unable to handle request: "
			 ."expecting a point, received [$tmp]." );							// !@! ==>

	} // _Point2Rect.


	/*===================================================================================
	 *	_Point2Sphere																	*
	 *==================================================================================*/

	/**
	 * Transform a point into a sphere.
	 *
	 * This method will transform the provided point into a sphere using the second
	 * parameter as the sphere radius expressed in kilometers.
	 *
	 * The method will return an array of two elements: the coordinates and the radius in
	 * radians.
	 *
	 * @param array					$theCoordinate		GeoJson point.
	 * @param float					$theRadius			Radius in kilometers.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Point2Sphere( $theCoordinate, $theRadius )
	{
		//
		// Check point.
		//
		if( ($tmp = $theCoordinate[ 'type' ]) == kAPI_GEOMETRY_TYPE_POINT )
			return array( $theCoordinate[ 'coordinates' ], $theRadius / 6371 );		// ==>

		throw new Exception
			( "Unable to handle request: "
			 ."expecting a point, received [$tmp]." );							// !@! ==>

	} // _Point2Sphere.


	/*===================================================================================
	 *	_Rect2Polygon																	*
	 *==================================================================================*/

	/**
	 * Transform a rect into a polygon.
	 *
	 * This method will transform the provided rect into a polygon.
	 *
	 * The method will return a GeoJSON polygon.
	 *
	 * @param array					$theCoordinate		GeoJson rect.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _Rect2Polygon( $theCoordinate )
	{
		//
		// Check point.
		//
		if( ($tmp = $theCoordinate[ 'type' ]) == kAPI_GEOMETRY_TYPE_RECT )
		{
			//
			// Init local storage.
			//
			$ptcoords = & $theCoordinate[ 'coordinates' ];

			return array(
				'type' => kAPI_GEOMETRY_TYPE_POLY,
				'coordinates' => array(
					array(
						$ptcoords[ 0 ],
						array( $ptcoords[ 1 ][ 0 ], $ptcoords[ 0 ][ 1 ] ),
						$ptcoords[ 1 ],
						array( $ptcoords[ 0 ][ 0 ], $ptcoords[ 1 ][ 1 ] ),
						$ptcoords[ 0 ] ) ) );										// ==>

		} // Provided a point.

		throw new Exception
			( "Unable to handle request: "
			 ."expecting a rect, received [$tmp]." );							// !@! ==>

	} // _Rect2Polygon.


	/*===================================================================================
	 *	_Exception2Status																*
	 *==================================================================================*/

	/**
	 * Set status from exception.
	 *
	 * This method can be used to set the service status according to an exception:
	 *
	 * @param Exception				$theException		Exception.
	 *
	 * @access protected
	 */
	protected function _Exception2Status( Exception $theException )
	{
		//
		// Set state.
		//
		$this->_Status( kAPI_STATUS_STATE, kAPI_STATE_ERROR );

		//
		// Set main exception elements.
		//
		$elements = array( kAPI_STATUS_CODE => $theException->getCode(),
						   kAPI_STATUS_MESSAGE => $theException->getMessage() );

		//
		// Set trace elements.
		//
		if( defined( 'kENV_TRACE' )
		 && kENV_TRACE )
		{
			$elements[ kAPI_STATUS_FILE ] = $theException->getFile();
			$elements[ kAPI_STATUS_LINE ] = $theException->getLine();
			$elements[ kAPI_STATUS_TRACE ] = $theException->getTrace();
		}

		//
		// Set status.
		//
		foreach( $elements as $key => $value )
		{
			if( ! empty( $value ) )
				$this->_Status( $key, $value );
		}

	} // _Exception2Status.


	/*===================================================================================
	 *	_List2Array																		*
	 *==================================================================================*/

	/**
	 * Transform a list into an array.
	 *
	 * This method will transform the provided string into an array, array elements are
	 * separated by commas, array pairs by semicolon and array blocks by colons.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><b>$theList</t>: A string consisting of the data,
	 *	<li><b>$theDivider</t>: The list of dividers, there can be any number of dividers,
	 *		as long as these tokens are not repeated. The method will return a set of
	 *		indented arrays determined by the list of dividers.
	 * </ul>
	 *
	 * @param string				$theList			List.
	 * @param string				$theDivider			Break token.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _List2Array( $theList, $theDivider = ',' )
	{
		//
		// Check level.
		//
		if( strlen( $theDivider ) )
		{
			//
			// Init local storage.
			//
			$array = Array();
			$divider = substr( (string) $theDivider, 0 , 1 );
			$theDivider = substr( $theDivider, 1 );

			//
			// Convert to list.
			//
			$list = explode( $divider, (string) $theList );

			//
			// Handle matrix.
			//
			if( strlen( $theDivider ) )
			{
				//
				// Trim lists.
				//
				foreach( $list as $element )
				{
					if( strlen( $element = trim( $element ) ) )
						$array[] = $this->_List2Array( $element, $theDivider );

				} // Iterating matrix.

			} // Matrix.

			//
			// Handle array.
			//
			else
			{
				//
				// Trim elements.
				//
				foreach( $list as $element )
				{
					if( strlen( $element = trim( $element ) ) )
						$array[] = $element;

				} // Iterating list.

			} // Vector.

			return $array;															// ==>

		} // Not reached end.

		return NULL;																// ==>

	} // _List2Array.


	/*===================================================================================
	 *	_CastCoordinates																*
	 *==================================================================================*/

	/**
	 * Cast coordinates to double.
	 *
	 * This method can be used to cast coordinates to double: since coordinates may be a set
	 * of nested arrays, this method helps in traversing such structures.
	 *
	 * @param reference			   &$theCoordinates		Reference to coordinates.
	 *
	 * @access protected
	 */
	protected function _CastCoordinates( &$theCoordinates )
	{
		if( is_array( $theCoordinates ) )
		{
			$keys = array_keys( $theCoordinates );
			foreach( $keys as $key )
				$this->_CastCoordinates( $theCoordinates[ $key ] );
		}

		else
			$theCoordinates = (double) $theCoordinates;

	} // _CastCoordinates.



/*=======================================================================================
 *																						*
 *						PROTECTED DATA MEMBER ACCESSOR UTILITIES						*
 *																						*
 *======================================================================================*/



	/*===================================================================================
	 *	_ManageMember																	*
	 *==================================================================================*/

	/**
	 * Manage data members.
	 *
	 * This method can be used to handle a data member, it acccepts the following
	 * parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theMember</tt>: Reference to the property being managed.
	 *	<li><tt>$theValue</tt>: The property value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current property value.
	 *		<li><tt>FALSE</tt>: Reset the property to the default value (<tt>NULL</tt> is
	 *			the default).
	 *		<li><i>other</i>: Any other type represents the new value of the property.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param reference			   &$theMember			Property reference.
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access protected
	 */
	protected function _ManageMember( &$theMember, $theValue, $getOld )
	{
		//
		// Return current value.
		//
		if( $theValue === NULL )
			return $theMember;														// ==>

		//
		// Save current value.
		//
		$save = $theMember;

		//
		// Delete offset.
		//
		if( $theValue === FALSE )
			$theMember = NULL;

		//
		// Set offset.
		//
		else
			$theMember = $theValue;

		return ( $getOld ) ? $save													// ==>
						   : $theMember;											// ==>

	} // _ManageMember.


	/*===================================================================================
	 *	_ManageArrayMember																*
	 *==================================================================================*/

	/**
	 * Manage array data members.
	 *
	 * This method can be used to handle a data member, it acccepts the following
	 * parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theMember</tt>: Reference to the property being managed.
	 *	<li><tt>$theIndex</tt>: The property element index:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Consider the whole property.
	 *		<li><i>other</i>: Any other type will be cast to string and used as an index.
	 *	 </ul>
	 *	<li><tt>$theValue</tt>: The property value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current property value.
	 *		<li><tt>FALSE</tt>: Reset the property to the default value (<tt>NULL</tt> is
	 *			the default).
	 *		<li><i>other</i>: Any other type represents the new value of the property.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param reference			   &$theMember			Property reference.
	 * @param mixed					$theIndex			Element index.
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access protected
	 */
	protected function _ManageArrayMember( &$theMember, $theIndex, $theValue, $getOld )
	{
		//
		// Return current value.
		//
		if( $theValue === NULL )
			return ( $theIndex === NULL )
				 ? $theMember														// ==>
				 : ( ( array_key_exists( (string) $theIndex, $theMember ) )
				   ? $theMember[ (string) $theIndex ]								// ==>
				   : NULL );														// ==>

		//
		// Save current value.
		//
		$save = ( $theIndex === NULL )
			  ? $theMember
			  : ( ( array_key_exists( (string) $theIndex, $theMember ) )
				? $theMember[ (string) $theIndex ]
				: NULL );

		//
		// Delete offset.
		//
		if( $theValue === FALSE )
		{
			if( $theIndex === NULL )
				$theMember = Array();

			elseif( array_key_exists( (string) $theIndex, $theMember ) )
				unset( $theMember[ (string) $theIndex ] );

		} // Delete value.

		//
		// Replace member.
		//
		elseif( $theIndex === NULL )
		{
			if( is_array( $theValue ) )
				$theMember = $theValue;

			else
				throw new Exception
					( "Unable to set data member: "
					 ."expecting an array value." );							// !@! ==>

		} // Replace member.

		//
		// Replace element.
		//
		else
			$theMember[ (string) $theIndex ] = $theValue;

		return ( $getOld ) ? $save													// ==>
						   : ( ( $theIndex === NULL )
							 ? $theMember											// ==>
							 : $theMember[ (string) $theIndex ] );					// ==>

	} // _ManageArrayMember.



} // class CGeoFeatureService.


?>
