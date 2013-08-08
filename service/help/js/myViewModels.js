/**
 * Created with JetBrains PhpStorm.
 * User: milko
 * Date: 8/8/13
 * Time: 13:28
 * To change this template use File | Settings | File Templates.
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
    // PING BLOCK.
    //
    self.pingRequest = ko.observable(baseURL + "?ping");    // Request.
    self.pingResponse = ko.observable();                    // Response.
    self.pingCALL = function() {                            // Call.
        $.get( self.pingRequest(), function(theData){
            self.pingResponse(theData);
        });
    };

    //
    // HELP BLOCK.
    //
    self.helpRequest = ko.observable(baseURL + "?help");    // Request.
    self.helpResponse = ko.observable();                    // Response.
    self.helpCALL = function() {                            // Call.
        $.get( self.helpRequest(), function(theData){
            self.helpResponse(theData);
        });
    };

    //
    // TILES BLOCK.
    //
    self.tilesRequest = ko.observable(baseURL + "?tiles&tile=33065587,774896741");
    self.tilesResponse = ko.observable();                    // Response.
    self.tilesCALL = function() {                            // Call.
        $.get( self.tilesRequest(), function(theData){
            self.tilesResponse(theData);
        });
    };
}

//
// Apply bindings.
//
ko.applyBindings(new MyViewModel());
