let pdfEnginePromise;

const loadPdfEngine = () => {
    pdfEnginePromise ??= import('./pdf-engine');

    return pdfEnginePromise;
};
export default (documentUrl) => {
    let pdf = null;

    return {
    pageNumber: 1,
    pageCount: 0,
    loading: true,
    failed: false,

    async init() {
        await new Promise((resolve) => window.setTimeout(resolve, 150));

        try {
            const { getDocument } = await loadPdfEngine();

            pdf = await getDocument(documentUrl).promise;
            this.pageCount = pdf.numPages;
            await this.renderPage();
        } catch (error) {
            this.failed = true;
            this.loading = false;
            console.error('Dokumen PDF gagal dimuat.', error);
        }
    },

    async renderPage() {
        if (!pdf) {
            return;
        }

        this.loading = true;

        try {
            const page = await pdf.getPage(this.pageNumber);
            const viewport = this.$refs.viewport;
            const pages = this.$refs.pages;
            const availableWidth = Math.max(viewport.clientWidth - 24, 280);
            const baseViewport = page.getViewport({ scale: 1 });
            const scale = Math.min(availableWidth / baseViewport.width, 1.5);
            const pageViewport = page.getViewport({ scale });
            const pixelRatio = window.devicePixelRatio || 1;
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d', { alpha: false });

            canvas.width = Math.floor(pageViewport.width * pixelRatio);
            canvas.height = Math.floor(pageViewport.height * pixelRatio);
            canvas.style.width = `${Math.floor(pageViewport.width)}px`;
            canvas.style.height = `${Math.floor(pageViewport.height)}px`;
            canvas.className = 'block max-w-full bg-white shadow-sm';

            await page.render({
                canvasContext: context,
                transform: pixelRatio === 1 ? null : [pixelRatio, 0, 0, pixelRatio, 0, 0],
                viewport: pageViewport,
            }).promise;

            pages.replaceChildren(canvas);
            page.cleanup();
        } catch (error) {
            this.failed = true;
            console.error('Halaman PDF gagal dirender.', error);
        } finally {
            this.loading = false;
        }
    },

    previousPage() {
        if (this.pageNumber <= 1 || this.loading) {
            return;
        }

        this.pageNumber -= 1;
        this.renderPage();
    },

    nextPage() {
        if (this.pageNumber >= this.pageCount || this.loading) {
            return;
        }

        this.pageNumber += 1;
        this.renderPage();
    },
    };
};
