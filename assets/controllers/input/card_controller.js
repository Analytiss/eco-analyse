import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'switch'];

    connect() {}

    toggle(event) {
        this.inputTargets.forEach((input) => {
            input.disabled = !event.target.checked;
        });

        this.switchTargets.forEach((element) => {
            element.disabled = !event.target.checked;
        });
    }
}
