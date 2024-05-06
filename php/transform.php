<?php

// Bindet das Skript 130_extract.php für Rohdaten ein
$data = include('extract.php');

// Beispiel für die Definition eines Standort-Mappings
$locationsMap = [
    '47.35,8.549999' => 'Zürich',
    '46.949997,7.450001' => 'Bern',
    '47.449997,9.349998' => 'St. Gallen',
    '47.549995,7.549999' => 'Basel',
    '47.449997,7.75' => 'Basel-Land',
    '47.149994,8.549999' => 'Zug',
    '46.249996,7.3499985' => 'Wallis',
    '46.549995,6.6499996' => 'Waadt',
    '46.85,8.650002' => 'Uri',
    '46.149994,9.049999' => 'Tessin',
    '47.549995,8.849998' => 'Thurgau',
    '47.249996,7.549999' => 'Solothurn',
    '47.049995,8.650002' => 'Schwyz',
    '47.649994,8.650002' => 'Schaffhausen',
    '46.85,8.25' => 'Obwalden',
    '46.949997,8.349998' => 'Nidwalden',
    '46.949997,6.949999' => 'Neuenburg',
    '47.049995,8.349998' => 'Luzern',
    '47.35,7.3499985' => 'Jura',
	'46.85,9.549999' => 'Graubünden',
    '47.049995,9.049999' => 'Glarus',
    '46.249996,6.1499996' => 'Genf',
    '46.85,7.1500015' => 'Fribourg',
    '47.35,9.450001' => 'Appenzell Innerrhoden',
    '47.35,9.25' => 'Appenzell Ausserhoden',
    '47.35,8.049999' => 'Aargau',
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