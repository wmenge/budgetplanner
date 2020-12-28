<h1>Report</h1>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<canvas id="myChart" width="100" height="40"></canvas>
<script>

// Get data
async function fetchData() {
  fetch('/api/reporting/categories')
    .then(response => response.json())
    .then(data => {
      console.log(data)



  //console
  // waits until the request completes...
  //console.log(response.json());
    var labels = data.map(function(e) {
     return e.category;
  });
  var data = data.map(function(e) {
     return e.sum;
  });

  //var ctx = canvas.getContext('2d');
  var ctx = document.getElementById('myChart').getContext('2d');
var config = {
   type: 'bar',
   data: {
      labels: labels,
      datasets: [{
         label: 'Graph Line',
         data: data,
         backgroundColor: 'rgba(0, 119, 204, 0.3)'
      }]
   },
   options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
};



var chart = new Chart(ctx, config);
});
}


fetchData();

//console.log(response);

/*
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            //label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            /*backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],*/
            //borderWidth: 1
       /* }]
    }//,
    /*options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }*/
//});
</script>

