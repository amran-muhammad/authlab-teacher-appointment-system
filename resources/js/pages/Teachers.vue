<template>
    <div class="row">
        <Modal v-model="editStatusModal" title="Are you sure update the status?" @on-ok="updateTeacherStatus"
            @on-cancel="editStatusModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="addModal" title="Add New Teacher" @on-ok="addTeacher" @on-cancel="addModal = false"
            ok-text="Confirm" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">

                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="form_data.name" required
                                        autofocus autocomplete="off" placeholder="Enter name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="form_data.email"
                                        required autofocus autocomplete="off" placeholder="Enter email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control"
                                        v-model="form_data.password" required autocomplete="off"
                                        placeholder="Enter password">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.department">
                                        <option value="">Choose...</option>
                                        <option value="Department Name 1">Department Name 1</option>
                                        <option value="Department Name 2">Department Name 2</option>
                                        <option value="Department Name 3">Department Name 3</option>
                                        <option value="Department Name 4">Department Name 4</option>
                                        <option value="Department Name 5">Department Name 5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="course" class="col-sm-4 col-form-label text-md-right"> Course Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.course">
                                        <option value="">Choose...</option>
                                        <option value="Course Name 1">Course Name 1</option>
                                        <option value="Course Name 2">Course Name 2</option>
                                        <option value="Course Name 3">Course Name 3</option>
                                        <option value="Course Name 4">Course Name 4</option>
                                        <option value="Course Name 5">Course Name 5</option>
                                        <option value="Course Name 6">Course Name 6</option>
                                        <option value="Course Name 7">Course Name 7</option>
                                        <option value="Course Name 8">Course Name 8</option>
                                        <option value="Course Name 9">Course Name 9</option>
                                        <option value="Course Name 10">Course Name 10</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="status" class="col-sm-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.status">
                                        <option value="">Choose...</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>

        <Modal v-model="editModal" title="Edit New Teacher" @on-ok="updateTeacher" @on-cancel="editModal = false"
            ok-text="Confirm" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">

                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="edit_data.name" required
                                        autofocus autocomplete="off" placeholder="Enter name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="edit_data.email"
                                        required autofocus autocomplete="off" placeholder="Enter email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.department">
                                        <option value="">Choose...</option>
                                        <option value="Department Name 1">Department Name 1</option>
                                        <option value="Department Name 2">Department Name 2</option>
                                        <option value="Department Name 3">Department Name 3</option>
                                        <option value="Department Name 4">Department Name 4</option>
                                        <option value="Department Name 5">Department Name 5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="course" class="col-sm-4 col-form-label text-md-right"> Course Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.course">
                                        <option value="">Choose...</option>
                                        <option value="Course Name 1">Course Name 1</option>
                                        <option value="Course Name 2">Course Name 2</option>
                                        <option value="Course Name 3">Course Name 3</option>
                                        <option value="Course Name 4">Course Name 4</option>
                                        <option value="Course Name 5">Course Name 5</option>
                                        <option value="Course Name 6">Course Name 6</option>
                                        <option value="Course Name 7">Course Name 7</option>
                                        <option value="Course Name 8">Course Name 8</option>
                                        <option value="Course Name 9">Course Name 9</option>
                                        <option value="Course Name 10">Course Name 10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>


        <div class="col-md-12">
            <div class="card card-default">

                <div class="card-body">
                    <div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" v-model="edit_data.name" required
                                    autofocus autocomplete="off" placeholder="Enter name">
                            </div>
                        </div>

                        <div class="form-group row mt-1">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" v-model="edit_data.email" required
                                    autofocus autocomplete="off" placeholder="Enter email">
                            </div>
                        </div>


                        <div class="form-group row mt-1">
                            <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="edit_data.department">
                                    <option value="">Choose...</option>
                                    <option value="Department Name 1">Department Name 1</option>
                                    <option value="Department Name 2">Department Name 2</option>
                                    <option value="Department Name 3">Department Name 3</option>
                                    <option value="Department Name 4">Department Name 4</option>
                                    <option value="Department Name 5">Department Name 5</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mt-1">
                            <label for="course" class="col-sm-4 col-form-label text-md-right"> Course Name</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="edit_data.course">
                                    <option value="">Choose...</option>
                                    <option value="Course Name 1">Course Name 1</option>
                                    <option value="Course Name 2">Course Name 2</option>
                                    <option value="Course Name 3">Course Name 3</option>
                                    <option value="Course Name 4">Course Name 4</option>
                                    <option value="Course Name 5">Course Name 5</option>
                                    <option value="Course Name 6">Course Name 6</option>
                                    <option value="Course Name 7">Course Name 7</option>
                                    <option value="Course Name 8">Course Name 8</option>
                                    <option value="Course Name 9">Course Name 9</option>
                                    <option value="Course Name 10">Course Name 10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            Wellcome to Teachers, this page will show to admin
            <br>
            Total teachers: {{ teachers.length }}
            <br>
            <div>
                <button @click="addModal = true" class="btn btn-sm btn-secondary">Add New Teacher</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="search" class="col-sm-4 col-form-label text-md-right">Find A Teacher</label>
                    <input id="search" type="text" class="form-control" v-model="search" autofocus autocomplete="off"
                        placeholder="Enter teacher Email/Name">

                    <button style="margin-top:10px" class="btn btn-success" @click="searchUser()">
                        Search
                    </button>
                </div>
            </div>
        </div>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Teacher Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Course</th>
                    <th scope="col">Department</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-if="loader">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>

            </tbody>
            <tbody v-else>
                <tr v-for="(item, index) in teachers" :key="index">
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.course }}</td>
                    <td>{{ item.department }}</td>
                    <td>{{ item.status }}</td>
                    <td>
                        <button v-if="item.status == 'Pending'" class="btn btn-sm btn-success"
                            @click="editStatusModalOn(item, index)">Activate</button>
                        <button v-else class="btn btn-sm btn-info"
                            @click="editStatusModalOn(item, index)">Deactivate</button>
                        <button style="margin-left:5px" class="btn btn-sm btn-secondary"
                            @click="editTeacher(item, index)">Edit</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Teachers",
    data() {
        return {
            addModal: ref(false),
            editModal: ref(false),
            search: ref(''),
            teachers: [],
            loader: true,
            form_data: {
                name: '',
                email: '',
                password: '',
                department: '',
                course: '',
                status: '',
                type: 'Teacher'
            },
            edit_data: {
                id: '',
                name: '',
                email: '',
                password: '',
                department: '',
                course: '',
                status: '',
                type: 'Teacher'
            },
            editStatusModal: ref(false),
        }
    },
    created() {
        this.get_all_teacher()
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.user.type != 'Admin') {
            window.location.href = "/";
        }
        next();
    },
    methods: {
        get_all_teacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/teachers/all')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.teachers = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        addTeacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/create/new/teacher', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.teachers.unshift(response.data.data)
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        editTeacher(item, index) {
            this.editModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.name = item.name
            this.edit_data.department = item.department
            this.edit_data.course = item.course
            this.edit_data.email = item.email
        },
        editStatusModalOn(item, index) {
            this.editStatusModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.status = item.status == 'Pending' ? 'Approved' : 'Pending'
        },

        updateTeacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.teachers[this.editIndex] = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        updateTeacherStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', { id: this.edit_data.id, status: this.edit_data.status })
                    .then(response => {
                        if (response.data.data) {
                            this.editStatusModal = false
                            this.teachers[this.editIndex].id = response.data.data.id
                            this.teachers[this.editIndex].status = response.data.data.status
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        searchUser() {
            this.loader = true
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/user/search' + '?search=' + search.value + '&type=Teacher')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.teachers = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>