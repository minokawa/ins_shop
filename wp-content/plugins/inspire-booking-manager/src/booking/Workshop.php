<?php

namespace  Inspire\Booking;
use Roomify\Bat\Event\AbstractEvent;
use Roomify\Bat\Unit\UnitInterface;

/**
 * The basic BAT unit class.
 */
class Workshop extends AbstractEvent  {

 // Redeclaring constants used in AbstractEvent because of no clean way to
  // have constants inherited;
  const BAT_DAY = 'bat_day';
  const BAT_HOUR = 'bat_hour';
  const BAT_MINUTE = 'bat_minute';
  const BAT_HOURLY = 'bat_hourly';
  const BAT_DAILY = 'bat_daily';

  /**
   * Event constructor.
   *
   * @param \DateTime $start_date
   * @param \DateTime $end_date
   * @param $unit
   * @param $value
   */
  public function __construct(\DateTime $start_date, \DateTime $end_date, UnitInterface $unit, $value = 0) {
    $this->unit_id = $unit->getUnitId();
    $this->unit = $unit;
    $this->start_date = clone($start_date);
    $this->end_date = clone($end_date);
    $this->value = $value;
  }

}
