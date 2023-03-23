let backgroundColor = [
    // generate 6 random color
    "rgba(25, 116, 59, 0.1)",
    "rgba(255, 0, 0, 0.1)",
    "rgba(0, 0, 255, 0.1)",
    "rgb(250, 128, 114, 0.1)",
    "rgba(255, 0, 255, 0.1)",
    "rgba(0, 255, 255, 0.1)",
];

let borderColor = [
    // generate 6 random color
    "#19743b",
    "#ff0000",
    "#0000ff",
    "#FA8072",
    "#ff00ff",
    "#00ffff",
];

let samples = [];

for(let i = 0; i < Object.keys(samplePerYear).length; i++) {
    samples.push({
        label: Object.keys(samplePerYear)[i],
        data: Object.values(samplePerYear)[i],
        backgroundColor: backgroundColor[i],
        borderColor: borderColor[i],
        borderWidth: 1,
    });
}

let totalSampleVirusCtx = document
    .getElementById("totalSampleVirus")
    .getContext("2d");

let totalSampleVirusChart = new Chart(totalSampleVirusCtx, {
    type: "bar",
    data: {
        labels: months.map((m) => m.slice(0, 3)),
        datasets: samples,
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
