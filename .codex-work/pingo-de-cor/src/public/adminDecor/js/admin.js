document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('#admin-sidebar');
    const menuToggle = document.querySelector('[data-menu-toggle]');

    menuToggle?.addEventListener('click', () => sidebar?.classList.toggle('is-open'));

    document.querySelectorAll('[data-dismiss-alert]').forEach((button) => {
        button.addEventListener('click', () => button.closest('.alert')?.remove());
    });

    const openDialog = (dialog) => {
        if (dialog && !dialog.open) dialog.showModal();
    };

    document.querySelectorAll('[data-dialog-open]').forEach((button) => {
        button.addEventListener('click', () => openDialog(document.getElementById(button.dataset.dialogOpen)));
    });

    document.querySelectorAll('dialog').forEach((dialog) => {
        dialog.querySelectorAll('[data-dialog-close]').forEach((button) => {
            button.addEventListener('click', () => dialog.close());
        });
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) dialog.close();
        });
    });

    const search = document.querySelector('[data-table-search]');
    const rows = [...document.querySelectorAll('[data-table-row]')];
    const noResults = document.querySelector('[data-no-search-results]');

    search?.addEventListener('input', () => {
        const term = search.value.trim().toLocaleLowerCase('pt-BR');
        let visible = 0;
        rows.forEach((row) => {
            const matches = row.innerText.toLocaleLowerCase('pt-BR').includes(term);
            row.hidden = !matches;
            if (matches) visible += 1;
        });
        if (noResults) noResults.hidden = visible !== 0 || term === '';
    });

    const editDialog = document.querySelector('#edit-dialog');
    const editForm = editDialog?.querySelector('[data-edit-form]');

    const fillEditForm = (recordId, overrideValues = null) => {
        if (!editDialog || !editForm) return;
        const json = document.querySelector(`#record-json-${CSS.escape(String(recordId))}`);
        if (!json) return;

        const values = {...JSON.parse(json.textContent), ...(overrideValues || {})};
        editForm.reset();
        editForm.action = editDialog.dataset.updateTemplate.replace('__ID__', recordId);
        editForm.querySelector('[data-edit-record-id]').value = recordId;

        Object.entries(values).forEach(([name, value]) => {
            if (name.startsWith('_')) return;
            const input = editForm.elements.namedItem(name);
            if (!input) return;

            if (input.type === 'file') {
                const currentFile = editForm.querySelector(`[data-current-file="${CSS.escape(name)}"]`);
                if (currentFile && value) currentFile.textContent = `Arquivo atual: ${String(value).split('/').pop()}`;
                return;
            }
            if (input.type === 'password') return;
            input.value = value ?? '';
        });

        openDialog(editDialog);
    };

    document.querySelectorAll('[data-edit-record]').forEach((button) => {
        button.addEventListener('click', () => fillEditForm(button.dataset.editRecord));
    });

    const deleteDialog = document.querySelector('#delete-dialog');
    const deleteForm = deleteDialog?.querySelector('[data-delete-form]');
    document.querySelectorAll('[data-delete-record]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!deleteDialog || !deleteForm) return;
            deleteForm.action = deleteDialog.dataset.deleteTemplate.replace('__ID__', button.dataset.deleteRecord);
            deleteDialog.querySelector('[data-delete-name]').textContent = button.dataset.deleteTitle || `#${button.dataset.deleteRecord}`;
            openDialog(deleteDialog);
        });
    });

    const recovery = window.adminFormRecovery;
    if (recovery?.mode === 'create') {
        openDialog(document.querySelector('#create-dialog'));
    } else if (recovery?.mode === 'edit' && recovery.recordId) {
        fillEditForm(recovery.recordId, recovery.values);
    }

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            const submit = form.querySelector('button[type="submit"]');
            if (!submit) return;
            submit.disabled = true;
            submit.dataset.originalText = submit.textContent;
            submit.textContent = 'Salvando...';
        });
    });
});
