document.addEventListener('DOMContentLoaded', function () {
    var ctxPie = document.getElementById("totalQuestions").getContext('2d');

    fetch('/teacher/questionsByMonth')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    }).then(data => {
        console.log("Fetched data:", data);
        const labels = ['Total Questions', 'Accepted Questions'];
        const counts = [data.total, data.accepted];

        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: counts,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                    ],
                    borderColor: [
                        '#FF6384',
                        '#36A2EB',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Accepted And Total QUestions'
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
    }).catch(error => {
        console.error('Error fetching data:', error);
        alert("Failed to fetch data. Please try again.");
    });
});