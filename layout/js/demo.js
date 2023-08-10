Chart.defaults.global.legend.labels.usePointStyle = true;
let chart= document.getElementById("MyChart").getContext("2d");



let masschart= new Chart( chart ,{
  type:'bar',
  data:{
labels: ['jan', 'feb', 'mar', 'apr', 'may','jun','july','aug','sep','oct','nov','dec'],
datasets:[{
label:'Cost',
data:['90' , '70' ,'50' ,'30','15','20','40', '60', '20', '60', '30', '58'],
backgroundColor: "#0dc2f5",
 
}]
  },
 
  options:({
    legend: {
      labels: {
        fontColor: '#0dc2f5'
     }
  },
  scales: {
    xAxes: [{
     
      barPercentage: 0.4,
    
      labels:false,
      ticks: {
        beginAtZero: true,
        maxRotation: 0,
        minRotation: 0
      },
      gridLines: {
        display: false
    }
    }],
    yAxes: [{
      barPercentage: 0.4,
      labels:false,
      ticks:{
        display:false
     },
      gridLines: {
        display: false
    }
    }]
 
   
        
    
    },
    plugins: {
      p1: false   // disable plugin 'p1' for this instance
  }
  }),
  centerText: {
    display: false,
   
}

});


