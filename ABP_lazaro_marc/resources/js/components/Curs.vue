<template>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Cursos</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Sigles</th>
                            <th>Nom</th>
                            <th>Cicle</th>
                            <th>Actiu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="curs in cursos">
                            <td>{{ curs.sigles }}</td>
                            <td>{{ curs.nom }}</td>
                            <td>{{ curs.cicle }}</td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="actiu" name="actiu"
                                        value="actiu" :checked="curs.actiu" disabled>
                                    <label for="actiu" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-secondary btn-sm me-2" @click="editCurs(curs)">
                                        <i class="bi bi-pencil-square"></i>Editar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="confirmDelete(curs)">
                                        <i class="bi bi-trash"></i>Esborrar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-mi btn-primary btn-sm float-end" @click="showForm()"><i class="bi bi-plus-lg"></i>Nou
                curs</button>
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
                    <p class="mb-0">Està segur que vol esborrar el cicle <strong>{{ curs.nom }}</strong>?</p>
                    <span v-if="isError" class="badge text-bg-danger">{{ messageError }}</span>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-x"></i>Tancar</button>
                    <button type="button" class="btn btn-danger" @click="deleteCurs()"><i
                            class="bi bi-trash"></i>Esborrar</button>

                </div>
            </div>
        </div>
    </div>
    <!--Modal insert/update -->
    <div class="modal fade" id="cursModal" tabindex="-1" aria-labelledby="lblCursModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 v-if="insert" class="modal-title fs-5" id="exampleModalLabel">Curs</h1>
                    <h1 v-else class="modal-title fs-5" id="exampleModalLabel">Modificar curs</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-2">
                            <label for="sigla" class="col-sm-2 col-form-label">Sigles</label>
                            <div class="col-sm-10">
                                <input type="text" name="sigla" id="sigla" class="form-control form-control-inline"
                                    autofocus required v-model="curs.sigles">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" name="nom" id="nom" class="form-control form-control-inline" required
                                    v-model="curs.nom">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="cicle" class="col-sm-2 col-form-label">Cicle</label>
                            <div class="col-sm-10">
                                <select class="form-select" v-model="curs.cicle_id">
                                    <option v-for="cicle in cicles" :value="cicle.id" :selected="cicle.id == curs.cicle_id">
                                        {{ cicle.nom }}</option>
                                </select>
                                <!-- <input type="text" name="cicle" id="cicle" class="form-control form-control-inline" required
                                   > -->
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-10">
                                <input type="checkbox" class="custom-control-input" id="actiu" name="actiu" value=""
                                    v-model="curs.actiu" :checked="curs.actiu">
                                <label for="actiu" class="custom-control-label">Actiu</label>
                            </div>
                        </div>
                    </form>
                    <span v-if="isError" class="badge text-bg-danger">{{ messageError }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-x"></i>Tancar</button>
                    <button v-if="insert" type="button" class="btn btn-primary" @click="insertCurs()"><i
                            class="bi bi-plus-circle"></i>
                        Crear</button>
                    <button v-else type="button" class="btn btn-primary" @click="updateCurs()"><i
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
            cursos: [],
            cicles: [],
            myModal: {},
            curs: {},
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
            this.curs = {}
            this.myModal = new bootstrap.Modal('#cursModal')
            this.myModal.show();
        },
        editCurs(curs) {
            this.isError = false
            this.insert = false
            this.curs = curs
            this.myModal = new bootstrap.Modal('#cursModal')
            this.myModal.show();
        },
        updateCurs() {
            const me = this
            axios
                .put('curso/' + me.curs.id, me.curs)
                .then(response => {
                    this.selectCursos()
                    me.myModal.hide()
                })
                .catch(error => {
                    this.isError = true
                    me.messageError = error.response.data.error

                })
        },
        insertCurs() {
            const me = this
            axios
                .post('curso', me.curs)
                .then(response => {
                    this.selectCursos()
                    me.myModal.hide()
                })
                .catch(error => {
                    this.isError = true
                    me.messageError = error.response.data.error

                })
        },
        selectCursos() {
            const me = this
            axios
                .get('curso')
                .then(response => {
                    me.cursos = response.data
                })
                .catch(error => {

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
        confirmDelete(curs) {
            this.isError = false
            this.curs = curs
            this.myModal = new bootstrap.Modal('#eliminaModal')
            this.myModal.show();
        },
        deleteCurs() {
            const me = this
            axios
                .delete('curso/' + me.curs.id)
                .then(response => {
                    this.selectCursos()
                    me.myModal.hide()
                })
                .catch(error => {
                    this.isError = true
                    me.messageError = error.response.data.error

                })
        }
    },
    created() {
        this.selectCursos()
        this.selectCicles()
    }

}
</script>
<style></style>