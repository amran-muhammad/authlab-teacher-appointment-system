<template>
    <div>
        <h1>Profile</h1>
        <div class="card card-default">
            <div  v-if="success_message != ''"
                class="alert alert-success alert-dismissible fade show" role="alert">
                <button @click="success_message = ''" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                <strong>{{ success_message }}</strong>
            </div>
            <div class="card-header">
                <h5>{{ user.name }}</h5>
            </div>
            <div class="card-body">
                <div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control" v-model="user.name" required autofocus
                                autocomplete="off" placeholder="Enter your name">
                        </div>
                    </div>

                    <div class="form-group row mt-1">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control" v-model="user.email" required autofocus
                                autocomplete="off" placeholder="Enter your email">
                        </div>
                    </div>

                    <div class="form-group row mt-1">
                        <label for="type" class="col-sm-4 col-form-label text-md-right">User Type</label>
                        <div class="col-md-8">
                            <span class="form-control">
                                {{ user.type }}
                            </span>
                        </div>
                    </div>



                    <div v-if="user.department" class="form-group row mt-1">
                        <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                        <div class="col-md-8">
                            <span class="form-control">
                                {{ user.department }}
                            </span>
                        </div>
                    </div>

                    <div v-if="user.type == 'Teacher'" class="form-group row mt-1">
                        <label for="course" class="col-sm-4 col-form-label text-md-right"> Course Name</label>
                        <div class="col-md-8">
                            <span class="form-control">
                                {{ user.course }}
                            </span>
                        </div>
                    </div>

                    <div v-if="user.type == 'Student'" class="form-group row mt-1">
                        <label for="student_id" class="col-sm-4 col-form-label text-md-right">Student ID</label>
                        <div class="col-md-8">
                            <span class="form-control">
                                {{ user.student_id }}
                            </span>
                        </div>
                    </div>


                    <div class="form-group row mt-1 mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-success" @click="updateUser()">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Profile",
    data() {
        return {
            user: {
                id: '',
                name: "",
                email: "",
                password: "",
                type: "",
                course: "",
                department: "",
                student_id: ""
            },
            success_message: ref('')
        }
    },
    created() {
        if (window.Laravel.user) {
            this.user = window.Laravel.user
        }
    },
    methods: {
        updateUser() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', {
                    id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                })
                    .then(response => {
                        if (response.data.data) {
                            this.success_message = "Your profile has been updated successfully!"
                            this.user = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>