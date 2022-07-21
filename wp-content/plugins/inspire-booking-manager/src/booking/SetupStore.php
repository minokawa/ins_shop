<?php
namespace Inspire\Booking;

class SetupStore {

public static function checkTable($table_name, $type) {

	$table = "bat_event_".$table_name."_hour_".$type;

	$command = "SELECT name FROM sqlite_master WHERE type='table' AND name='$table'";
	return $command;
}

public static function createDayTable($table_name, $type) {
	$command = 'CREATE TABLE if not exists ' . 'bat_event_'.$table_name.'_day_'.$type;
	$command .= ' (unit_id INTEGER NOT NULL DEFAULT 0, year INTEGER NOT NULL DEFAULT 0, month INTEGER NOT NULL DEFAULT 0,';
	for ($i=1; $i<=31; $i++) {
		$command .= 'd'.$i .' INTEGER NOT NULL DEFAULT 0, ';
	}
	$command .= 'PRIMARY KEY (unit_id, year, month))';
	return $command;
}

public static function createHourTable($table_name, $type) {
	$command = 'CREATE TABLE if not exists ' . 'bat_event_'.$table_name.'_hour_'.$type;
	$command .= ' (unit_id INTEGER NOT NULL DEFAULT 0, year INTEGER NOT NULL DEFAULT 0, month INTEGER NOT NULL DEFAULT 0, day INTEGER NOT NULL DEFAULT 0,';
	for ($i=0; $i<=23; $i++) {
		$command .= 'h'.$i .' INTEGER NOT NULL DEFAULT 0, ';
	}
	$command .= 'PRIMARY KEY (unit_id, year, month, day))';
	return $command;
}


public static function createMinuteTable($table_name, $type) {
	$command = 'CREATE TABLE if not exists ' . 'bat_event_'.$table_name.'_minute_'.$type;
	$command .= ' (unit_id INTEGER NOT NULL DEFAULT 0, year INTEGER NOT NULL DEFAULT 0, month INTEGER NOT NULL DEFAULT 0, day INTEGER NOT NULL DEFAULT 0, hour INTEGER NOT NULL DEFAULT 0,';

	for ($i=0; $i<=59; $i++) {
		if ($i <= 9) { $m='0' . $i; } else { $m = $i; }
		$command .= 'm'.$m .' INTEGER NOT NULL DEFAULT 0, ';
	}

	$command .= 'PRIMARY KEY (unit_id, year, month, day, hour))';

	return $command;
}
}
