import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '../components/Login.vue';
import Registrar from '../components/Registrar.vue';
import Perfil from '../components/Perfil.vue';
import Carrinho from '../components/Carrinho.vue';
import Checkout from '../components/Checkout.vue';
import Painel from '../components/Painel.vue';
import Store from '../store';

Vue.use(VueRouter)


const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/registrar',
    name: 'Registrar',
    component: Registrar
  },
  {
    path: '/about',
    name: 'about',
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
    }
  },
  {
    path: '/perfil',
    name: 'Perfil',
    component: Perfil,
    meta: { requiresAuth: true }
  },
  {
    path: '/carrinho',
    name: 'Carrinho',
    component: Carrinho,
    meta: { requiresAuth: true }
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout,
    meta: { requiresAuth: true }
  },
  {
    path: '/painel',
    name: 'Painel Administrador',
    component: Painel,
    meta: { requiresAdmin: true }
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
    const user = Store.state.user;

    let routerAuthCheck = !!localStorage.getItem("token");
    
    if ( to.matched.some(record => record.meta.requiresAuth) )
    {
        if ( routerAuthCheck )
        {
              Store.dispatch('isLoggedIn', true)
              next();
        }
        else
        {
           router.replace('/login');
        }
    }
    // to.matched.some(record => record.meta.requiresAuth) &&
    if ( to.matched.some(record => record.meta.requiresAdmin) )
    {
          if ( user && user.is_admin )
          {
              next();
          }
          else
          {
            router.replace('/');
          }
        // if ( user.is_admin )
        // {
        //     console.log(user)
        //     next();
        // }
    }
    else
    {
        next()
    }
})

export default router
