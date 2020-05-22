/**
 *  @title : searchTravel.js
 *  @author : Matthis HOULES
 *  @author : Guillaume RISCH
 * 
 *  @brief : Search & create travels js page, 
 *              map display, 
 *              cities autocompleted inputs, 
 *              directions viewer on map, 
 *              travel time estimated with time & date inputs. 
 */



var directionsService;
var directionsDisplay;

var departure;
var arrival;

var startInput = document.getElementById('start');
var endInput = document.getElementById('end');



/**
 *  @name : initMap
 *  @author : Matthis HOULES
 *  @author : Guillaume RISCH
 * 
 *  @brief : callback GoogleMap init.
 *  
 */
function initMap() {

    // map
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: 43.3, lng: 5.4},
        disableDefaultUI: true,
    });    
    
    
    // directions 
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;
    directionsDisplay.setMap(map);


    // autocomplete
    var optionsAutocomplete = {
        types: ['(cities)'],
        componentRestrictions: {country: "fr"}
    };
    var autocompletestart = new google.maps.places.Autocomplete(startInput, optionsAutocomplete);
    var autocompleteend = new google.maps.places.Autocomplete(endInput, optionsAutocomplete);
    

    // lister autocomplete change
    google.maps.event.addListener(autocompletestart, 'place_changed', function() {
        //get place
        let place = this.getPlace();

        // set arrival city name
        document.getElementById('cityStart').value = place.address_components[0]['long_name'];
        departure = place.address_components[0]['long_name'];

        // update directions
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });


    // lister autocomplete change
    google.maps.event.addListener(autocompleteend, 'place_changed', function() {
        // get place
        let place = this.getPlace();

        // set arrival city name
        arrival = place.address_components[0]['long_name'];
        document.getElementById('cityEnd').value = arrival;

        // update directions
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });


    // date & time input
    document.getElementById('dayDeparture').addEventListener('change', function() {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });

    document.getElementById('timeDeparture').addEventListener('change', function() {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });
}


/**
 * @name : calculateAndDisplayRoute
 *  
 * @author : Matthis HOULES
 * @author : Guillaume RISCH
 * 
 * @param {directionsService} directionsService : gmap Directions api (get time and create a direction)
 * @param {directionsService} directionsDisplay : gmap Directions display in map
 * 
 * @return : void
 * 
 * @brief : Calculate the directions between departure and arrival inputs,
 *          Calculate the estimated travel time with date & time of departure inputs
 */
function calculateAndDisplayRoute(directionsService, directionsDisplay) {

    // if arrival & departure are set by user    
    if (arrival != null && departure != null ) {
        document.getElementById('ETTCC').classList.add('display');
        var dateTimeFOrm = new Date(document.getElementById('dayDeparture').value + ', ' + document.getElementById('timeDeparture').value).getTime();
        var currentTime = new Date().getTime();

        if (document.getElementById('timeDeparture').value == '' || document.getElementById('dayDeparture').value == '' || dateTimeFOrm <= currentTime) {
            directionsService.route({
                origin: departure,

                destination: arrival,

                travelMode: 'DRIVING'

            }, function(response, status) {

                var route = response.routes[0].legs[0];
                var time = route.duration.text;
                
                document.getElementById('ETTvalue').innerText = time;
    
                if (status === 'OK') {
                  directionsDisplay.setDirections(response);

                } else {
                  console.log('Directions request failed due to ' + status);

                }
            });

        }
        else {
            directionsService.route({
                origin: departure,

                destination: arrival,

                travelMode: 'DRIVING',

                drivingOptions : {
                    departureTime : new Date(document.getElementById('dayDeparture').value + ', ' + document.getElementById('timeDeparture').value),
                    trafficModel : 'pessimistic'

                }

            }, function(response, status) {

                var route = response.routes[0].legs[0];
                var time = route.duration_in_traffic.text;

                document.getElementById('ETTvalue').innerText = time;

                if (status === 'OK') {
                  directionsDisplay.setDirections(response);

                } else {
                  console.log('Directions request failed due to ' + status);

                }
            });

        }

    }
}