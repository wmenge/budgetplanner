<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

  <canvas id="myChart"></canvas>

<script>

  const colorScheme = [
    "#25CCF7","#FD7272","#54a0ff","#00d2d3",
    "#1abc9c","#2ecc71","#3498db","#9b59b6","#34495e",
    "#16a085","#27ae60","#2980b9","#8e44ad","#2c3e50",
    "#f1c40f","#e67e22","#e74c3c","#ecf0f1","#95a5a6",
    "#f39c12","#d35400","#c0392b","#bdc3c7","#7f8c8d",
    "#55efc4","#81ecec","#74b9ff","#a29bfe","#dfe6e9",
    "#00b894","#00cec9","#0984e3","#6c5ce7","#ffeaa7",
    "#fab1a0","#ff7675","#fd79a8","#fdcb6e","#e17055",
    "#d63031","#feca57","#5f27cd","#54a0ff","#01a3a4"
  ];

  window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
  };

  function setup() {
    var canvas = document.getElementById("myChart");
    var ctx = canvas.getContext('2d');
    var config = {
      type: 'bar',
      /*options: {
        responsive: true,
        maintainAspectRatio: false
      },*/
      data: {
        datasets: []
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
      var myChart = chart.getElementAtEvent(evt)[0];
      var index = myChart._index;
      var datasetIndex = myChart._datasetIndex;
      var chartData = myChart['_chart'].config.data;
      var month = chartData.labels[index];
      var type = chartData.datasets[datasetIndex].label;

      document.location = `/reporting/${type}/${month}`.toLowerCase();
    };

    return chart;
  }

  // Get data
  function fetchData(category, chart, time) {

// /..type = '<?= $type ?>';
    
    /*url = 
      "/api/reporting/categories" + 
      (category ? "/" + category : "") + 
      '?sign=' + (type == 'expenses' ? '-' : '%2B');*/

    url = "/api/reporting/periods"

    console.log(url);

    fetch(url)
      .then(response => response.json())
      .then(data => {
        
        var labels = data.map(function(e) {
          return e.period;
        });

        labels = labels.filter((item, index) => labels.indexOf(item) == index);

        //console.log(labels);

        var dataIncome = data.filter(i => (i.sign == '+')).map(i => i.sum);
        var dataExpenses = data.filter(i => (i.sign == '-')).map(i => i.sum);


        if (data.length > 0) {
          chart.data.labels = labels;
          
          chart.data.datasets = [];
          chart.data.datasets.push({ label: 'Income', data: dataIncome, backgroundColor: window.chartColors.blue });
          chart.data.datasets.push({ label: 'Expenses', data: dataExpenses, backgroundColor: window.chartColors.red });
          
          chart.update(time);
          history.pushState({ labels: labels, data: data }, '');  
        } else {
          window.location = '/transactions/categorized/' + category;
        }

      });
  }

  function addData(label, data, chart) {
    //chart.data.datasets[0].data = data;
    //chart.data.datasets.push({ label: label, data: data, backgroundColor: 'red' });
  }

  chart = setup();
  fetchData(null, chart, 500);

  window.addEventListener('popstate', (event) => {
    setData(event.state.labels, event.state.data, chart, 500);
  });

</script>

