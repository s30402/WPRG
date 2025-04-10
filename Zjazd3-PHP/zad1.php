<?php
if (isset($_GET['dob']) && !empty($_GET['dob'])) {
    $dob = $_GET['dob'];
    
    $birthDate = DateTime::createFromFormat("Y-m-d", $dob);
    if (!$birthDate) {
        echo "Invalid date format.";
        exit;
    }

    function getBirthDayOfWeek($date) {
        return $date -> format('l'); 
    }

    function getCompletedYears($birthDate) {
        $today = new DateTime();
        $age = $today -> diff($birthDate);
        return $age -> y;
    }

    function getDaysToNextBirthday($birthDate) {
        $today = new DateTime();
        
        $birthdayThisYear = DateTime::createFromFormat(
            "Y-m-d",
            $today->format("Y") . '-' . $birthDate->format("m-d")
        );
        
        if ($birthdayThisYear < $today) {
            $birthdayThisYear->modify('+1 year');
        }
        $interval = $today->diff($birthdayThisYear);
        return $interval->days;
    }

    $days = array(
        'Sunday'    => 'Niedziela',
        'Monday'    => 'Poniedziałek',
        'Tuesday'   => 'Wtorek',
        'Wednesday' => 'Środa',
        'Thursday'  => 'Czwartek',
        'Friday'    => 'Piątek',
        'Saturday'  => 'Sobota'
    );
    
    $dayOfWeek       = getBirthDayOfWeek($birthDate);
    $dayOfWeek       = isset($days[$dayOfWeek]) ? $days[$dayOfWeek] : $dayOfWeek;

    $completedYears  = getCompletedYears($birthDate);
    $daysToBirthday  = getDaysToNextBirthday($birthDate);

    
    echo "<h2>Twoje informacje o urodzinach</h2>";
    echo "<p>Urodziłeś się w <strong>{$dayOfWeek}</strong>.</p>";
    echo "<p>Przeżyłeś aż <strong>{$completedYears}</strong> lat.</p>";
    echo "<p>Zostało <strong>{$daysToBirthday}</strong> dni do twoich następnych urodzin.</p>";

} else {
    echo "No birth date provided.";
}
?>
