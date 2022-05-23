<template>
    <div class="container">
        <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
            <a class="navbar-brand" href="#">Teacher Appointment System</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="navbar-nav" v-if="isLoggedIn">
                <router-link to="/dashboard" class="nav-item nav-link">Dashboard</router-link>
                <router-link to="/bookings" class="nav-item nav-link">Bookings</router-link>
            </div>
            <div class="navbar-nav" v-if="isLoggedIn && type=='Admin'">
                <router-link to="/teachers" class="nav-item nav-link">Techers</router-link>
                <router-link to="/students" class="nav-item nav-link">Students</router-link>
            </div>
            <div class="navbar-nav" v-if="isLoggedIn && (type=='Teacher' || type=='Admin')">
                <router-link to="/schedules" class="nav-item nav-link">Schedules</router-link>
            </div>
            
            
            <div class="navbar-nav" v-if="isLoggedIn">
                <router-link to="/profile" class="nav-item nav-link">{{ type }} Profile ({{name}})</router-link>
                <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
            </div>
            <div class="navbar-nav" v-else>
                <router-link to="/" class="nav-item nav-link">Home</router-link>
                <router-link to="/login" class="nav-item nav-link">Login</router-link>
                <router-link to="/register" class="nav-item nav-link">Register</router-link>
            </div>
        </nav>


        <router-view></router-view>
    </div>
</template>
<script>
    export default {
        name: "App",
        data() {
            return {
                isLoggedIn: false,
                type:'',
                name:''
            }
        },
        created() {
            if (window.Laravel.isLoggedin) {
                this.isLoggedIn = true
                this.type = window.Laravel.user.type
                this.name = window.Laravel.user.name
            }
        },
        methods: {
            logout(e) {
                e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/logout')
                    .then(response => {
                        if(response.data.success) {
                            window.location.href = "/"
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