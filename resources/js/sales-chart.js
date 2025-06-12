document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;  // canvasがなければ処理しない
    const chart = new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: window.salesChartLabels || [],
            datasets: [{
                label: '売上',
                data: window.salesChartData || [],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 500,
                        callback: function(value) {
                            return '¥' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
