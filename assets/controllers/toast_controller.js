import { Controller } from '@hotwired/stimulus';
import { Toast } from 'bootstrap';

export default class extends Controller {
    connect() {
        const toast = Toast.getOrCreateInstance(this.element);
        toast.show();
    }
}
