<template>
    <div class="row">
        <Modal v-model="editStatusModal" title="Are you sure update the status?" @on-ok="updateScheduleStatus"
            @on-cancel="editStatusModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="deleteModal" title="Are you sure delete the schedule?" @on-ok="deleteSchedule"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="addModal" title="Add New Schedule" @on-ok="addSchedule" @on-cancel="addModal = false"
            ok-text="Save" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">
                    <div v-if="message != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button @click="message = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <strong>{{ message }}</strong>
                    </div>

                    <div class="card-body">
                        <div>
                            <div v-if="user.type == 'Admin'" class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Teacher Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.user_id">
                                        <option value="">Choose...</option>
                                        <option v-for="(item, index) in teachers" :key="index" :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Day</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.day">
                                        <option value="">Choose...</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Start Time</label>
                                <div class="col-md-8">
                                    <select class="form-control" @click="changeEndTime" v-model="form_data.start_time">
                                        <option value="">Choose...</option>
                                        <option v-for="n in 24" :key="n" :value="n">{{ n }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">End Time</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.end_time">
                                        <option value="">Choose...</option>
                                        <option v-for="n in limit" :value="n + form_data.start_time" :key="n">
                                            {{ n + form_data.start_time }}
                                        </option>
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
        <Modal v-model="editModal" title="Edit Schedule" @on-ok="updateSchedule" @on-cancel="editModal = false"
            ok-text="Update" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">
                    <div v-if="message != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button @click="message = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <strong>{{ message }}</strong>
                    </div>

                    <div class="card-body">
                        <div>
                            <div v-if="user.type == 'Admin'" class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Teacher Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.user_id">
                                        <option value="">Choose...</option>
                                        <option v-for="(item, index) in teachers" :key="index" :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Day</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.day">
                                        <option value="">Choose...</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Start Time</label>
                                <div class="col-md-8">
                                    <select class="form-control" @click="changeEndTimeInEdit"
                                        v-model="edit_data.start_time">
                                        <option value="">Choose...</option>
                                        <option v-for="n in 24" :key="n" :value="n">{{ n }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">End Time</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.end_time">
                                        <option value="">Choose...</option>
                                        <option v-for="n in limit" :value="n + edit_data.start_time" :key="n">
                                            {{ n + edit_data.start_time }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>

        <h1>Schedules</h1>

        <div class="col-md-6">
            <div>
                <button @click="addModalOn()" class="btn btn-sm btn-secondary">Add New Schedule</button>
            </div>
        </div>

        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Teacher Name</th>
                    <th scope="col">Day</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
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
                <tr v-for="(item, index) in schedules" :key="index">
                    <td>{{ item.user_details.name }}</td>
                    <td>{{ item.day }}</td>
                    <td>{{ item.start_time }}</td>
                    <td>{{ item.end_time }}</td>
                    <td>{{ item.department }}</td>
                    <td>{{ item.status }}</td>
                    <td>
                        <button v-if="item.status == 'Pending'" class="btn btn-sm btn-success"
                            @click="editStatusModalOn(item, index)">Activate</button>
                        <button v-else class="btn btn-sm btn-info"
                            @click="editStatusModalOn(item, index)">Deactivate</button>
                        <button style="margin-left:5px" class="btn btn-sm btn-secondary"
                            @click="editSchedule(item, index)">Edit</button>
                        <button style="margin-left:5px" class="btn btn-sm btn-danger"
                            @click="deleteScheduleOn(item, index)">Delete</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Schedules",
    data() {
        return {
            deleteModal: ref(false),
            addModal: ref(false),
            editModal: ref(false),
            schedules: [],
            loader: true,
            form_data: {
                day: '',
                start_time: '',
                end_time: '',
                status: '',
                department: '',
                user_id: '',
            },
            edit_data: {
                id: '',
                start_time: '',
                end_time: '',
                status: '',
                department: '',
                user_id: '',
            },
            editStatusModal: ref(false),
            limit: ref(0),
            user: {},
            teachers: [],
            message: ref(''),
        }
    },
    created() {
        this.get_all_schedules()
        if (window.Laravel.user) {
            this.user = window.Laravel.user
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.user.type != 'Admin' && window.Laravel.user.type != 'Teacher') {
            window.location.href = "/";
        }
        next();
    },
    methods: {
        get_all_schedules() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/schedules/all')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.schedules = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        addSchedule() {
            if (this.user.type == 'Admin' && this.form_data.user_id == '') {
                this.message = 'Select a teacher'
                return
            }
            if (this.form_data.day == '') {
                this.message = 'Select a day'
                return
            }
            else if (this.form_data.start_time == '') {
                this.message = 'Select a start time'
                return
            }
            else if (this.form_data.end_time == '') {
                this.message = 'Select an end time'
                return
            }
            else if (this.form_data.status == '') {
                this.message = 'Select a status'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/schedules/create', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.addModal = false
                            this.schedules.unshift(response.data.data)
                            this.form_data.user_id = ''
                            this.form_data.day = ''
                            this.form_data.start_time = ''
                            this.form_data.end_time = ''
                            this.form_data.status = ''
                        } else {
                            if (response.data.msg) {
                                this.message = response.data.msg
                                return
                            } else {
                                console.log(response);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        editSchedule(item, index) {
            this.editModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.day = item.day
            this.edit_data.start_time = item.start_time
            this.edit_data.end_time = item.end_time
            this.edit_data.user_id = item.user_id
            this.edit_data.department = item.department
            this.edit_data.status = item.status
            this.limit = 24 - this.edit_data.start_time
            if (this.user.type == 'Admin') {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.get('/api/teachers/all')
                        .then(response => {
                            if (response.data.data) {
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
        editStatusModalOn(item, index) {
            this.editStatusModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.user_id = item.user_id
            this.edit_data.status = item.status == 'Pending' ? 'Approved' : 'Pending'
        },
        deleteScheduleOn(item, index) {
            this.deleteModal = true
            this.editIndex = index
            this.edit_data.id = item.id
        },
        deleteSchedule() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/schedules/delete', {
                    id: this.edit_data.id
                })
                    .then(response => {
                        if (response.data.data) {
                            this.deleteModal = false
                            this.schedules.splice(this.editIndex, 1)
                            this.editIndex = -1
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },

        updateSchedule() {
            if (this.user.type == 'Admin' && this.edit_data.user_id == '') {
                this.message = 'Select a teacher'
                return
            }
            if (this.edit_data.day == '') {
                this.message = 'Select a day'
                return
            }
            else if (this.edit_data.start_time == '') {
                this.message = 'Select a start time'
                return
            }
            else if (this.edit_data.end_time == '') {
                this.message = 'Select an end time'
                return
            }
            else if (this.edit_data.status == '') {
                this.message = 'Select a status'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put('/api/schedules/update', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.editModal = false
                            this.schedules[this.editIndex] = response.data.data
                            this.edit_data.user_id = ''
                            this.edit_data.day = ''
                            this.edit_data.start_time = ''
                            this.edit_data.end_time = ''
                            this.edit_data.status = ''
                        } else {
                            if (response.data.msg) {
                                this.message = response.data.msg
                                return
                            } else {
                                console.log(response);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        updateScheduleStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put('/api/schedules/update', { id: this.edit_data.id, status: this.edit_data.status, user_id: this.edit_data.user_id })
                    .then(response => {
                        if (response.data.data) {
                            this.editStatusModal = false
                            this.schedules[this.editIndex].id = response.data.data.id
                            this.schedules[this.editIndex].status = response.data.data.status
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        changeEndTime() {
            this.limit = 24 - this.form_data.start_time
        },
        changeEndTimeInEdit() {
            this.limit = 24 - this.edit_data.start_time
        },

        addModalOn() {
            this.addModal = true
            if (this.user.type == 'Admin') {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.get('/api/teachers/all')
                        .then(response => {
                            if (response.data.data) {
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
        }
    },
}
</script>