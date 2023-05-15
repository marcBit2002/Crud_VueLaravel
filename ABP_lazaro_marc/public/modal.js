let eliminaModal = document.getElementById("eliminaModal");

eliminaModal.addEventListener('shown.bs.modal', event => {
    let button = event.relatedTarget;
    let id = button.getAttribute("data-bs-id");
    let sigles = button.getAttribute("data-bs-sigles");
    let action = button.getAttribute("data-bs-action");
    eliminaModal.querySelector('.modal-footer .delete').value = id;
    eliminaModal.querySelector('.modal-footer form').action = action;
    eliminaModal.querySelector('.modal-body p').value = "Segur que vols eliminar " + sigles + " ?";
});