import { Controller } from '@hotwired/stimulus';
import ApexCharts from 'apexcharts';
import { tableOptions, chartOptions, buildChartDataFromTable } from '../../js/input/chart';

import 'bootstrap-table/src/bootstrap-table';
import 'bootstrap-table/src/extensions/auto-refresh/bootstrap-table-auto-refresh';

export default class extends Controller {
    static targets = ['values', 'chart'];

    chart = null;

    connect() {
        // Graphique
        this.chart = new ApexCharts(this.chartTarget, chartOptions);
        this.chart.render().then();

        // Tableau
        $(this.valuesTarget).bootstrapTable(tableOptions);
    }

    addStatement() {
        const count = $(this.valuesTarget).bootstrapTable('getData').length;
        $(this.valuesTarget).bootstrapTable('append', {
            step: count + 1,
            rateDegree: null,
            setPoint: null,
            holdTime: null,
            runTime: null,
        });
    }

    removeStatement() {
        const count = $(this.valuesTarget).bootstrapTable('getData').length;
        $(this.valuesTarget).bootstrapTable('removeByUniqueId', count);
    }

    updateTableRow(event) {
        let newValue = event.target.value;
        if (newValue.trim() === '') {
            newValue = null;
        }
        const datas = $(this.valuesTarget).bootstrapTable('getData');
        datas[event.target.dataset.step - 1][event.target.dataset.field] = newValue;
        event.target.parentNode.innerHTML = newValue;

        const finalData = buildChartDataFromTable(datas, this.chart);
        this.addStatement();
        this.removeStatement();

        this.chart
            .updateSeries(
                [
                    {
                        data: finalData,
                    },
                ],
                true
            )
            .then();

        // Envoi d'une update
        const updateElement = document.getElementById('sample_analysis_technic');
        updateElement.dispatchEvent(new Event('change'));
    }
}
