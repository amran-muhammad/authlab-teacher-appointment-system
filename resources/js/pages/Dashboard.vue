<template>
    <div class="row">
        <Modal v-model="bookModal" title="Are you sure book the schecule?" @on-ok="bookingConfirm"
            @on-cancel="bookModal = false" ok-text="Confirm" draggable sticky loading>
            <div class="card card-default">

                <div class="card-body">
                    <div>
                        <div class="form-group row">
                            <div v-if="error != ''" class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button @click="error = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>

                                    <strong>{{ error }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <label for="name" class="col-sm-8 col-form-label text-md-right">Agenda of the Appintment
                            </label>
                            <div class="col-sm-4"></div>
                            <div class="col-md-8">
                                <textarea id="name" type="textarea" class="form-control" v-model="booking_data.agenda"
                                    required autofocus autocomplete="off" placeholder="Enter your agenda" />
                            </div>
                        </div>
                        <div class="form-group row mt-1">
                            <div class="col-md-8 offset-md-4">
                                <h5>Appointment date will be assigned by <b>{{ teacher }}</b> on <b>{{ day }}</b> at any
                                    date.</h5>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </Modal>
        <div v-if="success_message != ''" class="form-group row">
            <div class="col-sm-4"></div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button @click="success_message = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>

                <strong>{{ success_message }}</strong>
            </div>
        </div>
        <div v-if="error_message != ''" class="form-group row">
            <div class="col-sm-4"></div>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button @click="error_message = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>

                <strong>{{ error_message }}</strong>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="search" class="col-sm-4 col-form-label text-md-right">Find schedules by department
                        name</label>
                    <select @change="searchUser()" class="form-control" v-model="search">
                        <option value="All">Choose...</option>
                        <option value="All">All</option>
                        <option value="Department Name 1">Department Name 1</option>
                        <option value="Department Name 2">Department Name 2</option>
                        <option value="Department Name 3">Department Name 3</option>
                        <option value="Department Name 4">Department Name 4</option>
                        <option value="Department Name 5">Department Name 5</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="search" class="col-sm-4 col-form-label text-md-right">Find schedules by teacher</label>
                    <select @change="searchUser()" class="form-control" v-model="search">
                        <option value="All">Choose...</option>
                        <option value="All">All</option>
                        <option v-for="(item, index) in active_teachers" :key="index" :value="item.id"> {{ item.name }}
                        </option>
                    </select>
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
                    <th scope="col">Day</th>
                    <th scope="col">Slot</th>
                    <th scope="col">Status</th>
                    <th v-if="user.type == 'Student'" scope="col">Action</th>
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
                    <td>{{ item.user_details.email }}</td>
                    <td>{{ item.user_details.course }}</td>
                    <td>{{ item.department }}</td>
                    <td>{{ item.day }}</td>
                    <td>
                        From
                        {{
                                item.start_time < 12 ? item.start_time + ' AM' : (item.start_time - 12 == 0 ? 12 : item.start_time
                                    - 12) + ' PM'
                        }} To {{ item.end_time < 12 ? item.end_time + ' AM' : (item.end_time - 12 == 0 ?
        12 : item.end_time - 12) + ' PM'
}} </td>
                    <td>{{ item.status == 'Pending' ? 'Closed' : 'Open' }}</td>
                    <td>
                        <button v-if="user.type == 'Student' && item.status == 'Approved'" style="margin-left:5px"
                            class="btn btn-sm btn-secondary" @click="bookModalOn(item, index)">Book Now</button>
                        <button disabled v-if="user.type == 'Student' && item.status == 'Pending'"
                            style="margin-left:5px" class="btn btn-sm btn-secondary">Book Now</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Dashboard",
    data() {
        return {
            search: ref(''),
            schedules: [],
            active_teachers: [],
            loader: true,
            bookModal: ref(false),
            user: {},
            booking_data: {
                schedule_id: '',
                user_id: '',
                student_id: '',
                status: '',
                agenda: '',
                appointment: ''
            },
            day: '',
            teacher: '',
            error: ref(''),
            success_message: ref(''),
            error_message: ref(''),
        }
    },
    created() {
        if (window.Laravel.user) {
            this.user = window.Laravel.user
        }
        this.get_dashboard_schedules()
        this.get_all_teacher()
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.user) {
            window.location.href = "/";
        }
        next();
    },
    methods: {
        get_all_teacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/dashboard/teachers/all')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.active_teachers = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        get_dashboard_schedules() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/dashboard/schedules/all')
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

        bookModalOn(item, index) {
            this.bookModal = true
            this.editIndex = index
            this.day = item.day
            this.teacher = item.user_details.name
            this.booking_data.schedule_id = item.id
            this.booking_data.user_id = item.user_id
            this.booking_data.student_id = this.user.student_id
            this.booking_data.status = 'Pending'
            this.booking_data.agenda = ''
        },

        bookingConfirm() {
            if (this.booking_data.agenda == '') {
                this.error = 'Please provide and agenda for your booking!'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/booking/create', this.booking_data)
                    .then(response => {
                        if (response.data.data) {
                            this.bookModal = false
                            this.success_message = 'Booking request sent to ' + this.schedules[this.editIndex].user_details.name + ' for '
                                + this.schedules[this.editIndex].day
                                + ' From ' +
                                (
                                    this.schedules[this.editIndex].start_time < 12 ? this.schedules[this.editIndex].start_time + ' AM' : (this.schedules[this.editIndex].start_time - 12 == 0 ? 12 : this.schedules[this.editIndex].start_time
                                        - 12) + ' PM'
                                ) + ' To ' + (this.schedules[this.editIndex].end_time < 12 ? this.schedules[this.editIndex].end_time + ' AM' : (this.schedules[this.editIndex].end_time - 12 == 0 ?
                                    12 : this.schedules[this.editIndex].end_time - 12) + ' PM')


                        } else {
                            if (response.data.msg) {
                                this.error_message = response.data.msg
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
        searchUser() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/dashboard/search' + '?search=' + this.search)
                    .then(response => {
                        if (response.data.data) {
                            this.schedules = response.data.data
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