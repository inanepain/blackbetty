<?php

declare(strict_types=1);

use Inane\Datetime\Timescale;
use Inane\Datetime\Timestamp;

$exitAfterIncludes = true;
$pen->red->line(__FILE__);

echo "Test `tryFromName` that is added via `CoreEnumTrait`" . PHP_EOL;
dd(Timescale::tryFromName('SECOND'), 'try: SECOND');

$ts1 = new Timestamp(Timescale::MICROSECOND->timestamp());
$ts2 = new Timestamp(Timescale::MILLISECOND->timestamp());
$ts3 = new Timestamp(Timescale::SECOND->timestamp());
echo "$ts1\t{$ts1->microseconds}" . PHP_EOL;
echo "$ts2" . PHP_EOL;
echo "$ts3" . PHP_EOL;
echo '==================================================================' . PHP_EOL;
$d1 = $ts1->getDateTime();
echo $d1->format('Y-m-d H:i:s.u') . PHP_EOL;
echo $d1->format('U.u') . PHP_EOL;
echo $d1->format('Uv') . PHP_EOL;
echo $d1->format('Uu') . PHP_EOL;
echo '==================================================================' . PHP_EOL;
$d2 = new DateTime();
echo $d2->format('Y-m-d H:i:s.u') . PHP_EOL;
echo $d2->format('U.u') . PHP_EOL;
echo $d2->format('Uv') . PHP_EOL;
echo $d2->format('Uu') . PHP_EOL;
echo '==================================================================' . PHP_EOL;

if (true) {
	// DateTimeInterface::createFromFormat('U.u', "{$ts1->microseconds}");

	// $milli = (int) $date->format('Uv'); // Timestamp in milliseconds
	// $micro = (int) $date->format('Uu'); // Timestamp in microseconds


	$t = [];
	$t[] = new Timestamp(Timescale::MICROSECOND->timestamp());
	$t[] = new Timestamp(Timescale::MILLISECOND->timestamp());
	$t[] = new Timestamp(Timescale::SECOND->timestamp());
	$t[] = new Timestamp(Timescale::SECOND->timestamp() * 1000);

	$r = [];
	foreach ($t as $ts) {
		$s = Timescale::tryFromTimestamp($ts);
		$r[] = [
			'scale' => $s,
			'value' => $ts->{$s->unit()},
		];
	}

	dd($r);
	dd([
		new Timestamp(Timescale::SECOND->timestamp())->getSeconds(),
		new Timestamp(time())->microseconds,
	]);

	// var_dump([Timescale::MICROSECOND->timestamp(),
	// 	Timescale::MILLISECOND->timestamp(), Timescale::SECOND->timestamp()]);

	// $ts1 = new Timestamp(intval(microtime(true) * 1000));
	$ts1 = new Timestamp(Timescale::MICROSECOND->timestamp());
	$ts2 = new Timestamp(Timescale::SECOND->timestamp());
	echo "$ts1" . PHP_EOL;
	echo "$ts2" . PHP_EOL;
	echo "" . $ts1->getSeconds() . PHP_EOL;
	echo "" . $ts1->getMilliseconds() . PHP_EOL;
	echo "" . $ts1->getMicroseconds() . PHP_EOL;
	echo "" . $ts2->getSeconds() . PHP_EOL;
	echo "" . $ts2->getMilliseconds() . PHP_EOL;
	echo "" . $ts2->getMicroseconds() . PHP_EOL;
	echo PHP_EOL;
	echo "$ts1" . PHP_EOL;
	echo "$ts2" . PHP_EOL;

	echo $ts1->seconds . PHP_EOL;
	// $ts1->seconds = 1234567890;
}
