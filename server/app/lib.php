<?php

/**
 * The function that implements the filtering algorithm
 * 
 * @param string $departure
 * @param string $arrival
 * @return array
 */

function get_cheapest_flight($departure, $arrival)
{

  // Read the flights file
  $flights = json_decode(file_get_contents(FLIGHTS_FILE));
  $final_flights = array();
  $departures = array();
  $arrivals = array();

  // Iterate on all flights
  foreach ($flights as $flight) {
    if (
      $flight->code_departure == $departure &&
      $flight->code_arrival == $arrival
    ) {

      // Direct flights
      array_push($final_flights, array($flight));
    } else if ($flight->code_departure == $departure) {

      // Flights with the same departure
      array_push($departures, $flight);
    } else if ($flight->code_arrival == $arrival) {

      // Flights with the same arrival
      array_push($arrivals, $flight);
    }
  }

  // Combine the flights departures with arrivals
  foreach ($departures as $start_flight) {
    foreach ($arrivals as $end_flight) {
      if ($start_flight->code_arrival == $end_flight->code_departure) {

        // One stopover flights combination
        array_push($final_flights, [$start_flight, $end_flight]);
      }

      // Check for two stopovers flight combinations
      foreach ($flights as $flight) {
        if (
          $flight->code_departure == $start_flight->code_arrival &&
          $flight->code_arrival == $end_flight->code_departure
        ) {

          array_push($final_flights, [$start_flight, $flight, $end_flight]);
        }
      }
    }
  }
  // Calculate entire journey prices
  $final_cheapest_journey = NULL;
  $last_cheapest_price = NULL;

  foreach ($final_flights as $journey) {
    // Calculate the current journey price    
    $journey_price = 0;

    foreach ($journey as $flight) {
      $journey_price += $flight->price;
    }

    // Compare the current journey to the last 
    if ($last_cheapest_price == NULL || $journey_price < $last_cheapest_price) {
      $final_cheapest_journey = $journey;

      // Update last cheapest price
      $last_cheapest_price = $journey_price;
    }
  }

  // Return the cheapest journey
  return $final_cheapest_journey;
};
