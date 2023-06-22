<template>
  <div id="app">
    <Loading>
      <nav class="navbar navbar-expand-lg navbar-light bg-success mb-2">
        <div class="container">
          <router-link to="/" class="navbar-brand text-light">
            MasterDaWeb
          </router-link>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item" v-if="!isLoggedIn" style="margin-top: 2px;">
                <router-link to="/login" class="nav-link text-white">
                  Login
                </router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn && user" style="margin-top: 2px;">
                <router-link to="/perfil" class="nav-link text-white">
                  {{ user.name }}
                </router-link>
              </li>
              <li class="nav-item" v-if="user && user.is_admin" style="margin-top: 2px;">
                <router-link to="/painel" class="nav-link text-white">
                  Painel Administrador
                </router-link>
              </li>
              <li class="nav-item" style="margin-top: 2px;" v-if="!isLoggedIn">
                <router-link to="/registrar" class="nav-link text-white">
                  Registrar
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/sobre" class="nav-link text-white" style="margin-top: 2px;">
                  Sobre
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/carrinho" class="nav-link text-white">
                    <button type="button" class="btn btn-sm btn-gradient">
                      <font-awesome-icon :icon="['fas', 'cart-shopping']" /> 
                      <span class="badge badge-light">
                        {{ produtosNoCarrinho.length > 0 ? produtosNoCarrinho.length : '' }}
                      </span>
                    </button>
                </router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn" style="margin-top: 2px;">
                <a href="" class="nav-link text-white" @click="logout">
                  Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <router-view/>
    </Loading>
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
.btn-gradient {
  background-color: rgb(98, 135, 160) !important;
}

    .swal2-popup {
      width: 500px; /* Ajuste o valor conforme necessário */
      height: 100px; /* Ajuste o valor conforme necessário */
    }
</style>



<script>
  import { mapGetters } from 'vuex';
  import Swal from 'sweetalert2';
  import Loading from './components/Loading.vue';

  export default
  {
      components: {
        Loading
      },
      methods: {
        validacao()
        {
          
            if ( this.isLoggedIn )
            {
              this.$http.get('v1/me')
                .then(response => {
                  this.$store.dispatch('user', response.data)
                })
                .catch((error) => {
                  localStorage.removeItem('token');
                  this.$store.dispatch('isLoggedIn', false)

                  const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                  });

                  Toast.fire({
                    icon: 'warning',
                    title: 'Realize o login novamente'
                  })

                  this.$router.push('/login');

                })
            }

        },
        logout()
        {
            localStorage.removeItem('token');
            this.$router.push('/');
        },
      },
      computed: {
          ...mapGetters(['user','produtosNoCarrinho', 'isLoggedIn']),
      },
      created() {
        this.validacao()
      }
  }
</script>