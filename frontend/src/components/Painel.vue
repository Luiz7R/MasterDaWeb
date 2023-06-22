<template>
        <div class="container">
            <h3 class="text-white bg-success rounded">Painel Administrador</h3>
            <div class="row" style="margin-bottom: 2rem; margin-top: 1rem;">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Produtos Mais Vendidos
                        </div>
                        <div class="card-body">
                            <ProdutosVendidosGrafico />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Lucro por Produto
                        </div>
                        <div class="card-body">
                            <LucroProdutosGrafico />
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import ProdutosVendidosGrafico from './ProdutosVendidosGrafico.vue'
    import LucroProdutosGrafico from './LucroProdutosGrafico.vue'

    export default {
        name: 'Painel',
        components: {
            ProdutosVendidosGrafico,
            LucroProdutosGrafico
        }, 
        data() {
            return {
                pedidos: {}
            }
        },
        methods: {
            me()
            {
                this.$http.get('v1/me')
                    .then(response => {
                        this.$store.dispatch('user', response.data)
                    }
                ).catch((error) => {
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

                })
            }
        },
        computed: {
            ...mapGetters(['user'])
        },
        created() {
            //this.me()
        },
        mounted() {
            this.pedidosPaginados()
        }
    }
</script>