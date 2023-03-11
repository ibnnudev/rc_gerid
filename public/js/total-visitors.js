let totalVisitorsCtx = document
    .getElementById("totalVisitorsChart")
    .getContext("2d");
let totalVisitorsChart = new Chart(totalVisitorsCtx, {
    type: "line",
    data: {
        // month only 3 char
        labels: months.map((m) => m.slice(0, 3)),
        datasets: [
            {
                label: "Total Pengunjung",
                data: totalVisitorPerMonth,
                // 19743b
                backgroundColor: "rgba(25, 116, 59, 0.1)",
                borderColor: "#19743b",
                borderWidth: 1.5,
                fill: "start",
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        reponsive: true,
        scales: {
            y: {
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
        elements: {
            line: {
                tension: 0.4,
            },
        },
    },
});
