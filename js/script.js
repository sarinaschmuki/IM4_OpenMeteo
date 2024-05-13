// Asynchrone Funktion zum Abrufen von Daten
async function fetchData(url) {
  try {
    const response = await fetch(url);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching data:', error);
    return null; // Return null to handle errors where the data is expected
  }
}

// Farben basierend auf Pollenanzahl definieren
const pollenColors = {
  0: '#AAAAAA',    // Keine Pollenaktivität
  1: '#C7E0C9',    // Geringe Aktivität (1-25 no/m3)
  25: '#9AB59C',   // Mittlere Aktivität (26-50 no/m3)
  50: '#586B5A'    // Hohe Aktivität (>50 no/m3)
};

// Variable, um den zuletzt ausgewählten Kanton zu speichern
let lastSelectedKanton = null;

// Funktion zum Einfärben der Karte basierend auf Pollendaten
async function colorMap(selectedDate, selectedPollenType) {
  const url = 'https://374887-3.web.fhgr.ch/php/unload.php';
  const data = await fetchData(url);

  if (!data) {
    console.error('No data available to color the map');
    return;
  }

  const svgDocument = document.querySelector('svg');
  
  // Sicherstellen, dass alle Kantone auf die Standardfarbe zurückgesetzt werden
  document.querySelectorAll('.st2').forEach(kantonElement => {
    kantonElement.style.fill = pollenColors[0];
    if (kantonElement.parentNode.querySelector('.st1')) {
      kantonElement.parentNode.querySelector('.st1').style.stroke = "";
      kantonElement.parentNode.querySelector('.st1').style.strokeWidth = "";
    }
  });

  Object.keys(data).forEach(kanton => {
    const kantonData = data[kanton][selectedDate] || {};
    const pollenLevel = kantonData[selectedPollenType];

    let color = pollenColors[0]; // Standardfarbe für keine Pollenaktivität
    if (pollenLevel > 50) {
      color = pollenColors[50];
    } else if (pollenLevel > 25) {
      color = pollenColors[25];
    } else if (pollenLevel > 0) {
      color = pollenColors[1];
    }

    const kantonElement = svgDocument.getElementById(kanton);
    if (kantonElement) {
      kantonElement.style.fill = color;
    }
  });
}

// Event Listener für die Dropdowns zur Aktualisierung der Karte
function updateMapFromDropdowns() {
  const selectedDate = document.getElementById('dateSelect').value;
  const selectedPollenType = document.getElementById('pollenTypeSelect').value;
  colorMap(selectedDate, selectedPollenType);
}

document.getElementById('pollenTypeSelect').addEventListener('change', updateMapFromDropdowns);
document.getElementById('dateSelect').addEventListener('change', updateMapFromDropdowns);

// Funktion zum Füllen des Datum-Dropdowns basierend auf verfügbaren Daten
async function fillDateDropdown() {
  const data = await fetchData('https://374887-3.web.fhgr.ch/php/unload.php');
  
  if (!data) {
    console.error('No data available to fill the date dropdown');
    return;
  }

  const dateSelect = document.getElementById('dateSelect');
  let uniqueDates = new Set();
  
  Object.keys(data).forEach(kanton => {
    Object.keys(data[kanton]).forEach(date => {
      uniqueDates.add(date);
    });
  });

  uniqueDates = Array.from(uniqueDates).sort();

  dateSelect.innerHTML = ''; // Clear existing options
  uniqueDates.forEach(date => {
    const option = document.createElement('option');
    option.value = date;
    option.innerText = date;
    dateSelect.appendChild(option);
  });

  if (uniqueDates.length > 0) {
    dateSelect.value = uniqueDates[0];
    updateMapFromDropdowns(); // Initial update after filling the dropdown
  }
}

// Initialisierung der Anwendung beim Laden
async function init() {
  await fillDateDropdown();
}

init();

// Funktion zum Anzeigen der Pollendetails beim Klicken auf einen Kanton
document.querySelectorAll('.st2').forEach(kantonElement => {
  kantonElement.addEventListener('click', async () => {
    const kanton = kantonElement.id;
    const selectedDate = document.getElementById('dateSelect').value;
    const selectedPollenType = document.getElementById('pollenTypeSelect').value;
    const data = await fetchData('https://374887-3.web.fhgr.ch/php/unload.php');

    if (data && data[kanton] && data[kanton][selectedDate]) {
      const details = data[kanton][selectedDate][selectedPollenType];
      const infoText = details !== undefined ? `${details}` : 'Keine Daten verfügbar.';
      document.getElementById('infoText').innerText = infoText;
      document.getElementById('pollenInfo').classList.remove('hidden');

      // Reset previous selected kanton's outline
      if (lastSelectedKanton && document.getElementById(lastSelectedKanton)) {
        const lastKantonPath = document.getElementById(lastSelectedKanton);
        lastKantonPath.style.stroke = "";
        lastKantonPath.style.strokeWidth = "";s
      }

      // Set new selected kanton outline
      kantonElement.style.stroke = "#333"; // Schwarz
      kantonElement.style.strokeWidth = "8"; // Dicke der Umrandung

      lastSelectedKanton = kanton; // Update the last selected kanton
    }
  });
});
