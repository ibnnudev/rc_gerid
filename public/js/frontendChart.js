var Genchart = new Chart(
    document.getElementById("persebaranVirusByGen").getContext("2d"),
    {
        type: "bar",
        data: {
            labels: [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "September",
                "Oktober",
                "November",
                "Desember",
            ],
            // responsible for how many bars are gonna show on the chart
            // create 12 datasets, since we have 12 items
            // data[0] = labels[0] (data for first bar - 'Standing costs') | data[1] = labels[1] (data for second bar - 'Running costs')
            // put 0, if there is no data for the particular bar
            datasets: [
                {
                    label: "CRF01_AE",
                    data: [
                        2, 8, 10, 10, 200, 300, 400, 300, 100, 400, 300, 100,
                    ],
                    backgroundColor: "#22aa99",
                },
                {
                    label: "CRF01_AG",
                    data: [100, 8, 10, 10, 200, 300, 300, 100, 400, 300, 100],
                    backgroundColor: "#994499",
                },
                {
                    label: "B[0]",
                    data: [50, 8, 10, 10, 200, 300, 300, 100, 400, 300, 100],
                    backgroundColor: "#316395",
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            reponsive: true,
            plugins: {
                legend: {
                    labels: {
                        usePointStyle: true,
                        boxWidth: 5,
                        boxHeight: 5,
                    },
                },
            },
            scales: {
                y: {
                    // stack the bar
                    stacked: true,
                    grid: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1,
                    },
                },
                x: {
                    // stack the bar
                    stacked: true,
                    grid: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1,
                    },
                },
            },
        },
    }
);
