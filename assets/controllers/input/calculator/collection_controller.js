import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

export default class extends Controller {
    static targets = [
        'url',
        'activated',
        'transportMode',
        'numberOfSampleCollected',
        'unit',
        'distanceValue',
        'sampleCollectionDistance',
        'sampleCollectionImpact',
        'sampleCollectionTransportContribution',
    ];

    update() {
        const form = new FormData();
        form.append('activated', this.activatedTarget.checked);
        form.append('transportMode', this.transportModeTarget.value ?? null);
        form.append('numberOfSampleCollected', parseInt(this.numberOfSampleCollectedTarget.value) ?? null);
        form.append('impactCategory', document.getElementById('impact_category').value ?? null);
        form.append('country', document.getElementById('impact_countries').value ?? null);
        form.append('unit', this.unitTarget.value ?? null);
        form.append('distanceValue', parseFloat(this.distanceValueTarget.value) ?? null);

        axios
            .post(this.urlTarget.value, form)
            .then((response) => {
                if (response.data && !response.data.error) {
                    // console.log(response.data);
                    this.refreshResult(
                        response.data.distance,
                        response.data.impact,
                        response.data.transportContribution
                    );
                } else {
                    // console.error(response.data.error);
                    this.refreshResult(0, 0, 0);
                }
            })
            .catch((error) => {
                console.error(error);
                this.refreshResult(0, 0, 0);
            });
    }

    refreshResult(distance, impact, transportContribution) {
        this.sampleCollectionDistanceTarget.value = distance;
        this.sampleCollectionImpactTarget.value = impact;
        this.sampleCollectionTransportContributionTarget.value = transportContribution;

        const change = new Event('change');
        this.sampleCollectionDistanceTarget.dispatchEvent(change);
    }
}
