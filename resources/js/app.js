import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import weatherWidget from './weather';
import pdfDocumentViewer from './pdf-document-viewer';

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.data('publicSubmit', () => ({
    submitting: false,
    submit() {
        this.submitting = true;
    },
}));
Alpine.data('weatherWidget', weatherWidget);
Alpine.data('pdfDocumentViewer', pdfDocumentViewer);
Alpine.start();
