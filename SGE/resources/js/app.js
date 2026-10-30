// Proteção global contra duplo envio de formulários POST
document.addEventListener('submit', (event) => {
    const form = event.target;
    if (form instanceof HTMLFormElement && form.method.toUpperCase() === 'POST') {
        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }
        form.dataset.submitting = 'true';
        const submitter = event.submitter || form.querySelector('button[type="submit"]');
        if (submitter) {
            submitter.classList.add('opacity-75', 'cursor-wait');
        }
        setTimeout(() => {
            delete form.dataset.submitting;
            if (submitter) {
                submitter.classList.remove('opacity-75', 'cursor-wait');
            }
        }, 3000);
    }
});
