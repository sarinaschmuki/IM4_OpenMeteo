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
            <div class="logo-container">
                <img class="logo" src="Bilder/Logo_Pollenpuls.png" alt="PollenPuls Logo">
            </div>
            <h1>Pollenaktivität Schweiz</h1>
            <h2>Wandern gehen ohne Heuschnupfen.</h2>
            <div id="pollenTypeSelect">
                <label><input type="radio" name="pollenType" value="alder_pollen" class="pollen-checkbox"> Erlenpollen</label>
                <label><input type="radio" name="pollenType" value="birch_pollen" class="pollen-checkbox" checked> Birkenpollen</label>
                <label><input type="radio" name="pollenType" value="grass_pollen" class="pollen-checkbox"> Graspollen</label>
            </div>

            <!-- Date selection as a calendar input -->
            <label for="dateSelect"></label>
            <input type="date" id="dateSelect" required>

            <!-- Hour selection -->
            <label for="hourSelect"></label>
            <select id="hourSelect">
                <option value="00">00:00</option>
                <option value="01">01:00</option>
                <option value="02">02:00</option>
                <option value="03">03:00</option>
                <option value="04">04:00</option>
                <option value="05">05:00</option>
                <option value="06">06:00</option>
                <option value="07">07:00</option>
                <option value="08">08:00</option>
                <option value="09">09:00</option>
                <option value="10">10:00</option>
                <option value="11">11:00</option>
                <option value="12">12:00</option>
                <option value="13">13:00</option>
                <option value="14">14:00</option>
                <option value="15">15:00</option>
                <option value="16">16:00</option>
                <option value="17">17:00</option>
                <option value="18">18:00</option>
                <option value="19">19:00</option>
                <option value="20">20:00</option>
                <option value="21">21:00</option>
                <option value="22">22:00</option>
                <option value="23">23:00</option>
            </select>

            <div class="karte-container">
                <!-- SVG map -->
                <?php echo file_get_contents('Bilder/Karte.svg'); ?>
            </div>
            <div id="pollenInfo" class="pollen-info hidden">
                <h2>Pollenbelastung pro m&sup3</h2>
                <p id="infoText"></p>
            </div>
            <main>
                <!-- Legend for pollen activity -->
                <div class="legend">
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #AAAAAA;"></span>
                        <span class="description">Keine Pollenaktivität</span>
                    </div>
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #C7E0C9;"></span>
                        <span class="description">Gering 1-25 no/m&sup3</span>
                    </div>
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #9AB59C;"></span>
                        <span class="description">Mittel 25-50 no/m&sup3</span>
                    </div>
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #586B5A;"></span>
                        <span class="description">Stark ab 50 no/m&sup3</span>
                    </div>
                </div>
            </main>
            <footer></footer>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
