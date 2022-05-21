<template>
    <div class="row">
        <Modal 
        v-model="deleteModal" 
        title="Are you sure delete the booking?" 
        @on-ok="deleteBooking"
        @on-cancel="deleteModal = false" 
        ok-text="Confirm" 
        draggable 
        sticky 
        loading 
        >
        </Modal>
        <Modal ok-text="Confirm" v-model="bookModal" title="Are you sure update the status of the booking?" @on-ok="statusUpdate"
            @on-cancel="statusEditCancel" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div v-if="error != ''" class="form-group row">
                                    <div class="col-sm-4"></div>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button @click="error = ''" type="button" class="btn-close"
                                            data-bs-dismiss="alert" aria-label="Close"></button>

                                        <strong>{{ error }}</strong>
                                    </div>
                                </div>
                                <div v-if="booking_data.status == 'Approved'" class="col-sm-4"></div>
                                <label v-if="booking_data.status == 'Approved'" for="appointment"
                                    class="col-sm-8 col-form-label text-md-right">Appintment Date
                                </label>
                                <div v-if="booking_data.status == 'Approved'" class="col-sm-4"></div>
                                <div v-if="booking_data.status == 'Approved'" class="col-md-8">
                                    <input id="appointment" type="date" class="form-control"
                                        v-model="booking_data.appointment" required autofocus autocomplete="off">
                                </div>
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

        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Teacher</th>
                    <th v-if="user.type == 'Teacher' || user.type == 'Admin'" scope="col">Student</th>
                    <th scope="col">Agenda</th>
                    <th scope="col">Day</th>
                    <th scope="col">Slot</th>
                    <th scope="col">Appointment</th>
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
                <tr v-for="(item, index) in bookings" :key="index">
                    <td v-if="user.type == 'Student' || user.type == 'Admin'">
                        <p>{{ item.teacher.name }}</p>
                        <p>{{ item.teacher.email }}</p>
                        <p>{{ item.teacher.department }}</p>
                        <p>{{ item.teacher.course }}</p>
                    </td>
                    <td v-if="user.type == 'Teacher' || user.type == 'Admin'">
                        <p>{{ item.student.name }}</p>
                        <p>{{ item.student.email }}</p>
                        <p>{{ item.student.department }}</p>
                        <p>{{ item.student.student_id }}</p>
                    </td>
                    <td>{{ item.agenda }}</td>
                    <td>{{ item.schedule.day }}</td>

                    <td>
                        From
                        {{
                                item.schedule.start_time < 12 ? item.schedule.start_time + ' AM' : (item.schedule.start_time -
                                    12 == 0 ? 12 : item.schedule.start_time - 12) + ' PM'
                        }} To {{ item.schedule.end_time < 12 ?
        item.schedule.end_time + ' AM' : (item.schedule.end_time - 12 == 0 ? 12 :
            item.schedule.end_time - 12) + ' PM'
}} </td>
                    <td>
                        <span v-if="item.appointment">{{ item.appointment }}</span>
                    </td>
                    <td>{{ item.status == 'Pending' ? 'Closed' : 'Open' }}</td>
                    <td>
                        <button v-if="(user.type == 'Admin' || user.type == 'Teacher') && item.status == 'Pending'"
                            style="margin-left:5px" class="btn btn-sm btn-secondary"
                            @click="statusEdit(item, index, 'Approved')">Approve</button>

                        <button v-if="(user.type == 'Admin' || user.type == 'Teacher') && item.status == 'Approved'"
                            style="margin-left:5px" class="btn btn-sm btn-info"
                            @click="statusEdit(item, index, 'Pending')">Decline</button>
                        <button style="margin-left:5px" class="btn btn-sm btn-danger"
                            @click="deleteModalOn(item, index)">Delete</button>

                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
import { ref } from 'vue';
import moment from 'moment';

export default {
    name: "Bookings",
    data() {
        return {
            search: ref(''),
            bookings: [],
            active_teachers: [],
            loader: true,
            bookModal: ref(false),
            deleteModal: ref(false),
            user: {},
            booking_data: {
                id: '',
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
        this.get_dashboard_bookings()
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.user) {
            window.location.href = "/";
        }
        next();
    },
    methods: {

        get_dashboard_bookings() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/booking/all')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.bookings = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },

        statusEdit(item, index, status) {
            this.bookModal = true
            this.editIndex = index
            this.booking_data.id = item.id
            this.booking_data.status = status
            this.booking_data.appointment = item.appointment
        },
        statusEditCancel() {
            this.bookModal = false
            this.booking_data.id = ""
            this.booking_data.status = ""
        },
        deleteModalOn(item, index) {
            this.deleteModal = true
            this.editIndex = index
            this.booking_data.id = item.id
        },

        statusUpdate() {
            if (this.booking_data.status == 'Approved') {
                if (this.booking_data.appointment == '' || !this.booking_data.appointment) {
                    this.error = 'Please provide a date on ' + this.bookings[this.editIndex].schedule.day + ' your booking!'
                    return
                }

                if (moment(this.booking_data.appointment).format('dddd') == this.bookings[this.editIndex].schedule.day) {
                    this.error = 'Please provide a date on ' + this.bookings[this.editIndex].schedule.day + ' your booking!'
                    return
                }
            }

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put('/api/booking/update', this.booking_data)
                    .then(response => {
                        if (response.data.data) {
                            this.bookModal = false
                            this.bookings[this.editIndex].status = response.data.status
                            if (response.data.appointment) {
                                this.bookings[this.editIndex].appointment = response.data.appointment
                            }
                            this.success_message = 'Booking request approved'
                            this.booking_data.id = ''
                            this.booking_data.appointment = ''
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
        deleteBooking() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/booking/delete', this.booking_data)
                    .then(response => {
                        if (response.data.data) {
                            this.deleteModal = false
                            this.bookings.splice(this.editIndex, 1)
                            this.success_message = 'Booking request deleted'
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

    },
}
</script>