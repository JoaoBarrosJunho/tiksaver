/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
var newLabels = typeof(datesM)!='undefined'?datesM:['null', 'null', 'null', 'null', 'null', 'null', 'null'];
var newData = typeof(dataChart)!='undefined'?dataChart:[1,10,0,0,0,0,0];
const barConfig = {
  type: 'bar',
  data: {
    labels: newLabels,
    datasets: [
      {
        label: 'Views',
        backgroundColor: '#FF2056',
        //borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: newData,
      },
    ],
  },
  options: {
    responsive: true,
    legend: {
      display: false,
    },
  },
}

const barsCtx = document.getElementById('bars')
window.myBar = new Chart(barsCtx, barConfig)
