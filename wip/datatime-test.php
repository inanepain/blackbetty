<?php

declare(strict_types=1);

use Inane\Datetime\Timescale;
use Inane\Datetime\Timespan;
use Inane\Datetime\Timestamp;
use Inane\Stdlib\Options;

// time() + 1 * 60 * 60

$expires = 1749645556; // 2025-06-11 14:39:16
$expires = 1749651386; // 2025-06-11 16:16:26
$expires = 1750321619; // 2025-06-19 10:26:59
$expiryDate = new Timestamp($expires);
if (0 > new Timestamp()->diff($expiryDate)->seconds) return;

// ======================= OPTIONS =================================
$exitAfterIncludes = true;
// =================================================================

$pen->red->line(__FILE__);
($pen->divider)();
$pen->purple->line('Expiry date  : ' . new Timestamp($expires)->format('Y-m-d H:i:s'));
$pen->purple->line('Duration left: ' . new Timestamp()->diff($expires)->getDuration());
($pen->divider)('-');

// ==================================================================
// Test Datetime
// Start code here
// ==================================================================
$opDatetime = new Options(
    [
        'validTill'  => false,
        'datemath'   => true,
        'quickDate'  => true,
        'timeunit'   => false,
        'timescale1' => false,
        'timescale2' => false,
    ]
);

if ($opDatetime->validTill) {
    $pen->blue->line('Create a valid till timestamp');
    ($pen->divider)('-');
    $ts = new Timestamp();
    $ts->adjust(1 * 60 * 60); // 1 hour

    $pen->default->line('Valid for 1hr: ' . (string) $ts->timestamp);
}

if ($opDatetime->quickDate) {
    $times = [1744252934, 1744255009, 1744308331, 1744252934];

    foreach ($times as $time) {
        $ts = new \Inane\Datetime\Timestamp($time);
        echo (string) $time . ' => ' . $ts->format('Y-m-d H:i:s') . PHP_EOL;
    }
}

if ($opDatetime->datemath) {
    // $interval = DateInterval::createFromDateString('1yr 9months 5days 19hrs 48mins 54secs');
    // dd($interval);
    $entryDate = Timestamp::createFromFormat('d F Y', '27 Jul 2023');
    $timePast  = new Timestamp()->diff($entryDate);
    $tp        = $entryDate->diff(Timestamp::now());

    $dtInterval = $timePast->absoluteCopy()->getDateInterval();

    // dd($dtInterval);

    $pen->default->line((string) $tp);
    $pen->default->line((string) $timePast);
    $pen->default->line($timePast->duration('ydhis'));
    $pen->default->line($timePast->duration('ywdhis'));
    $pen->default->line($timePast->duration('ymwdhis'));
    $pen->default->line($timePast->getDuration(Timespan::SYMBOL_CHAR, ['y', 'd', 'h', 'i', 's']));

    $pen->default->line($timePast->format('%s'));
    $pen->default->line('Time past: ' . $timePast->format('%y years, %d days, %h hours, %i minutes, %s seconds'));
} //end if

if ($opDatetime->timeunit) {
}

if ($opDatetime->timescale1) {
    echo 'Test `tryFromName` that is added via `CoreEnumTrait`' . PHP_EOL;
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
} //end if

if ($opDatetime->timescale1) {
    // DateTimeInterface::createFromFormat('U.u', "{$ts1->microseconds}");
    // $milli = (int) $date->format('Uv'); // Timestamp in milliseconds
    // $micro = (int) $date->format('Uu'); // Timestamp in microseconds
    $t   = [];
    $t[] = new Timestamp(Timescale::MICROSECOND->timestamp());
    $t[] = new Timestamp(Timescale::MILLISECOND->timestamp());
    $t[] = new Timestamp(Timescale::SECOND->timestamp());
    $t[] = new Timestamp(Timescale::SECOND->timestamp() * 1000);

    $r = [];
    foreach ($t as $ts) {
        $s   = Timescale::tryFromTimestamp($ts);
        $r[] = [
            'scale' => $s,
            'value' => $ts->{$s->unit()},
        ];
    }

    dd($r);
    dd(
        [
            new Timestamp(Timescale::SECOND->timestamp())->getSeconds(),
            new Timestamp(time())->microseconds,
        ]
    );

    // var_dump([Timescale::MICROSECOND->timestamp(),
    // Timescale::MILLISECOND->timestamp(), Timescale::SECOND->timestamp()]);
    // $ts1 = new Timestamp(intval(microtime(true) * 1000));
    $ts1 = new Timestamp(Timescale::MICROSECOND->timestamp());
    $ts2 = new Timestamp(Timescale::SECOND->timestamp());
    echo "$ts1" . PHP_EOL;
    echo "$ts2" . PHP_EOL;
    echo '' . $ts1->getSeconds() . PHP_EOL;
    echo '' . $ts1->getMilliseconds() . PHP_EOL;
    echo '' . $ts1->getMicroseconds() . PHP_EOL;
    echo '' . $ts2->getSeconds() . PHP_EOL;
    echo '' . $ts2->getMilliseconds() . PHP_EOL;
    echo '' . $ts2->getMicroseconds() . PHP_EOL;
    echo PHP_EOL;
    echo "$ts1" . PHP_EOL;
    echo "$ts2" . PHP_EOL;

    echo $ts1->seconds . PHP_EOL;
    // $ts1->seconds = 1234567890;
}//end if
