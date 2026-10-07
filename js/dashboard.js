function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]')
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source) {
            checkboxes[i].checked = source.checked
        }
    }
}

function checkDelete(){
    return confirm('🗑️Are you sure you want to delete this Data?')
}

function checkPrompt(){
    return confirm('✔️Confirm?')
}

// SIDEBAR TOGGLE

let sidebarOpen = false;
const sidebar = document.getElementById('sidebar');

function openSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add('sidebar-responsive');
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove('sidebar-responsive');
    sidebarOpen = false;
  }
}

// ---------- CHARTS ----------
const areaChartOptions = {
  // Add your chart options here
  series: [
    {
      name: 'Purchase',
      data: [31, 40, 28, 51, 42, 109, 100],
    },
    {
      name: 'Sale asd',
      data: [11, 32, 45, 32, 34, 52, 41],
    },
  ],
  chart: {
    type: 'area',
    background: 'transparent',
    height: 350,
    stacked: false,
    toolbar: {
      show: false,
    },
  },
  colors: ['#00ab57', '#d50000'],
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
  dataLabels: {
    enabled: false,
  },
  fill: {
    gradient: {
      opacityFrom: 0.4,
      opacityTo: 0.1,
      shadeIntensity: 1,
      stops: [0, 100],
      type: 'vertical',
    },
    type: 'gradient',
  },
  grid: {
    borderColor: '#55596e',
    yaxis: {
      lines: {
        show: true,
      },
    },
    xaxis: {
      lines: {
        show: true,
      },
    },
  },
  legend: {
    labels: {
      colors: '#f5f7ff',
    },
    show: true,
    position: 'top',
  },
  markers: {
    size: 6,
    strokeColors: '#1b2635',
    strokeWidth: 3,
  },
  stroke: {
    curve: 'smooth',
  },
  xaxis: {
    axisBorder: {
      color: '#55596e',
      show: true,
    },
    axisTicks: {
      color: '#55596e',
      show: true,
    },
    labels: {
      offsetY: 5,
      style: {
        colors: '#f5f7ff',
      },
    },
  },
  yaxis: [
    {
      title: {
        text: 'Purchase Assets',
        style: {
          color: '#f5f7ff',
        },
      },
      labels: {
        style: {
          colors: ['#f5f7ff'],
        },
      },
    },
    {
      opposite: true,
      title: {
        text: 'Sale Assets',
        style: {
          color: '#f5f7ff',
        },
      },
      labels: {
        style: {
          colors: ['#f5f7ff'],
        },
      },
    },
  ],
  tooltip: {
    shared: true,
    intersect: false,
    theme: 'dark',
  },
};
const areaChart = new ApexCharts(document.querySelector('#area-chart'), areaChartOptions);
areaChart.render();

fetch('../class/fetch_data.php')
  .then(response => response.json())
  .then(data => {
    const categories = data.map(item => item.assettype);
    const counts = data.map(item => item.count);

    const barChartOptions = {
      series: [{
        name: 'Assets',
        data: counts
      }],
      chart: {
        type: 'bar',
        background: 'transparent',
        height: 350,
        toolbar: {
          show: false
        }
      },
      colors: ['#2962ff', '#d50000', '#2e7d32', '#ff6d00', '#583cb3', '#fff170', '#5cffa0', '#ff94d4'],
      plotOptions: {
        bar: {
          distributed: true,
          borderRadius: 4,
          horizontal: false,
          columnWidth: '40%'
        }
      },
      dataLabels: {
        enabled: false,
      },
      fill: {
        opacity: 1,
      },
      grid: {
        borderColor: '#55596e',
        yaxis: {
          lines: {
            show: true,
          },
        },
        xaxis: {
          lines: {
            show: true,
          },
        },
      },
      legend: {
        labels: {
          colors: '#f5f7ff',
        },
        show: true,
        position: 'top',
      },
      stroke: {
        colors: ['transparent'],
        show: true,
        width: 2,
      },
      tooltip: {
        shared: true,
        intersect: false,
        theme: 'dark',
      },
      xaxis: {
        categories: categories,
        title: {
          style: {
            color: '#f5f7ff',
          },
        },
        axisBorder: {
          show: true,
          color: '#55596e',
        },
        axisTicks: {
          show: true,
          color: '#55596e',
        },
        labels: {
          style: {
            colors: '#f5f7ff',
          },
        },
      },
      yaxis: {
        title: {
          text: 'Count',
          style: {
            color: '#f5f7ff',
          },
        },
        axisBorder: {
          color: '#55596e',
          show: true,
        },
        axisTicks: {
          color: '#55596e',
          show: true,
        },
        labels: {
          style: {
            colors: '#f5f7ff',
          },
        },
      },
    };

  const barChart = new ApexCharts(document.querySelector('#bar-chart'), barChartOptions);
  barChart.render();
})
.catch(error => {
  console.error('Error fetching data:', error);
});
