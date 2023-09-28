const currentDate = new Date();

const formattedDate = currentDate.toLocaleString();

document.getElementById("lastUpdated").textContent = `last updated: ${formattedDate}`;