document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById("usersOverview").getContext('2d');

    fetch('/manager/users')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched data:", data);

            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const studentsData = data.student || Array(12).fill(0);
            const teachersData = data.teacher || Array(12).fill(0);
            const staffData = data.staff || Array(12).fill(0);
            const schoolManagerData = data.school_manager || Array(12).fill(0);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Students',
                            data: studentsData,
                            borderColor: '#4f46e5',
                            tension: 0.4,
                            fill: false
                        },
                        {
                            label: 'Teachers',
                            data: teachersData,
                            borderColor: '#10b981',
                            tension: 0.4,
                            fill: false
                        },
                        {
                            label: 'School Managers',
                            data: schoolManagerData,
                            borderColor: '#ef4444',
                            tension: 0.4,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 4]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert("Failed to fetch data. Please try again.");
        });
});
