<?php

// Datenbankkonfiguration einbinden
require_once 'config.php';

// Header setzen, um JSON-Inhaltstyp zurückzugeben
header('Content-Type: application/json');

try {
    // Erstellt eine neue PDO-Instanz mit der Konfiguration aus config.php
    $pdo = new PDO($dsn, $username, $password, $options);

    // SQL-Query, um Daten basierend auf dem Standort auszuwählen, sortiert nach Zeitstempel
    $sql = "SELECT * FROM PollenData ORDER BY location, time";

    // Bereitet die SQL-Anweisung vor
    $stmt = $pdo->prepare($sql);

    // Führt die Abfrage aus
    $stmt->execute();

    // Holt alle passenden Einträge
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Umstrukturierung der Ergebnisse in ein assoziatives Array, wobei jeder Standort und jede Zeit ein eigenes Node ist
    $structuredResults = [];
    foreach ($results as $row) {
        $location = $row['location'];
        $time = $row['time'];
        if (!isset($structuredResults[$location])) {
            $structuredResults[$location] = [];
        }
        $structuredResults[$location][$time] = [
            'alder_pollen' => $row['alder_pollen'],
            'birch_pollen' => $row['birch_pollen'],
            'grass_pollen' => $row['grass_pollen']
        ];
    }

    // Gibt die Ergebnisse im JSON-Format zurück
    echo json_encode($structuredResults);
} catch (PDOException $e) {
    // Gibt eine Fehlermeldung zurück, wenn etwas schiefgeht
    echo json_encode(['error' => $e->getMessage()]);
}
?>
