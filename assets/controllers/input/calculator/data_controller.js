import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

export default class extends Controller {
    static targets = [
        'url',
        'activated',
        'unit',
        'value',
        'dataTreatmentImpact',
        'dataTreatmentDuration',
        'dataTreatmentEnergy',
        'dataTreatmentEnergyContribution',
        'dataTreatmentDeviceContribution',
    ];

    update() {
        const form = new FormData();
        form.append('activated', this.activatedTarget.checked);
        form.append('unit', this.unitTarget.value ?? null);
        form.append('value', parseFloat(this.valueTarget.value) ?? null);
        form.append('impactCategory', document.getElementById('impact_category').value ?? null);

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
                        response.data.deviceContribution
                    );
                } else {
                    // console.error(response.data.error);
                    this.refreshResult(0, 0, 0, 0, 0);
                }
            })
            .catch((error) => {
                console.error(error);
                this.refreshResult(0, 0, 0, 0, 0);
            });
    }

    refreshResult(duration, impact, energy, energyContribution, deviceContribution) {
        this.dataTreatmentDurationTarget.value = duration;
        this.dataTreatmentImpactTarget.value = impact;
        this.dataTreatmentEnergyTarget.value = energy;
        this.dataTreatmentEnergyContributionTarget.value = energyContribution;
        this.dataTreatmentDeviceContributionTarget.value = deviceContribution;

        const change = new Event('change');
        this.dataTreatmentDurationTarget.dispatchEvent(change);
    }
}
