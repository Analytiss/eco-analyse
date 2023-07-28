import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import { makeSelectInputGroup } from '../../../js/format';
import { formatArray } from '../../../js/calculator';

export default class extends Controller {
    static targets = [
        'url',
        'activated',
        'durationValue',
        'durationUnit',
        'sampleCollectionTime',
        'sampleCollectionImpact',
        'solvent',
        'solventValue',
        'solventList',
        'solventListURL',
        'medium',
        'mediumValue',
        'mediumList',
        'mediumListURL',
        'consumable',
        'consumableValue',
        'consumableList',
        'consumableListURL',
        'samplePreparationDuration',
        'samplePreparationImpact',
        'samplePreparationEnergy',
        'samplePreparationEnergy',
        'samplePreparationEnergyContribution',
        'samplePreparationSolventContribution',
        'samplePreparationConsumableContribution',
    ];

    connect() {
        this.addSolvent();
        this.addMedium();
        this.addConsumable();
    }

    update() {
        // Récupération des solvents
        const solvents = formatArray(this.solventTargets, this.solventValueTargets);

        // Récupération des mediums
        const mediums = formatArray(this.mediumTargets, this.mediumValueTargets);

        // Récupération des consumables
        const consumables = formatArray(this.consumableTargets, this.consumableValueTargets);

        const form = new FormData();
        form.append('activated', this.activatedTarget.checked);
        form.append('durationValue', this.durationValueTarget.value ?? null);
        form.append('durationUnit', this.durationUnitTarget.value ?? null);
        form.append('impactCategory', document.getElementById('impact_category').value ?? null);
        form.append('country', document.getElementById('impact_countries').value ?? null);
        form.append('solvents', JSON.stringify(solvents));
        form.append('mediums', JSON.stringify(mediums));
        form.append('consumables', JSON.stringify(consumables));
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
                        response.data.solventContribution,
                        response.data.consumableContribution
                    );
                } else {
                    console.error(response.data.error);
                    this.refreshResult(0, 0, 0, 0, 0, 0);
                }
            })
            .catch((error) => {
                console.error(error);
                this.refreshResult(0, 0, 0, 0, 0, 0);
            });
    }

    addSolvent() {
        makeSelectInputGroup(this.solventListURLTarget.value, this.solventListTarget, 'solvent', 'mL', 0.1);
        this.update();
    }

    addMedium() {
        makeSelectInputGroup(this.mediumListURLTarget.value, this.mediumListTarget, 'medium', 'number of unit(s)', 1);
        this.update();
    }

    addConsumable() {
        makeSelectInputGroup(
            this.consumableListURLTarget.value,
            this.consumableListTarget,
            'consumable',
            'number of unit(s)',
            1
        );
        this.update();
    }

    removeSelection(event) {
        const div = event.target.parentNode.parentNode;
        div.classList.remove('apparition');
        div.classList.add('disparition');
        setTimeout(() => {
            div.remove();
            this.update();
        }, 750);
    }

    refreshResult(duration, impact, energy, energyContribution, solventContribution, consumableContribution) {
        this.samplePreparationDurationTarget.value = duration;
        this.samplePreparationImpactTarget.value = impact;
        this.samplePreparationEnergyTarget.value = energy;
        this.samplePreparationEnergyContributionTarget.value = energyContribution;
        this.samplePreparationSolventContributionTarget.value = solventContribution;
        this.samplePreparationConsumableContributionTarget.value = consumableContribution;

        const change = new Event('change');
        this.samplePreparationDurationTarget.dispatchEvent(change);
    }
}
