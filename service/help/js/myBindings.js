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
    // Tile geometry.
    //
    self.tile = {
        "visible" : ko.observable(false),          // Tile is active.
        "url" : ko.observable(""),                 // Tile coordinates for URL.
        "received" : ko.observable(false),      // Tile was received from service.
        "coordinates" : ko.observableArray([])          // Tiles list.
    };

    //
    // Elevation.
    //
    self.elevation = {
        "visible" : ko.observable(false),          // Elevation is active.
        "url" : ko.observable(""),                 // Elevation range for URL.
        "received" : ko.observable(false),      // Elevation was received from service.
        "range" : ko.observableArray([])                // Elevation range.
    };

    //
    // Distance.
    //
    self.distance = {
        "visible" : ko.observable(false),          // Distance is active.
        "url" : ko.observable(""),                 // Distance range for URL.
        "received" : ko.observable(false),      // Distance was received from service.
        "value" : ko.observable("")                // Distance value.
    };

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
            "state" : ko.observable(false)              // received status state.
        }
    };

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
        if( self.tile.visible() )
            theURL += ("&" + "tile=" + self.tile().url);

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

        // Parse status.
        parseStatus();

        // enable button.
        self.button.disabled(false);
    };

    //
    // Parse response status.
    //
    function parseStatus() {
        // Check if status is there.
        self.status.received( typeof(self.response.object().status) != "undefined" );
        if( self.status.received() )
        {

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
