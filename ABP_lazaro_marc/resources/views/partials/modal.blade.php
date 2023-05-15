<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="lblEliminarModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Esborrar Curs</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-x"></i>Tancar</button>
                    <button type="submit" class="btn btn-danger delete"><i class="bi bi-trash"></i>Esborrar</button>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let eliminaModal = document.getElementById("eliminaModal");

    eliminaModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute("data-bs-id");
        let sigles = button.getAttribute("data-bs-sigles");
        let action = button.getAttribute("data-bs-action");
        eliminaModal.querySelector('.modal-footer .delete').value = id;
        eliminaModal.querySelector('.modal-footer form').action = action;
        eliminaModal.querySelector('.modal-body p').innerHTML = "Segur que vols eliminar " + sigles + " ?";
    });
</script>
