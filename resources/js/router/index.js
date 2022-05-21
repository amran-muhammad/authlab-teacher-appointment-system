
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Teachers from '../pages/Teachers';
import Students from '../pages/Students';
import Profile from '../pages/Profile';
import Schedules from '../pages/Schedules';
import Bookings from '../pages/Bookings';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'teachers',
        path: '/teachers',
        component: Teachers
    },
    {
        name: 'students',
        path: '/students',
        component: Students
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile
    },
    {
        name: 'schedules',
        path: '/schedules',
        component: Schedules
    },
    {
        name: 'bookings',
        path: '/bookings',
        component: Bookings
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
