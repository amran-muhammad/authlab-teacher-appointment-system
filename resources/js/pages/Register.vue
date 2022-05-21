<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{ error }}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header">
                        <h5>Register New User</h5>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus
                                        autocomplete="off" placeholder="Enter your name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                        autofocus autocomplete="off" placeholder="Enter your email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                        required autocomplete="off" placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="type" class="col-sm-4 col-form-label text-md-right">User Type</label>
                                <div class="col-md-8">
                                    <select @change="modeAssigned()" class="form-control" v-model="type">
                                        <option value="">Choose...</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Student">Student</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="department">
                                        <option value="">Choose...</option>
                                        <option value="Department Name 1">Department Name 1</option>
                                        <option value="Department Name 2">Department Name 2</option>
                                        <option value="Department Name 3">Department Name 3</option>
                                        <option value="Department Name 4">Department Name 4</option>
                                        <option value="Department Name 5">Department Name 5</option>
                                    </select>
                                </div>
                            </div>

                            <div v-if="mode == 'Teacher'" class="form-group row mt-1">
                                <label for="course" class="col-sm-4 col-form-label text-md-right"> Course Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="course">
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

                            <div v-if="mode == 'Student'" class="form-group row mt-1">
                                <label for="student_id" class="col-sm-4 col-form-label text-md-right">Student ID</label>
                                <div class="col-md-8">
                                    <input id="student_id" type="text" class="form-control" v-model="student_id"
                                        required autofocus autocomplete="off" placeholder="Enter your student id">
                                </div>
                            </div>


                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="handleSubmit">
                                        Register
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                        Have an account? Please
                                        <router-link to="/login">login</router-link>
                                    </small>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'

export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            type: "",
            course: "",
            department: "",
            student_id: "",
            error: null,
            mode: ref('')
        }
    },

    methods: {
        handleSubmit(e) {
            if (this.name == "") {
                this.error = "Name is required!"
                return
            }
            else if (this.email == "") {
                this.error = "Email is required!"
                return
            }
            else if (this.password == "") {
                this.error = "Password is required!"
                return
            }
            else if (this.type == "") {
                this.error = "User type is required!"
                return
            }
            else if (this.department == "") {
                this.error = "Department is required!"
                return
            }
            else if (this.type == "Student" && this.student_id == '') {
                this.error = "Stdent ID is required!"
                return
            }
            else if (this.type == "Teacher" && this.course == '') {
                this.error = "Course is required!"
                return
            }

            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        type: this.type,
                        course: this.course,
                        department: this.department,
                        student_id: this.student_id,
                    })
                        .then(response => {
                            if (response.data.success) {
                                window.location.href = "/login"
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        },

        modeAssigned() {
            if (this.type == 'Student') {
                this.mode = 'Student'
            } else {
                this.mode = 'Teacher'
            }
        },
    },


    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
