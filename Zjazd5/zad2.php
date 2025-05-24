<?php
define('LIMIT', 7); 

$visits = isset($_COOKIE['52_visits']) ? (int)$_COOKIE['52_visits'] : 0;
$visits++;

setcookie('52_visits', $visits, time() + 3600 * 24 * 30); 

echo "<p>Odwiedziłeś tę stronę już $visits razy.</p>";

if ($visits >= LIMIT) {
    echo "<h1>Gratulacje! Osiągnąłeś limit $visits odwiedzin i wygrałeś nowego Iphone 20 PRO.</h1>";
    setcookie('52_visits', 0, time() + 3600 * 24 * 30);
}