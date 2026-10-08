/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
var newLabels = typeof(viewsChart)!='undefined'?viewsChart.dates:['null', 'null', 'null', 'null', 'null', 'null', 'null'];
var newData = typeof(viewsChart)!='undefined'?viewsChart.values:[1,10,0,0,0,0,0];

function getConfig(dataSets,LabelGroup){
  return {
    type: 'line',
    data: {
      labels: LabelGroup,
      datasets: [
        {
          label: 'Views',
          fill: false,
          /**
           * These colors come from Tailwind CSS palette
           * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
           */
          backgroundColor: '#FF2056',
          borderColor: '#FF2056',
          data: dataSets,
        },
      ],
    },
  
    options: {
      responsive: true,
      /**
       * Default legends are ugly and impossible to style.
       * See examples in charts.html to add your own legends
       *  */
      legend: {
        display: true,
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true,
      }, 
      scales: {
        x: {
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Month',
          },
        },
        y: {
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Value',
          },
        },
      },
    },
  }
}



function doubleConfig(dataSets,LabelGroup){
  return {
    type: 'line',
    data: {
      labels: LabelGroup,
      datasets: [
        {
          label: 'Downloads',
          fill: false,
          /**
           * These colors come from Tailwind CSS palette
           * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
           */
          backgroundColor: '#0694a2',
          borderColor: '#0694a2',
          data: dataSets[0],
        },
        {
          label: 'API Requests',
          fill: false,
          /**
           * These colors come from Tailwind CSS palette
           * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
           */
          backgroundColor: '#FF5A1F',
          borderColor: '#FF5A1F',
          data: dataSets[1],
        },
        
      ],
    },
  
    options: {
      responsive: true,
      /**
       * Default legends are ugly and impossible to style.
       * See examples in charts.html to add your own legends
       *  */
      legend: {
        display: true,
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true,
      }, 
      scales: {
        x: {
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Month',
          },
        },
        y: {
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Value',
          },
        },
      },
    },
  }
}

const lineConfig = getConfig(newData,newLabels);

// change this to the id of your chart element in HMTL
const config2 = doubleConfig([downloadChart.values,downloadChart.apiValues],downloadChart.dates);

const lineDownloads = document.getElementById('lineDownloads');
const lineCtx = document.getElementById('line');
if(lineDownloads){
  window.myLine = new Chart(lineDownloads,config2);
}

if(lineCtx){
  window.myLine = new Chart(lineCtx, lineConfig)
}


