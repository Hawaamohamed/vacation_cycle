var ctx= document.getElementById("dochart").getContext("2d");

var config={
    type: 'doughnut',
    data: {
        labels: ["classes",	"trainers"],
        datasets: [{    
            data: [70,	30], // Specify the data values array
          
            // Add custom color border 
           // backgroundColor: ['#9ed5f2', '#f7abab'] // Add custom color background (Points and Fill)
           backgroundColor:['#0dc2f5','#bd5473']
        }]},         
    options: {
        legend: {
         
             position: 'bottom', // place legend on the right side of chart
             align:'center'
            },
        label:'bottom',
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false,
      usePointStyle: true,// Add to prevent default behaviour of full-width/height 
      cutoutPercentage: 80,
     
    },
    centerText: {
        display: true,
        text:"80"
       
    }
};
Chart.Chart.pluginService.register({
    beforeDraw: function(chart) {
        if (chart.config.centerText.display !== null &&
            typeof chart.config.centerText.display !== 'undefined' &&
            chart.config.centerText.display) {
            drawTotals(chart);
        }
    },
});


function drawTotals(chart) {
 
    var width = chart.chart.width,
    height = chart.chart.height,
    ctx = chart.chart.ctx;
 
    ctx.restore();
    var fontSize = (height / 114).toFixed(2);
    ctx.font = fontSize + "em sans-serif";
    ctx.textBaseline = "middle";
 
    var text = chart.config.centerText.text,
    textX = Math.round((width - ctx.measureText(text).width) / 2),
    textY = height / 2;
 
    ctx.fillText(text, textX, textY);
    ctx.save();
}

window.onload = function() {
   
    window.myDoughnut = new Chart(ctx, config);
};

