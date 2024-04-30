<?php

function fetchWeatherData() {
    $url = "https://air-quality-api.open-meteo.com/v1/air-quality?latitude=47.3667,46.9481,47.4239&longitude=8.55,7.4474,9.3748&current=alder_pollen,birch_pollen,grass_pollen&hourly=alder_pollen,birch_pollen,grass_pollen&forecast_days=7";

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