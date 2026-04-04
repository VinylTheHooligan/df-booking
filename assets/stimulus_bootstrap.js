import { startStimulusApp } from '@symfony/stimulus-bundle';
import ToastController from './controllers/toast_controller.js';

const app = startStimulusApp();
app.register('toast', ToastController);