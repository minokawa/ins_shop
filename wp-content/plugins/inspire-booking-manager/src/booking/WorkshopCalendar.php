<?php
/**
 * Templater Class Doc Comment
 *
 * @category Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

namespace  Inspire\Booking;
use Roomify\Bat\Calendar\AbstractCalendar;
use Roomify\Bat\Calendar\CalendarResponse;

class WorkshopCalendar extends AbstractCalendar  {

  public function __construct($units, $store, $default_value = 0) {
    $this->units = $units;
    $this->store = $store;
    $this->default_value = $default_value;
  }

	public function getFilteredWorkshops(\DateTime $start_date, \DateTime $end_date, $valid_states, $constraints = array(), $intersect = FALSE, $reset = TRUE) {
    $units = array();
    $response = new CalendarResponse($start_date, $end_date, $valid_states);
    $keyed_units = $this->keyUnitsById();

    $states = $this->getStates($start_date, $end_date, $reset);
    foreach ($states as $unit => $unit_states) {

      $current_states = array_keys($unit_states);

      $remaining_states = array_uintersect($current_states, $valid_states,"strcasecmp");

      if ((count($remaining_states) == 0 && !$intersect) || (count($remaining_states) > 0 && $intersect)) {
        $units[$unit] = $unit;
        $response->addMatch($keyed_units[$unit], CalendarResponse::VALID_STATE);
      } else {
        $response->addMiss($keyed_units[$unit], CalendarResponse::INVALID_STATE);
      }

      $unit_constraints = $keyed_units[$unit]->getConstraints();
      $response->applyConstraints($unit_constraints);
    }

    $response->applyConstraints($constraints);

    return $response;
  }

	public function getProgram($id){
		return $this->getUnit($id);
	}

	public function getWorkshops(\DateTime $start_date, \DateTime $end_date, $granularity) {
		return $this->getEventsItemized( $start_date,  $end_date,  $granularity);
	}
}


