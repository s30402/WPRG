<?php
define('LIMIT', 5);
define('WINDOW', 3600 * 24);

$visits = isset($_COOKIE['53_visits_unique']) ? json_decode($_COOKIE['53_visits_unique'], true) : ['count'=>0, 'last'=>0];
$now = time();

if ($now - $visits['last'] > WINDOW) {
    $visits['count']++;
    $visits['last'] = $now;
    setcookie('53_visits_unique', json_encode($visits), $now + 3600 * 24 * 30);
}

echo "<p>Unikalnych odwiedzin: {$visits['count']}.</p>";

if ($visits['count'] >= LIMIT) {
    echo "<h1>Gratulacje! Osiągnąłeś limit {$visits['count']} odwiedzin i wygrałeś nowego Iphone 20 PRO.</h1>";
    $visits = ['count' => 0, 'last' => $now];
    setcookie('53_visits_unique', json_encode($visits), $now + 3600 * 24 * 30);
}
