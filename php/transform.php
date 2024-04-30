<?php

// Bindet das Skript 130_extract.php für Rohdaten ein
$data = include('extract.php');

// Beispiel für die Definition eines Standort-Mappings
$locationsMap = [
    '47.35,8.549999' => 'Zürich',
    '46.949997,7.450001' => 'Bern',
    '47.449997,9.349998' => 'St. Gallen',
// '47.549995,7.549999' => 'Basel',
//'47.449997,7.75' => 'Basel-Land',

//'47.449997,9.349998' => 'Zug',
//'47.449997,9.349998' => 'Wallis',
//'47.449997,9.349998' => 'Waadt',
//'47.449997,9.349998' => 'Uri',
//'47.449997,9.349998' => 'Tessin',
//'47.449997,9.349998' => 'Thurgau',
//'47.449997,9.349998' => 'Solothurn',
//'47.449997,9.349998' => 'Schwyz',
//'47.449997,9.349998' => 'Schaffhausen',
//'47.449997,9.349998' => 'Obwalden',
//'47.449997,9.349998' => 'Nidwalden',
//'47.449997,9.349998' => 'Neuenburg',
//'47.449997,9.349998' => 'Luzern',
//'47.449997,9.349998' => 'Jura',
//'47.449997,9.349998' => 'Graubünden',
//'47.449997,9.349998' => 'Glarus',
//'47.449997,9.349998' => 'Genf',
//'47.449997,9.349998' => 'Fribourg'
//'47.449997,9.349998' => 'Appenzell Innerrhoden',
//'47.449997,9.349998' => 'Appenzell Ausserhoden',
//'47.449997,9.349998' => 'Aargau', 




];

// Initialisiert ein Array, um die transformierten Daten zu speichern
$transformedData = [];

// Transformiert und fügt die notwendigen Informationen hinzu

foreach ($data as $location) {
    // Bestimmt den Stadtnamen anhand von Breitengrad und Längengrad
    $cityKey = $location['latitude'] . ',' . $location['longitude'];
    $city = $locationsMap[$cityKey] ?? 'Unbekannt';

    // Konstruiert die neue Struktur mit nur Pollendaten
    $transformedData[] = [
        'location' => $city,
        'time' => $location['current']['time'],
        'pollen_counts' => [
            'alder' => $location['current']['alder_pollen'],
            'birch' => $location['current']['birch_pollen'],
            'grass' => $location['current']['grass_pollen']
        ]
    ];
}

// Kodiert die transformierten Daten in JSON
$jsonData = json_encode($transformedData, JSON_PRETTY_PRINT);

// Gibt die JSON-Daten zurück, anstatt sie auszugeben
return $jsonData;