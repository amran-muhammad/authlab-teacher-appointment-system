<template>
    <div>
        Welcome {{ name }}
         <Modal
            v-model="deleteModal" 
            title="Are you sure delete the booking?" 
            @on-ok="deleteModal=false"
            @on-cancel="deleteModal = false" 
            ok-text="Confirm" 
            draggable 
            sticky 
            loading 
        >

        </Modal>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            name: null,
            deleteModal:false,
        }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
        }
    },
    methods: {

    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>