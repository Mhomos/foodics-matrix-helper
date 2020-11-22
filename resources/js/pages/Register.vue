<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Inscription</div>
            <div class="card-body">

                <form autocomplete="off" @submit.prevent="register" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Name" v-model="name">

                    </div>
                    <div class="form-group" >
                        <label for="email">E-mail</label>
                        <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">
                    </div>
                    <div class="form-group" >
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="password">
                    </div>
                    <div class="form-group" >
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-default">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        }
    },
    methods: {
        register() {
            axios
                .post('/api/auth/signup', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then(response => {
                    this.$router.push({ name: 'login' });
                })
                .catch(error => {
                    this.has_error = true;
                });
        },
        redirect: function(response) {

        }
    }
}
</script>
