/* globals Chart:false */

(() => {
  "use strict";

  // Graphs
  const ctx = document.getElementById("myChart");
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      datasets: [
        {
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "#007bff",
          borderWidth: 4,
          pointBackgroundColor: "#007bff",
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          boxPadding: 3,
        },
      },
    },
  });
})();


data: { "labels": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], "datasets": [{ "data": ["100.00", "150.50", "200.25", "180.75", "190.80", "220.40", "120.60"], "lineTension": 0, "backgroundColor": "transparent", "borderColor": "#007bff", "borderWidth": 4, "pointBackgroundColor": "#007bff" }] }
