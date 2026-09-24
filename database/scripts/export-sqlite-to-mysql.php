<?php

declare(strict_types=1);

$sqlite = $argv[1] ?? dirname(__DIR__).'/database.sqlite';
$out = $argv[2] ?? dirname(__DIR__).'/data/gmac-from-sqlite.sql';

$skip = [
    'cache',
    'cache_locks',
    'sessions',
    'jobs',
    'job_batches',
    'failed_jobs',
    'migrations',
];

if (! is_file($sqlite)) {
    fwrite(STDERR, "SQLite file not found: {$sqlite}\n");
    exit(1);
}

$db = new PDO('sqlite:'.$sqlite, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")
    ->fetchAll(PDO::FETCH_COLUMN);

$sql = [
    'SET NAMES utf8mb4;',
    'SET FOREIGN_KEY_CHECKS=0;',
    'SET UNIQUE_CHECKS=0;',
];

$quote = static function (mixed $value): string {
    if ($value === null) {
        return 'NULL';
    }

    if (is_bool($value)) {
        return $value ? '1' : '0';
    }

    if (is_int($value) || is_float($value)) {
        return (string) $value;
    }

    $text = (string) $value;
    $text = str_replace(["\\", "\x00", "\n", "\r", "'", '"', "\x1a"], ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'], $text);

    return "'".$text."'";
};

foreach ($tables as $table) {
    if (in_array($table, $skip, true)) {
        continue;
    }

    $rows = $db->query('SELECT * FROM "'.$table.'"')->fetchAll(PDO::FETCH_ASSOC);
    $sql[] = 'DELETE FROM `'.$table.'`;';

    if ($rows === []) {
        continue;
    }

    $columns = array_map(static fn (string $col): string => '`'.$col.'`', array_keys($rows[0]));
    $chunks = array_chunk($rows, 50);

    foreach ($chunks as $chunk) {
        $values = [];
        foreach ($chunk as $row) {
            $values[] = '('.implode(', ', array_map($quote, array_values($row))).')';
        }
        $sql[] = 'INSERT INTO `'.$table.'` ('.implode(', ', $columns).') VALUES'."\n".implode(",\n", $values).';';
    }
}

$sql[] = 'SET UNIQUE_CHECKS=1;';
$sql[] = 'SET FOREIGN_KEY_CHECKS=1;';

@mkdir(dirname($out), 0775, true);
file_put_contents($out, implode("\n", $sql)."\n");

echo $out.PHP_EOL;
