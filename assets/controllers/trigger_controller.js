import { Controller } from '@hotwired/stimulus'

export default class extends Controller {

    connect() {
        console.log("TRIGGER CONNECTED");
    }

    open(event) {
        const el = event.currentTarget;

        document.dispatchEvent(new CustomEvent('modal:open', {
            detail: {
                title: el.dataset.triggerTitle,
                body: el.dataset.triggerBody,
                btnLabel: el.dataset.triggerBtnLabel,
                btnVariant: el.dataset.triggerBtnVariant,
                url: el.dataset.triggerUrl,
                action: el.dataset.triggerAction,
                sourceForm: el.closest('form') ?? null
            }
        }));
    }
}
