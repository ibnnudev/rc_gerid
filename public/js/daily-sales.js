let dailySalesCtx = document.getElementById("dailySalesChart").getContext("2d");
let dailySalesChart = new Chart(dailySalesCtx, {
    type: "line",
    data: {
        labels: ["07:00", "09:00", "12:00", "17:00", "20:00"],
        datasets: [
            {
                label: "Penjualan Harian",
                data: [100, 200, 250, 550, 300],
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
            },
        },
        elements: {
            line: {
                tension: 0.4,
            },
        },
    },
});
