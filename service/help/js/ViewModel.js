/*=======================================================================================
 *																						*
 *								    myViewModel.js	           							*
 *																						*
 *======================================================================================*/

/**
 *	Knockout.js view model.
 *
 *	This file contains the examples page for the response of the web-service.
 *
 *	@package	WORLDCLIM30
 *	@subpackage	Services
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/08/2013
 */

//
// View model.
//
function MyViewModel() {

    //
    // Reference this.
    //
    var self = this;

    //
    // Operation.
    // Note that this property requires the baseCMD global.
    //
    self.operation = ko.observable( baseCMD );

    //
    // Modifiers.
    //
    self.modifiers = {
        "request" : {                           // Copy request modifier:
            "visible" : ko.observable(false),       // Visibility switch.
            "checked" : ko.observable(false),       // Checked switch.
            "sent" : ko.observable(false),          // Sent to service.
            "received" : ko.observable(false)       // Received from service.
        },
        "connection" : {                        // Copy connection modifier:
            "visible" : ko.observable(false),       // Visibility switch.
            "checked" : ko.observable(false),       // Checked switch.
            "sent" : ko.observable(false),          // Sent to service.
            "received" : ko.observable(false)       // Received from service.
        },
        "range" : {                             // Range results modifier:
            "visible" : ko.observable(false),       // Visibility switch.
            "checked" : ko.observable(false),       // Checked switch.
            "sent" : ko.observable(false),          // Sent to service.
            "received" : ko.observable(false)       // Received from service.
        },
        "count" : {                             // Count results modifier:
            "visible" : ko.observable(false),       // Visibility switch.
            "checked" : ko.observable(false),       // Checked switch.
            "sent" : ko.observable(false),          // Sent to service.
            "received" : ko.observable(false)       // Received from service.
        }
    };

    //
    // Geometry.
    //
    self.geometry = {
        "type" : ko.observable(""),             // Geometry type for request.
        "coordinates" : ko.observable("")       // Geometry coordinates for request.
    }

    //
    // Response.
    //
    self.response = {
        "received" : ko.observable(false),          // Response received.
        "format" : ko.observable("json"),           // Selected format.
        "string" : ko.observable(""),               // Response JSON string.
        "object" : ko.observable({}),               // Response object string.
        "status" : {                                // Response status.
            "received" : ko.observable(false),          // Received status.
            "state" : {                                 // State block.
                "received" : ko.observable(false),          // Received state.
                "data" : ko.observable(""),                 // State data.
                "style" : ko.observable("")                 // State style.
            },
            "message" : {                                 // Message block.
                "received" : ko.observable(false),          // Received message.
                "data" : ko.observable("")                  // Message data.
            },
            "total" : {                                 // Affected count block.
                "received" : ko.observable(false),          // Received affected count.
                "data" : ko.observable("")                  // Affected count data.
            },
            "count" : {                                 // Actual count block.
                "received" : ko.observable(false),          // Received actual count.
                "data" : ko.observable("")                  // Actual count data.
            },
            "start" : {                                 // Page start block.
                "received" : ko.observable(false),          // Received page start.
                "data" : ko.observable("")                  // Page start data.
            },
            "limit" : {                                 // Page limit block.
                "received" : ko.observable(false),          // Received page limit.
                "data" : ko.observable("")                  // Page limit data.
            }
        },
        "connection" : {                            // Service connection.
            "received" : ko.observable(false),          // Received connection.
            "server" : {                                // Server block.
                "received" : ko.observable(false),          // Received server.
                "data" : ko.observable("")                  // Server data.
            },
            "database" : {                              // Database block.
                "received" : ko.observable(false),          // Received database.
                "data" : ko.observable("")                  // Database data.
            },
            "collection" : {                            // Collection block.
                "received" : ko.observable(false),          // Received collection.
                "data" : ko.observable("")                  // Collection data.
            }
        },
        "request" : {                               // Service request.
            "received" : ko.observable(false),          // Received request.
            "operation" : {                             // Operation block.
                "received" : ko.observable(false),          // Received operation.
                "data" : ko.observable("")                  // Operation data.
            },
            "modifiers" : {                             // Modifiers block.
                "received" : ko.observable(false),          // Received modifiers.
                "data" : ko.observable("")                  // Modifiers data.
            },
            "geometry" : {                              // Geometry block.
                "received" : ko.observable(false),          // Received geometry.
                "type" : ko.observable(""),                 // Geometry type.
                "coordinates" : ko.observable(""),          // Geometry coordinates.
                "area" : ko.observable("")                  // Geometry area.
            }
        },
        "data" : {                                  // Service data.
            "received" : ko.observable(false),          // Received data.
            "string" : ko.observable(""),               // Data string (for ping).
            "array" : ko.observableArray([]),           // Data list.
            "range" : ko.observable({})                 // Data ranges.
        }
    };

    //
    // Format panes.
    //
    self.asJson = ko.computed(function() {
        return( self.response.received()
            && self.response.format() == "json" );                                  // ==>
    });
    self.asObject = ko.computed(function() {
        // Check if received response and selected object.
        if( self.response.received()
         && (self.response.format() == "object") )
        {
            // Handle status.
            parseStatus();

            // Parse connection.
            parseConnection();

            // Parse request.
            parseRequest();

            // Parse response.
            parseResponse();

            return true;                                                            // ==>
        }

        return false;                                                               // ==>
    });

    //
    // Call button.
    //
    self.button = {
        "disabled" : ko.observable(false)          // Disabled switch.
    };

    //
    // URL.
    // Note that this property requires the baseURL global.
    //
    self.url = ko.computed(function() {

        var theURL;

        // Initialise URL.
        theURL = baseURL;

        // Add operation.
        theURL += ("?" + self.operation());

        // Add modifiers.
        if( self.modifiers.request.checked() )
            theURL += ("&" + "cpy-request");
        if( self.modifiers.connection.checked() )
            theURL += ("&" + "cpy-connection");
        if( self.modifiers.count.checked() )
            theURL += ("&" + "count");
        else
        {
            if( self.modifiers.range.checked() )
                theURL += ("&" + "range");
        }

        // Add geometries.
        if( self.geometry.type().length )
            theURL += ("&" + self.geometry.type() + "=" + self.geometry.coordinates());

        return theURL;                                                              // ==>
    });

    //
    // SERVICE CALL.
    //
    self.call = function() {
        // Disable button.
        self.button.disabled(true);

        // Call service.
        $.get( self.url(), function(theData){

            // Set received flag.
            self.response.received(true);

            // Set response string.
            self.response.string(theData);

            // Set response object.
            self.response.object(JSON.parse(theData));
        });

        // Handle range.
        self.modifiers.range.sent( self.modifiers.range.checked() );

        // Parse status.
        parseStatus();

        // Parse connection.
        parseConnection();

        // Parse request.
        parseRequest();

        // Parse response.
        parseResponse();

        // enable button.
        self.button.disabled(false);
    };

    //
    // Parse response status.
    //
    function parseStatus() {
        // Check if status is there.
        self.response.status.received( typeof(self.response.object().status) != "undefined" );
        if( self.response.status.received() )
        {
            // Handle state.
            self.response.status.state.received( typeof(self.response.object().status.state) != "undefined" );
            if( self.response.status.state.received() )
            {
                self.response.status.state.data( self.response.object().status.state );
                self.response.status.state.style
                    ( ( self.response.object().status.state == 'OK' ) ? "success" : "danger" );
            }

            // Handle message.
            self.response.status.message.received( typeof(self.response.object().status.message) != "undefined" );
            if( self.response.status.message.received() )
                self.response.status.message.data( self.response.object().status.message );

            // Handle affected count.
            self.response.status.total.received( typeof(self.response.object().status.total) != "undefined" );
            if( self.response.status.total.received() )
                self.response.status.total.data( self.response.object().status.total );

            // Handle actual count.
            self.response.status.count.received( typeof(self.response.object().status.count) != "undefined" );
            if( self.response.status.count.received() )
                self.response.status.count.data( self.response.object().status.count );

            // Handle page start.
            self.response.status.start.received( typeof(self.response.object().status.start) != "undefined" );
            if( self.response.status.count.received() )
                self.response.status.start.data( self.response.object().status.start );

            // Handle page limit.
            self.response.status.limit.received( typeof(self.response.object().status.limit) != "undefined" );
            if( self.response.status.limit.received() )
                self.response.status.limit.data( self.response.object().status.limit );
        }
    }

    //
    // Parse response connection.
    //
    function parseConnection() {
        // Check if connection is there.
        self.response.connection.received( typeof(self.response.object().connection) != "undefined" );
        if( self.response.connection.received() )
        {
            // Handle server.
            self.response.connection.server.received
                ( typeof(self.response.object().connection.server) != "undefined" );
            if( self.response.connection.server.received() )
                self.response.connection.server.data( self.response.object().connection.server );

            // Handle database.
            self.response.connection.database.received
                ( typeof(self.response.object().connection.database) != "undefined" );
            if( self.response.connection.database.received() )
                self.response.connection.database.data( self.response.object().connection.database );

            // Handle collection.
            self.response.connection.collection.received
                ( typeof(self.response.object().connection.collection) != "undefined" );
            if( self.response.connection.collection.received() )
                self.response.connection.collection.data( self.response.object().connection.collection );
        }
    }

    //
    // Parse response request.
    //
    function parseRequest() {
        // Check if request is there.
        self.response.request.received( typeof(self.response.object().request) != "undefined" );
        if( self.response.request.received() )
        {
            // Handle operation.
            self.response.request.operation.received
                ( typeof(self.response.object().request.operation) != "undefined" );
            if( self.response.request.operation.received() )
                self.response.request.operation.data( self.response.object().request.operation );

            // Handle modifiers.
            self.response.request.modifiers.received
                ( typeof(self.response.object().request.modifiers) != "undefined" );
            if( self.response.request.modifiers.received() )
            {
                var modifiers = "";
                for( var tag in self.response.object().request.modifiers )
                {
                    if( self.response.object().request.modifiers[tag] )
                    {
                        if( modifiers.length )
                            modifiers += ", ";
                        modifiers += tag;
                    }
                }
                self.response.request.modifiers.data(modifiers);
            }

            // Handle geometry.
            self.response.request.geometry.received
                ( typeof(self.response.object().request.geometry) != "undefined" );
            if( self.response.request.geometry.received() )
            {

                self.response.request.geometry.coordinates("");
                self.response.request.geometry.area("");
                self.response.request.geometry.type( self.response.object().request.geometry.type );
                switch( self.response.request.geometry.type() )
                {
                    case "Tiles":
                        var tmp = "";
                        for( i=0; i<self.response.object().request.geometry.coordinates.length; i++ )
                        {
                            if( tmp.length )
                                tmp += ", ";
                            tmp += self.response.object().request.geometry.coordinates[i];
                        }
                        self.response.request.geometry.coordinates(tmp);
                        break;
                }
            }
        }
    }

    //
    // Parse response data.
    //
    function parseResponse() {
        // Check if data is there.
        self.response.data.received( typeof(self.response.object().data) != "undefined" );
        if( self.response.data.received() )
        {
            // Init local storage.
            self.response.data.string("");
            self.response.data.array([]);
            self.response.data.range({});

            // Handle string.
            if( typeof( self.response.object().data ) == "string" )
                self.response.data.string( self.response.object().data );

            // Handle data.
            else
            {
                // Handle ranges.
                if( self.modifiers.range.sent() )
                    self.response.data.range( self.response.object().data );

                // Handle lists.
                else
                {
                    var i = 0;
                    for( var tag in self.response.object().data )
                        self.response.data.array.push( {
                            "id" : ("section" + i),
                            "href" : ("#" + "section" + i++),
                            "data" : self.response.object().data[tag]
                        } );
                }
            }
        }
    }
}

//
// Instantiate model.
//
var myModel = new MyViewModel();

//
// Apply bindings.
//
ko.applyBindings( myModel );
