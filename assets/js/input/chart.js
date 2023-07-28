export const tableOptions = {
    mobileResponsive: true,
    uniqueId: 'step',
    columns: [
        {
            field: 'step',
            title: 'Ramp',
        },
        {
            field: 'rateDegree',
            title: 'Rate (°C/min)',
        },
        {
            field: 'setPoint',
            title: 'Set Point (°C)',
        },
        {
            field: 'holdTime',
            title: 'Hold Time (min)',
        },
        {
            field: 'runTime',
            title: 'Run Time (min)',
        },
    ],
    onClickCell: (field, value, row, $element) => {
        if ((row.step === 1 && field === 'rateDegree') || field === 'step' || field === 'runTime') {
            return;
        }
        const input = document.createElement('input');
        input.value = value;
        input.setAttribute('data-action', 'blur->input--chart#updateTableRow');
        input.setAttribute('data-step', row.step);
        input.setAttribute('data-field', field);
        $element[0].innerHTML = '';
        $element[0].appendChild(input);
        input.focus();
    },
};

export const chartOptions = {
    series: [
        {
            data: [],
            // data: [100, 100, 100, 135, 135, 135, 150, 150, 150],
        },
    ],
    legend: {
        show: true,
    },
    chart: {
        height: 350,
        type: 'line',
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'straight',
    },
    grid: {
        row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5,
        },
    },
    xaxis: {
        categories: [],
        // categories: [5, 10, 15, 20, 25, 30, 35, 40, 45],
        title: {
            text: 'min',
        },
    },
    yaxis: {
        title: {
            text: '°C',
        },
    },
    exporting: {
        enable: false,
    },
};

/**
 *
 * @param prev {number}
 * @param next {number}
 * @param gradient {number}
 * @returns {number}
 */
function calculGradTemp(prev, next, gradient) {
    return (next - prev) / gradient;
}

/**
 *
 * @param datas {[]}
 * @returns {{x: number, y: number}[]}
 */
export function buildChartDataFromTable(datas) {
    let datasX = [];
    let datasY = [];
    datas.forEach((data, d) => {
        if (d === 0 && data.setPoint && data.holdTime) {
            datas[d].runTime = data.holdTime;
            datasX.push(0);
            datasX.push(parseFloat(data.holdTime));
            datasY.push(parseFloat(data.setPoint));
            datasY.push(parseFloat(data.setPoint));
        } else if (data.rateDegree && data.setPoint && data.holdTime) {
            const lastTime = parseFloat(datasX[datasX.length - 1]);
            const lastTemp = parseFloat(datasY[datasY.length - 1]);

            // Calcul du temps de passage d'une valeur à l'autre
            const addTime = calculGradTemp(lastTemp, parseFloat(data.setPoint), parseFloat(data.rateDegree));
            const startTempTime = addTime + lastTime;

            // Évolution de la température
            datasX.push(startTempTime);
            datasY.push(parseFloat(data.setPoint));

            // Maintien de la température
            datas[d].runTime = (startTempTime + parseFloat(data.holdTime)).toFixed(2);
            datasX.push(datas[d].runTime);
            datasY.push(parseFloat(data.setPoint));
        }
    });

    return datasX.map((x, index) => ({ x: parseFloat(x), y: parseFloat(parseFloat(datasY[index]).toFixed(2)) }));
}
