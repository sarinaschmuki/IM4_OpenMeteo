<?php

function fetchWeatherData() {
    $url = "https://air-quality-api.open-meteo.com/v1/air-quality?latitude=47.3667,46.9481,47.4239,47.5584,47.4845,47.1724,46.2274,46.516,46.8804,46.1928,47.5578,47.2079,47.0208,47.6973,46.8961,46.9581,46.9918,47.0505,47.3649,46.8499,47.0406,46.2376,46.8024,47.331,47.3862,47.3925&longitude=8.55,7.4474,9.3748,7.5733,7.7345,8.5175,7.3556,6.6328,8.6444,9.017,8.8989,7.5371,8.6541,8.6349,8.2453,8.3661,6.931,8.3064,7.3445,9.5329,9.068,6.1092,7.1513,9.41,9.2792,8.0442&current=alder_pollen,birch_pollen,grass_pollen&hourly=alder_pollen,birch_pollen,grass_pollen&forecast_days=7";

    // Initialisiert eine cURL-Sitzung
    $ch = curl_init($url);

    // Setzt Optionen
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Führt die cURL-Sitzung aus und erhält den Inhalt
    $response = curl_exec($ch);

    // Schließt die cURL-Sitzung
    curl_close($ch);

    // Dekodiert die JSON-Antwort und gibt Daten zurück
return json_decode($response, true);
//echo $response ; 
}

// Gibt die Daten zurück, wenn dieses Skript eingebunden ist
return fetchWeatherData();
?>