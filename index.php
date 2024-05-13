<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
        <div class="wrapper">
            <div class="container">
      <!-- Logo Container in anderen Container einbinden -->
      <div class="logo-container">
        <img class="logo" src="Bilder/Logo_Pollenpuls.png"PollenPuls Logo>
    </div>
<h1>Pollenaktivität Schweiz</h1>
    <h2>In welcher Umgebung heute wandern?</h2>
    <select id="pollenTypeSelect" required>
        <option value="" disabled selected>Pollenart auswählen</option>
        <option value="alder_pollen">Erlenpollen</option>
        <option value="birch_pollen">Birkenpollen</option>
        <option value="grass_pollen">Graspollen</option>
    </select>
    <select id="dateSelect" required>
        <option value="" disabled selected>Datum</option>
    </select>
    <div class="karte-container">
        <!--<object class="karte" type="image/svg+xml" data="Bilder/Karte.svg" id="svgMap"></object>-->
        <?php 
            echo file_get_contents('Bilder/Karte.svg');
        ?>
    </div>
    <div id="pollenInfo" class="pollen-info hidden">
        <h2>Pollen Details</h2>
        <p id="infoText"></p>
    </div>
    <main> 
        <div>
            <canvas id="pollenAlarm"></canvas>
          </div>
          <!-- Legende für Pollenaktivität -->
<div class="legend">
    <div class="legend-item">
        <span class="color-box" style="background-color: #AAAAAA;"></span>
        <span class="description">Keine Pollenaktivität</span>
    </div>
    <div class="legend-item">
        <span class="color-box" style="background-color: #C7E0C9;"></span>
        <span class="description">Gering 1-25 no/m3</span>
    </div>
    <div class="legend-item">
        <span class="color-box" style="background-color: #9AB59C;"></span>
        <span class="description">Mittel 25-50 no/m3</span>
    </div>
    <div class="legend-item">
        <span class="color-box" style="background-color: #586B5A;"></span>
        <span class="description">Stark ab 50 no/m3</span>
    </div>
</div>
    </main>
    
    <footer>

    </footer>
    <script src="js/script.js"></script>
    
</body>
</html>