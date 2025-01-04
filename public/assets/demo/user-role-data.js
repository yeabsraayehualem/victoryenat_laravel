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
                type: 'pie',
                data: {
                    labels: roles,
                    datasets: [{
                        data: counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
});
