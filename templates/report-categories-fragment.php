<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<canvas id="myChart"></canvas>
<script>

  var monthSelect = document.getElementById("month");
  
  state = {
    filter: {
      sign: '<?= $type == 'expenses' ? '-' : '+' ?>',
      category_id: '',
      month: monthSelect.value,  
    },
    data: null
  };

  console.log(state);

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

  function setup() {
    var canvas = document.getElementById("myChart");
    var ctx = canvas.getContext('2d');
    var config = {
      type: 'doughnut',
      data: {
        datasets: []
      }
    };

    var chart = new Chart(ctx, config);

    canvas.onclick = function(evt) {
      var activePoints = chart.getElementsAtEvent(evt);
      if (activePoints[0]) {
        var chartData = activePoints[0]['_chart'].config.data;
        var idx = activePoints[0]['_index'];
        state.filter.category_id = state.data[idx].id;
        fetchData(state.filter);
      }
    };

    return chart;
  }

  function filter(select) {
      console.log(select.name + " has changed. The new value is: " + select.value);
      state.filter.month = select.value;
      fetchData(state.filter);
  }

  // Get data
  function fetchData(filter) {
    url = buildUrl('/api/reporting/categories', state.filter);
    fethDataFromUrl(url);
  }

  function fethDataFromUrl(url) {

    console.log(url.toString());

    fetch(url)
      .then(response => response.json())
      .then(data => {

        state.data = data;
        
        var labels = data.map(function(e) {
          return e.category;
        });
        var data = data.map(function(e) {
          return e.sum;
        });

        
        console.log(state);

        if (data.length > 0) {
          chart.data.labels = labels;
          chart.data.datasets = [];
          addData(data, chart);
          chart.update();
          history.pushState(url.toString(), '');  
        } else {
          console.log('need to navigate');
          console.log(state);
          window.location = buildUrl('/transactions/categorized', state.filter);
        }

      });
  }

  function buildUrl(path, queryParams) {
    let url = new URL(path, window.location.origin);

    for (const [key, value] of Object.entries(queryParams)) {
      url.searchParams.append(key, value);
    }

    return url;
  }

  function addData(data, chart) {
    chart.data.datasets.push({ data: data, backgroundColor: colorScheme });
  }

  chart = setup();
  fetchData(state);

  window.addEventListener('popstate', (event) => {
    fethDataFromUrl(event.state);
    chart.update();
  });

</script>

