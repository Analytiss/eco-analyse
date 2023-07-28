import { Controller } from '@hotwired/stimulus';
import { Toast } from '../js/toaster';

export default class extends Controller {
    static targets = ['message'];

    connect() {
        Toast.fire({
            icon: this.element.dataset.type,
            text: this.element.dataset.message,
        }).then();
    }
}
