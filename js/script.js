// Asynchronous function to fetch data
async function fetchData(url) {
  try {
    const response = await fetch(url);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching data:', error);
    return null;
  }
}

// Colors based on pollen count
const pollenColors = {
  0: '#AAAAAA',    // No pollen activity
  1: '#C7E0C9',    // Low activity (1-25 no/m3)
  25: '#9AB59C',   // Moderate activity (26-50 no/m3)
  50: '#586B5A'    // High activity (>50 no/m3)
};

// Variable to store the last selected canton
let lastSelectedKanton = null;

// Function to color the map based on pollen data
async function colorMap(selectedDate, selectedPollenType) {
  const selectedHour = document.getElementById('hourSelect').value;
  const dateTime = `${selectedDate} ${selectedHour}:00:00`;
  const url = `https://374887-3.web.fhgr.ch/php/unload.php?date=${encodeURIComponent(selectedDate)}&hour=${encodeURIComponent(selectedHour)}&pollenType=${encodeURIComponent(selectedPollenType)}`;

  const data = await fetchData(url);
  if (!data) {
    console.error('No data available to color the map');
    return;
  }

  const svgDocument = document.querySelector('svg');
  document.querySelectorAll('.st2').forEach(kantonElement => {
    kantonElement.style.fill = pollenColors[0]; // Reset color
    kantonElement.style.stroke = ""; // Reset outline
    kantonElement.style.strokeWidth = "";
  });

  Object.keys(data).forEach(kanton => {
    const kantonData = data[kanton];
    const pollenLevel = kantonData[dateTime] && kantonData[dateTime][selectedPollenType];
    let color = pollenColors[0]; // Default color
    if (pollenLevel > 50) {
      color = pollenColors[50];
    } else if (pollenLevel > 25) {
      color = pollenColors[25];
    } else if (pollenLevel > 0) {
      color = pollenColors[1];
    }

    const kantonElement = svgDocument.getElementById(kanton);
    if (kantonElement) {
      kantonElement.style.fill = color; // Apply color
    }
  });
}

// Function to update the map from selected radio buttons and date/time
function updateMapFromSelection() {
  const selectedDate = document.getElementById('dateSelect').value;
  console.log("Selected Date:", selectedDate);
  const selectedPollenType = document.querySelector('.pollen-checkbox:checked').value;
  if (selectedDate) {
    colorMap(selectedDate, selectedPollenType);
  }
}


document.querySelectorAll('.pollen-checkbox, #dateSelect, #hourSelect').forEach(element => {
  element.addEventListener('change', updateMapFromSelection);
});

// Initialization of the application on load
async function init() {
  await fillDateDropdown();
  updateMapFromSelection();
}

init();
document.getElementById('pollenTypeSelect').addEventListener('change', updateMapFromSelection);
document.getElementById('dateSelect').addEventListener('change', updateMapFromSelection);

// Click event on kanton to show details
document.querySelectorAll('.st2').forEach(kantonElement => {
  kantonElement.addEventListener('click', async function() {
    const kanton = this.id; // 'this' refers to kantonElement inside the event listener
    const selectedDate = document.getElementById('dateSelect').value;
    const selectedHour = document.getElementById('hourSelect').value;
    const selectedPollenType = document.querySelector('.pollen-checkbox:checked').value;
    const dateTime = `${selectedDate} ${selectedHour}:00:00`;
    const url = `https://374887-3.web.fhgr.ch/php/unload.php?date=${encodeURIComponent(selectedDate)}&hour=${encodeURIComponent(selectedHour)}&pollenType=${encodeURIComponent(selectedPollenType)}`;

    const data = await fetchData(url);

    if (data && data[kanton] && data[kanton][dateTime]) {
      const details = data[kanton][dateTime][selectedPollenType];
      document.getElementById('infoText').innerText = `${details} no/m3`;
      document.getElementById('pollenInfo').classList.remove('hidden');

      if (lastSelectedKanton) {
        const lastKantonElement = document.getElementById(lastSelectedKanton);
        if (lastKantonElement) {
          lastKantonElement.style.stroke = ""; // Reset previous outline
          lastKantonElement.style.strokeWidth = "";
        }
      }

      this.style.stroke = "#000000"; // Highlight new kanton
      this.style.strokeWidth = "5";
      lastSelectedKanton = kanton;
    }
  });
});

// Function to fill the date dropdown based on available data
async function fillDateDropdown() {
  const data = await fetchData('https://374887-3.web.fhgr.ch/php/unload.php');
  if (!data) {
    console.error('No data available to fill the date dropdown');
    return;
  }

  const dateSelect = document.getElementById('dateSelect');
  let uniqueDates = new Set();

  Object.keys(data).forEach(kanton => {
    Object.keys(data[kanton]).forEach(datetime => {
      const datePart = datetime.split('T')[0]; // Extract the date part from the datetime
      uniqueDates.add(datePart);
    });
  });

  uniqueDates = Array.from(uniqueDates).sort();
  dateSelect.innerHTML = '<option value="" disabled selected>Datum wählen</option>';
  uniqueDates.forEach(date => {
    const option = document.createElement('option');
    option.value = date;
    option.innerText = date;
    dateSelect.appendChild(option);
  });

  /*if (uniqueDates.length > 0) {
    dateSelect.value = uniqueDates[0];
    updateMapFromSelection();
  }*/
}
