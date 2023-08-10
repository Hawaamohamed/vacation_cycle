let mychart = document.getElementById("mychart").getContext("2d");
var chart = new Chart(mychart, {
  type: 'bar',
  data: {
     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'], // responsible for how many bars are gonna show on the chart
     // create 12 datasets, since we have 12 items
     // data[0] = labels[0] (data for first bar - 'Standing costs') | data[1] = labels[1] (data for second bar - 'Running costs')
     // put 0, if there is no data for the particular bar
     datasets: [{
      label: 'License',backgroundColor:'white',
        data: [2, 8,6,8,9,12,9,9,10,7,6,6],
        backgroundColor: '#2f80ed'
     }, {
      label: 'Visa',backgroundColor:'white',
        data: [3, 9,5,7,5,10,4,7,3,8,0,1],
        backgroundColor: '#ffaa05'
     }, {
         label: 'Other',backgroundColor:'white',
        data: [5, 1,6,7,8,7,4,1,6,5,8,8,1],
        backgroundColor: '#63ef93'
      
    }]
      },
    

options: {
   responsive: false,
   legend: {
     display:false,
      position: 'right' // place legend on the right side of chart
   },
   scales: {
    xAxes: [{
       stacked: true // this should be set to make the bars stacked
    }],
    yAxes: [{
       stacked: true, // this also..
       display:false
    }]
 }
}
});