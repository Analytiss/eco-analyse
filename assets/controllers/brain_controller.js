import { Controller } from '@hotwired/stimulus';
import { formatResult } from '../js/calculator';
import { Toast } from '../js/toaster';
import 'select2';
import axios from 'axios';
import ApexCharts from 'apexcharts';
import { barOptions, pieOptions } from '../js/result/graphs';

export default class extends Controller {
    static targets = [
        'select2',
        'resultImpact',
        'resultUnit',
        'resultUnitURL',
        'resultDistance',
        'resultEnergy',
        'resultTime',
        'sampleCollectionDistance',
        'sampleCollectionImpact',
        'sampleCollectionTransportContribution',
        'dataTreatmentDuration',
        'dataTreatmentImpact',
        'dataTreatmentEnergy',
        'dataTreatmentEnergyContribution',
        'dataTreatmentDeviceContribution',
        'sampleAnalysisDuration',
        'sampleAnalysisImpact',
        'sampleAnalysisEnergy',
        'sampleAnalysisEnergyContribution',
        'sampleAnalysisGasContribution',
        'sampleAnalysisDeviceContribution',
        'samplePreparationDuration',
        'samplePreparationImpact',
        'samplePreparationEnergy',
        'samplePreparationEnergyContribution',
        'samplePreparationSolventContribution',
        'samplePreparationConsumableContribution',
        'updateInput',
        'chartPieGraph',
        'chartBarGraph',
    ];

    impact = 0;
    distance = 0;
    time = 0;
    energy = 0;

    deviceContribution = 0;
    consumableContribution = 0;
    electricityContribution = 0;
    gasContribution = 0;
    solventContribution = 0;
    transportContribution = 0;

    chartPie = null;
    chartBar = null;

    tempUnitName = 'Global Warming';
    tempUnitCode = 'GWP';

    connect() {
        this.initSelect2();
        this.chartPie = new ApexCharts(this.chartPieGraphTarget, pieOptions);
        this.chartBar = new ApexCharts(this.chartBarGraphTarget, barOptions);

        this.chartPie.render().then();
        this.chartBar.render().then();
    }

    update() {
        // Mise à jour de l'impact
        this.impact = 0;
        this.impact += parseFloat(this.sampleCollectionImpactTarget.value);
        this.impact += parseFloat(this.dataTreatmentImpactTarget.value);
        this.impact += parseFloat(this.sampleAnalysisImpactTarget.value);
        this.impact += parseFloat(this.samplePreparationImpactTarget.value);

        // Mise à jour du temps
        this.time = 0;
        this.time += parseFloat(this.dataTreatmentDurationTarget.value);
        this.time += parseFloat(this.sampleAnalysisDurationTarget.value);
        this.time += parseFloat(this.samplePreparationDurationTarget.value);

        // Mise à jour de la distance parcourue
        this.distance = parseFloat(this.sampleCollectionDistanceTarget.value);

        // Mise à jour de l'énergie
        this.energy = 0;
        this.energy += parseFloat(this.dataTreatmentEnergyTarget.value);
        this.energy += parseFloat(this.sampleAnalysisEnergyTarget.value);
        this.energy += parseFloat(this.samplePreparationEnergyTarget.value);

        // Mise à jour contributions
        this.deviceContribution = 0;
        this.deviceContribution += this.sampleAnalysisDeviceContributionTarget.value;
        this.deviceContribution += this.dataTreatmentDeviceContributionTarget.value;

        this.gasContribution = 0;
        this.gasContribution += this.sampleAnalysisGasContributionTarget.value;

        this.transportContribution = 0;
        this.transportContribution += this.sampleCollectionTransportContributionTarget.value;

        this.consumableContribution = 0;
        this.consumableContribution += this.samplePreparationConsumableContributionTarget.value;

        this.electricityContribution = 0;
        this.electricityContribution += this.samplePreparationEnergyContributionTarget.value;
        this.electricityContribution += this.sampleAnalysisEnergyContributionTarget.value;
        this.electricityContribution += this.dataTreatmentEnergyContributionTarget.value;

        this.solventContribution = 0;
        this.solventContribution += this.samplePreparationSolventContributionTarget.value;

        // Mise à jour des éléments de réponse
        this.refresh();
    }

    refresh() {
        let precision = 2;

        if (['SODP', 'OFP', 'FEutP', 'WCP'].includes(this.tempUnitCode)) {
            precision = 5;
        }

        this.resultImpactTarget.innerText = formatResult(this.impact, precision);
        this.resultDistanceTarget.innerText = formatResult(this.distance, 2);
        this.resultTimeTarget.innerText = formatResult(this.time, 0);
        this.resultEnergyTarget.innerText = formatResult(this.energy, 2);

        // Mise à jour du graphique
        const chartPieTitle = ['Contribution analysis for each step for', `the ${this.tempUnitName} impact`];
        this.chartPie.updateOptions({
            chart: {
                toolbar: {
                    export: {
                        csv: {
                            filename: chartPieTitle.join(' '),
                        },
                        svg: {
                            filename: chartPieTitle.join(' '),
                        },
                        png: {
                            filename: chartPieTitle.join(' '),
                        },
                    },
                },
            },
            title: {
                text: chartPieTitle,
                textStyle: {
                    wordWrap: true,
                },
            },
        });
        this.chartPie.updateSeries([
            (parseFloat(this.sampleCollectionImpactTarget.value) / this.impact) * 100,
            (parseFloat(this.samplePreparationImpactTarget.value) / this.impact) * 100,
            (parseFloat(this.sampleAnalysisImpactTarget.value) / this.impact) * 100,
            (parseFloat(this.dataTreatmentImpactTarget.value) / this.impact) * 100,
        ]);

        const chartBarTitle = ['Contribution analysis by type of element for', `the ${this.tempUnitName} impact`];

        this.chartBar.updateOptions({
            chart: {
                toolbar: {
                    export: {
                        csv: {
                            filename: chartBarTitle.join(' '),
                        },
                        svg: {
                            filename: chartBarTitle.join(' '),
                        },
                        png: {
                            filename: chartBarTitle.join(' '),
                        },
                    },
                },
            },
            title: {
                text: chartBarTitle,
                textStyle: {
                    wordWrap: true,
                },
            },
            xaxis: {
                title: {
                    text: this.resultUnitTarget.innerHTML
                        .replace('<sub>', '')
                        .replace('</sub>', '')
                        .replace('<sup>', '')
                        .replace('</sup>', ''),
                },
            },
        });
        this.chartBar.updateSeries([
            {
                name: 'Contribution',
                data: [
                    this.deviceContribution,
                    this.consumableContribution,
                    this.electricityContribution,
                    this.gasContribution,
                    this.solventContribution,
                    this.transportContribution,
                ],
            },
        ]);
    }

    initSelect2() {
        this.select2Targets.forEach((select) => {
            $(select)
                .select2({
                    theme: 'bootstrap-5',
                })
                .on('change', (e) => {
                    if (e.target.id === 'impact_category') {
                        const form = new FormData();
                        form.append('code', e.target.value);
                        axios.post(this.resultUnitURLTarget.value, form).then((result) => {
                            this.resultUnitTarget.innerHTML = result.data.unit;
                            this.tempUnitName = result.data.name;
                            this.tempUnitCode = e.target.value;
                        });
                    }
                    this.updateImportantElement();
                });
        });
    }

    updateImportantElement() {
        const change = new Event('change');
        this.updateInputTargets.forEach((input) => {
            input.dispatchEvent(change);
        });

        setTimeout(() => {
            this.update();
            Toast.fire({
                icon: 'info',
                text: 'Datas updated!',
            }).then();
        }, 1000);
    }
}
