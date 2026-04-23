import { Controller } from '@hotwired/stimulus'
import { Modal } from 'bootstrap'

export default class extends Controller {
    static targets = ['title', 'body', 'confirmBtn']

    connect() {
        document.addEventListener('modal:open', (event) => {
            const { title, body, btnLabel, btnVariant, url, action, sourceForm } = event.detail;

            this.titleTarget.textContent = title;
            this.bodyTarget.textContent = body;

            this.confirmBtnTarget.textContent = btnLabel;
            this.confirmBtnTarget.className = `btn btn-${btnVariant}`;

            this.confirmBtnTarget.onclick = () => {
                if (action === 'submit' && sourceForm)
                {
                    sourceForm.submit();
                } else if (url) {
                    window.location.href = url;
                }
            };

            import('bootstrap').then(({ Modal }) => {
                const modal = new Modal(this.element);
                modal.show();
            });
        });
    }

    disconnect() {
        document.removeEventListener('modal:open', this.handleOpen);
        this.modal.dispose();
    }

    open(event) {
        console.log('modal open', event.detail);
        const { title, body, btnLabel = 'Confirmer', btnVariant = 'primary', url, action = 'redirect' } = event.detail;

        this.titleTarget.textContent = title;
        this.bodyTarget.textContent = body;
        this.confirmBtnTarget.textContent = btnLabel;
        this.confirmBtnTarget.className = `btn btn-${btnVariant}`;

        this.#setConfirmAction(action, url, event.detail.sourceForm);

        this.modal.show();
    }

    #setConfirmAction(action, url, sourceForm)
    {
        this.confirmBtnTarget.onclick = () => {

            this.modal.hide();

            if (action === 'submit' && sourceForm)
            {
                sourceForm.submit();
            }
            else
            {
                window.location.href = url;
            }
        }
    }
}