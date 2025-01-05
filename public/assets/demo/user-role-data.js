document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart
    var ctxPie = document.getElementById('usersPieChart').getContext('2d');
    fetch('/getUserByRole')
        .then(response => response.json())
        .then(data => {
            console.log(data);

            // Extract roles and user counts
            const roles = Object.keys(data);
            const counts = Object.values(data);

            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: roles,
                    datasets: [{
                        data: counts,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                        ],
                        borderColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'User Roles Distribution'
                        },
                        tooltip: {
                            enabled: true
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        });
});
