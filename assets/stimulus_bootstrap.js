import { startStimulusApp } from '@symfony/stimulus-bundle';
import ToastController from './controllers/toast_controller.js';
import TriggerController from './controllers/trigger_controller.js';
import ModalController from './controllers/modal_controller.js'

const app = startStimulusApp();

app.register('toast', ToastController);
app.register('trigger', TriggerController);
app.register('modal', ModalController);