<h1>Report</h1>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<canvas id="myChart" width="100" height="40"></canvas>
<script>

  function setup() {
    var canvas = document.getElementById("myChart");
    var ctx = canvas.getContext('2d');
    var config = {
      type: 'bar',
      data: {
        //labels: labels,
        datasets: [{
          label: 'Graph Line',
          //data: data,
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

    canvas.onclick = function(evt) {
      var activePoints = chart.getElementsAtEvent(evt);
      if (activePoints[0]) {
        var chartData = activePoints[0]['_chart'].config.data;
        var idx = activePoints[0]['_index'];

        var label = chartData.labels[idx];
        var value = chartData.datasets[0].data[idx];

        fetchData(label, chart, 500);
      }
    };

    return chart;
  }

  // Get data
  function fetchData(category, chart, time) {

    url = "/api/reporting/categories" + (category ? "/" + category : "");

    console.log(url);

    fetch(url)
      .then(response => response.json())
      .then(data => {
        
        var labels = data.map(function(e) {
          return e.category;
        });
        var data = data.map(function(e) {
          return e.sum;
        });

        if (data.length > 0) {
          setData(labels, data, chart, time);
          history.pushState({ labels: labels, data: data }, '');  
        } else {
          window.location = '/transactions/categorized/' + category;
        }

      });
  }

  function setData(labels, data, chart, time) {
    chart.data.labels = labels;
    chart.data.datasets[0].data = data;
    chart.update(time);
  }

  chart = setup();
  fetchData(null, chart, 0);

  window.addEventListener('popstate', (event) => {
    setData(event.state.labels, event.state.data, chart, 500);
  });

</script>

