<template>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Cicles</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Sigles</th>
                            <th>Nom</th>
                            <th>Descripcio</th>
                            <th>Actiu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cicle in cicles">
                            <td>{{ cicle.sigles }}</td>
                            <td>{{ cicle.nom }}</td>
                            <td>{{ cicle.descripcio }}</td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="actiu" name="actiu"
                                        value="actiu" :checked="cicle.actiu" disabled>
                                    <label for="actiu" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-secondary btn-sm me-2" @click="editCicle(cicle)">
                                        <i class="bi bi-pencil-square"></i>Editar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="confirmDelete(cicle)">
                                        <i class="bi bi-trash"></i>Esborrar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-mi btn-primary btn-sm float-end" @click="showForm()"><i class="bi bi-plus-lg"></i>Nou
                cicle</button>

        </div>
    </div>

    <!-- Modal esborrar -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="lblEliminarModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Esborrar Cicle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Està segur que vol esborrar el cicle <strong>{{ cicle.nom }}</strong>?</p>
                    <span v-if="isError" class="badge text-bg-danger">{{ messageError }}</span>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-x"></i>Tancar</button>
                    <button type="button" class="btn btn-danger" @click="deleteCicle()"><i
                            class="bi bi-trash"></i>Esborrar</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal insert/update -->
    <div class="modal fade" id="cicleModal" tabindex="-1" aria-labelledby="lblCicleModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 v-if="insert" class="modal-title fs-5" id="exampleModalLabel">Cicle</h1>
                    <h1 v-else class="modal-title fs-5" id="exampleModalLabel">Modificar Cicle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-2">
                            <label for="sigla" class="col-sm-2 col-form-label">Sigles</label>
                            <div class="col-sm-10">
                                <input type="text" name="sigla" id="sigla" class="form-control form-control-inline"
                                    autofocus required v-model="cicle.sigles">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" name="nom" id="nom" class="form-control form-control-inline" required
                                    v-model="cicle.nom">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="descripcio" class="col-sm-2 col-form-label">Descripció</label>
                            <div class="col-sm-10">
                                <input type="text" name="descripcio" id="descripcio"
                                    class="form-control form-control-inline" required v-model="cicle.descripcio">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-10">
                                <input type="checkbox" class="custom-control-input" id="actiu" name="actiu" value=""
                                    v-model="cicle.actiu" :checked="cicle.actiu">
                                <label for="actiu" class="custom-control-label">Actiu</label>
                            </div>
                        </div>
                    </form>
                    <span v-if="isError" class="badge text-bg-danger">{{ messageError }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-x"></i>Tancar</button>
                    <button v-if="insert" type="button" class="btn btn-primary" @click="insertCicle()"><i
                            class="bi bi-plus-circle"></i>
                        Crear</button>
                    <button v-else type="button" class="btn btn-primary" @click="updateCicle()"><i
                            class="bi bi-pencil-square"></i>
                        Modificar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as bootstrap from 'bootstrap'
export default {
    data() {
        return {
            cicles: [],
            myModal: {},
            cicle: {},
            messageError: '',
            isError: false,
            insert: false,
        }

    },
    methods: {
        showForm() {
            this.insert = true
            this.isError = false
            this.cicle = {}
            this.myModal = new bootstrap.Modal('#cicleModal')
            this.myModal.show();
        },
        editCicle(cicle) {
            this.isError = false
            this.insert = false
            this.cicle = cicle
            this.myModal = new bootstrap.Modal('#cicleModal')
            this.myModal.show();
        },
        updateCicle() {
            const me = this
            axios
                .put('cicle/' + me.cicle.id, me.cicle)
                .then(response => {
                    this.selectCicles()
                    me.myModal.hide()
                })
                .catch(error => {
                    this.isError = true
                    me.messageError = error.response.data.error

                })
        },
        insertCicle() {
            const me = this
            axios
                .post('cicle', me.cicle)
                .then(response => {
                    this.selectCicles()
                    me.myModal.hide()
                })
                .catch(error => {
                    this.isError = true
                    me.messageError = error.response.data.error

                })
        },
        selectCicles() {
            const me = this
            axios
                .get('cicle')
                .then(response => {
                    me.cicles = response.data
                })
                .catch(error => {

                })
        },
        confirmDelete(cicle) {
            this.isError = false
            this.cicle = cicle
            this.myModal = new bootstrap.Modal('#eliminaModal')
            this.myModal.show();
        },
        deleteCicle() {
            const me = this
            axios
                .delete('cicle/' + me.cicle.id)
                .then(response => {
                    this.selectCicles()
                    me.myModal.hide()
                })
                .catch(error => {
                    this.isError = true
                    me.messageError = error.response.data.error

                })
        }
    },
    created() {
        this.selectCicles()
    }

}
</script>
<style></style>