<?php

declare(strict_types=1);

declare(ticks=1);

// chdir('C:\www\develop\data');
chdir('C:\Developer\data');

class Counter {
    private int $counter = 0;

    public function increase() {
        $this->counter++;
    }

    public function current() {
        return $this->counter;
    }
}

$counter = new Counter();

register_tick_function([&$counter, 'increase']);

$db = new PDO('sqlite:yts-data.db','','');
$stmt = $db->query('SELECT * FROM main.sqlite_master', PDO::FETCH_ASSOC);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($result);

echo $counter->current() . PHP_EOL;

exit;

// A function called on each tick event
function tick_handler() {
    echo "tick_handler() called\n";
}

register_tick_function('tick_handler'); // causes a tick event

$a = 1; // causes a tick event

if ($a > 0) {
    $a += 2; // causes a tick event
    echo $a . PHP_EOL; // causes a tick event
}
