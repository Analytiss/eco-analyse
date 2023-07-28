export const pieOptions = {
    series: [0, 0, 0, 0],
    chart: {
        height: 350,
        type: 'pie',
        toolbar: {
            show: true,
        },
    },
    tooltip: {
        custom: function ({ series, seriesIndex, dataPointIndex, w }) {
            console.log(series, seriesIndex, dataPointIndex, w.config.labels);
            return w.config.labels[seriesIndex] + ': ' + series[seriesIndex].toFixed(2);
        },
    },
    title: {
        align: 'center',
    },
    labels: ['Sample collection', 'Sample Preparation', 'Sample analysis', 'Data treatment'],
    colors: ['#0673B2', '#04A072', '#e79f25', '#d55f27'],
    legend: {
        position: 'bottom',
    },
};

export const barOptions = {
    series: [
        {
            data: [0, 0, 0, 0, 0],
        },
    ],
    title: {
        align: 'center',
    },
    tooltip: {
        custom: function ({ series, seriesIndex, dataPointIndex }) {
            return 'Contribution: ' + series[seriesIndex][dataPointIndex].toFixed(5);
        },
    },
    chart: {
        type: 'bar',
        height: 350,
        toolbar: {
            show: true,
        },
    },
    plotOptions: {
        bar: {
            borderRadius: 4,
            horizontal: true,
        },
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        categories: ['Device', 'Consumable', 'Electricity', 'Gas', 'Solvent', 'Transport'],
        title: {
            text: 'kg CO2 eq',
        },
    },
};
