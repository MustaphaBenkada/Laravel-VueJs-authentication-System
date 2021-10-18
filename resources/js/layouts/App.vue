<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <router-link :to="{ name: '/' }" class="navbar-brand"
        >Laravel-Vue SPA</router-link
      >
      <button
        class="navbar-toggler"
        data-toggle="collapse"
        data-target="#navbarCollapse"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarCollapse" class="collapse navbar-collapse right">
        <ul class="navbar-nav">
         
          <li class="nav-link" v-if="isLoggedIn"> Hi, {{name}}</li>
          <li class="nav-item">
            <router-link v-if="!isLoggedIn"
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'register' }"
            >
              Register
            </router-link>
          </li>

          <li class="nav-item">
            <router-link v-if="!isLoggedIn"
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'login' }"
            >
              Login
            </router-link>
          </li>
          <li class="nav-item" v-if="isLoggedIn">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'board' }"
            >
              Board
            </router-link>
          </li>
          <li class="nav-item" v-if="isLoggedIn">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'welcome' }"
            >
              Welcome
            </router-link>
          </li>

          <li class="nav-item nav-link aslink" v-if="isLoggedIn" @click="logout">
           
              Logout
            
          </li>

        </ul>
      </div>
    </nav>

    <div class="container ">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  data(){
      return {
          isLoggedIn : null,
          name : null,
          token : localStorage.getItem('jwt'),
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
  },
  mounted(){
      this.isLoggedIn = localStorage.getItem('jwt')
      this.name = localStorage.getItem('user')
    // console.log(localStorage.getItem('jwt'));
  },
  watch: {
    $route() {
      $("#navbarCollapse").collapse("hide");
    },
  },
  methods:{
    logout(e){
      e.preventDefault();
       let token = localStorage.getItem('jwt');
      // this.token = token;
       console.log(token);
      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

      axios.get('http://localhost/vueApp/public/api/logout').then(response => {
           console.log(response.data);
           if(response.data.success === true){
              localStorage.removeItem('jwt');
              localStorage.removeItem('user');
              this.$router.go('/login');
            }else{
              alert(response.data.message);
            }
          }).catch(error => {
             console.error(error);
          });
         
    }
  },

  
};
</script>
<style scoped>
.aslink{

  cursor: pointer;
}

.navbar-nav {
    margin-left: auto;
}
.container {
    margin-top: 50px;
}
</style>