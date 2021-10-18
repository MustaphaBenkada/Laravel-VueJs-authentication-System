<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form method="POST" action="/register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Register
                                    </button>
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

export default {
    data(){
        return {
           name : "",
           email : "",
           password : "",
           password_confirmation : ""
        }      
    },
    methods : {
       handleSubmit(e){
           e.preventDefault();

            console.log(window.location);

           if(this.password === this.password_confirmation && this.password.length  >=3){
               axios.post('http://localhost/vueApp/public/api/register',{
                    name : this.name,
                    email : this.email,
                    password : this.password,
                    password_confirmation : this.password_confirmation
               }).then(response => {
                   localStorage.setItem('user',response.data.success.name)
                   localStorage.setItem('jwt',response.data.success.token)

                   if(localStorage.getItem('jwt') != null ){
                       this.$router.go('/board');
                   }
               }).catch(error => {
                 console.error(error);
                });
           }else {
                console.log(this.password);
                console.log(this.password_confirmation);

                this.password = ""
                this.password_confirmation = ""

                return alert('Passwords do not match')
            }

       }
    },

    beforeRouteEnter (to, from, next) { 
        if (localStorage.getItem('jwt')) {
            return next('board');
        }
        next();
    }
}
</script>
