document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById("schoolsLineChart");

    fetch('/schoolsCount')
        .then(response => response.json())
        .then(data => {
            console.log("Fetched data:", data);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Total Schools",
                        backgroundColor: "rgba(2,117,216,0.75)",
                        borderColor: "rgba(2,117,216,1)",
                        borderWidth: 1,
                        data: data,
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 12
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                stepSize: 1,
                                maxTicksLimit: 7
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)",
                            }
                        }],
                    },
                    legend: {
                        display: true
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
