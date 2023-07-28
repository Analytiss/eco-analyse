import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import { exportBootstrapTableToArray } from '../../../js/calculator';

export default class extends Controller {
    static targets = [
        'url',
        'gas',
        'switch',
        'activated',
        'consumption',
        'durationUnit',
        'ovenGradient',
        'durationValue',
        'analyticalTechnic',
        'directMeasurement',
        'sampleAnalysisImpact',
        'sampleAnalysisEnergy',
        'sampleAnalysisDuration',
        'sampleAnalysisEnergyContribution',
        'sampleAnalysisGasContribution',
        'sampleAnalysisDeviceContribution',
    ];

    update() {
        const form = new FormData();
        form.append('activated', this.activatedTarget.checked);
        form.append('durationUnit', this.durationUnitTarget.value ?? null);
        form.append('durationValue', parseFloat(this.durationValueTarget.value) ?? null);
        form.append('impactCategory', document.getElementById('impact_category').value ?? null);
        form.append('country', document.getElementById('impact_countries').value ?? null);
        form.append('analyticalTechnic', this.analyticalTechnicTarget.value ?? null);
        form.append('directMeasurement', this.directMeasurementTarget.checked ?? null);
        form.append('consumption', parseFloat(this.consumptionTarget.value) ?? null);
        form.append('gas', this.gasTarget.value ?? null);
        const tableData = exportBootstrapTableToArray($(this.ovenGradientTarget).bootstrapTable('getData'));
        form.append('ovenGradient', tableData ?? null);

        axios
            .post(this.urlTarget.value, form)
            .then((response) => {
                if (response.data && !response.data.error) {
                    // console.log(response.data);
                    this.refreshResult(
                        response.data.duration,
                        response.data.impact,
                        response.data.energy,
                        response.data.energyContribution,
                        response.data.gasContribution,
                        response.data.deviceContribution
                    );
                } else {
                    console.error(response.data.error);
                    this.refreshResult(0, 0, 0, 0, 0);
                }
            })
            .catch((error) => {
                console.error(error);
                this.refreshResult(0, 0, 0, 0, 0);
            });
    }

    refreshResult(duration, impact, energy, energyContribution, gasContribution, deviceContribution) {
        this.sampleAnalysisDurationTarget.value = duration;
        this.sampleAnalysisImpactTarget.value = impact;
        this.sampleAnalysisEnergyTarget.value = energy;
        this.sampleAnalysisEnergyContributionTarget.value = energyContribution;
        this.sampleAnalysisGasContributionTarget.value = gasContribution;
        this.sampleAnalysisDeviceContributionTarget.value = deviceContribution;

        const change = new Event('change');
        this.sampleAnalysisImpactTarget.dispatchEvent(change);
    }

    switch() {
        this.switchTargets.forEach((element) => {
            if (element.hasAttribute('hidden')) {
                element.removeAttribute('hidden');
            } else {
                element.setAttribute('hidden', true);
            }
        });
    }
}
