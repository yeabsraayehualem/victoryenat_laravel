document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById("teachersQuestionPostPerMonth").getContext('2d');

    fetch('/teacher/questionsByMonth')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched data:", data);

            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const totalPost = data.posted || Array(12).fill(0);
            const schoolApproved = data.school_accepted || Array(12).fill(0);
            const staffAccepted = data.victory_accepted || Array(12).fill(0);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Post',
                            data: totalPost,
                            borderColor: '#4f46e5',
                            tension: 0.4,
                            fill: false
                        },
                        {
                            label: 'School Approved',
                            data: schoolApproved,
                            borderColor: '#10b981',
                            tension: 0.4,
                            fill: false

                        },
                        {
                            label: 'Victory Accepted',
                            data: staffAccepted,
                            borderColor: '#f59e0b',
                            tension: 0.4,
                            fill: false
                        },

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
