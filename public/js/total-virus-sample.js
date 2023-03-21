let totalSampleVirusCtx = document
    .getElementById("totalSampleVirus")
    .getContext("2d");

let totalSampleVirusChart = new Chart(totalSampleVirusCtx, {
    type: "bar",
    data: {
        labels: months.map((m) => m.slice(0, 3)),
        // data for every virus in every month. There's 3 virus
        datasets: [
            {
                label: "Virus A",
                // green
                backgroundColor: "rgba(25, 116, 59, 0.1)",
                borderColor: "#19743b",
                borderWidth: 1.5,
                fill: "start",
                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].sort(
                    () => Math.random() - 0.5
                ),
            },
            {
                label: "Virus B",
                // red
                backgroundColor: "rgba(255, 0, 0, 0.1)",
                borderColor: "#ff0000",
                borderWidth: 1.5,
                fill: "start",
                // generate scrumble data
                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].sort(
                    () => Math.random() - 0.5
                ),
            },
            {
                label: "Virus C",
                // blue
                backgroundColor: "rgba(0, 0, 255, 0.1)",
                borderColor: "#0000ff",
                borderWidth: 1.5,
                fill: "start",
                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].sort(
                    () => Math.random() - 0.5
                ),
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        reponsive: true,
        // change shape in legend to small circle
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
});

// Path: public\js\total-virus-sample.js
