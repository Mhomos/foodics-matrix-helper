<template>
    <div id="main">
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <a class="navbar-brand" href="/dashboard">Matrix Helper</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto ">

                        <router-link to="/dashboard" class="nav-link" v-if="isLogged">Home</router-link>
                        <router-link to="/login" class="nav-link" v-if="!isLogged">Login</router-link>
                        <router-link to="/register" class="nav-link" v-if="!isLogged">Register</router-link>
                        <a  class="nav-link" v-if="isLogged" @click.prevent="logout">Logout</a>

                    </ul>
                </div>
            </nav>
            <router-view></router-view>



        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            has_error:true
        }
    },
    methods:{
        isLogged(){
            this.isLogged = !(localStorage.getItem('jwt'));
        },
        logout(){
            axios
                .get('/api/auth/logout')
                .then(response => {
                    localStorage.setItem('jwt', null);
                    this.$router.push({ name: 'login' });
                })
                .catch(error => {
                    this.has_error = true;
                });
        }
    }
}
</script>
