// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Capsul", "Jarum", "Furniture", "Cabinet", "Alkohol", "Perban", "Paracetamol", "Gunting", "Baskom", "Perban"],
    datasets: [{
      data: [20, 10, 5, 15, 8, 12, 11, 9, 3, 7],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#e67e22', '#34495e', '#f1c40f', '#e74c3c', '#6ab04c', '#F8EFBA', '#D6A2E8'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#d35400', '#2c3e50', '#f39c12', '#c0392b', '#badc58', '#BDC581', '#9AECDB'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true
    },
    cutoutPercentage: 80,
  },
});
