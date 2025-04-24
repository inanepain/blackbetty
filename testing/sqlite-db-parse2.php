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
// $stmt = $db->query('SELECT * FROM main.sqlite_master', PDO::FETCH_ASSOC);
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result);

// $stmt = $db->query('pragma table_info(movies)', PDO::FETCH_ASSOC);
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result);

$stmt = $db->query("SELECT
    m.type AS table_type,
    m.name AS table_name,
	p.name AS column_name,
    p.type AS column_type,
    `p`.`notnull` AS not_null,
    p.dflt_value AS default_value,
    p.pk AS primary_key
FROM sqlite_master m
LEFT OUTER JOIN pragma_table_info(m.name) p ON m.name <> p.name
WHERE
    m.name <> 'sqlite_sequence'
    AND m.name = 'movies'
ORDER BY
    table_name", PDO::FETCH_ASSOC);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($result);

echo $counter->current() . PHP_EOL;
