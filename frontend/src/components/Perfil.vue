<template>
    <div>
        <div class="container">
            <h3 class="text-white bg-success rounded">Pedidos</h3>
            <table class="table table-dark table-striped rounded">
                <thead>
                    <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Preço</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="pedido in pedidos.data" :key="pedido.id">
                    <th scope="row">{{ pedido.produtos[0].nome }}</th>
                    <th scope="row">{{ pedido.quantidade }}</th>
                    <th scope="row">{{ pedido.produtos[0].preco }}</th>
                </tr>
                </tbody>
            </table>

            <paginacao :data="pedidos" @pagination-change-page="pedidosPaginados" align="center">
                <span slot="prev-nav">&lt; Anterior</span>
                <span slot="next-nav">Próximo &gt;</span>
            </paginacao>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: 'Perfil',
        data() {
            return {
                pedidos: {},
            }
        },
        methods: {
            async pedidosPaginados(pagina = 1)
            {
                this.$http.get(`pedidos?page=${pagina}`)
                .then(response => {
                    this.pedidos = response.data
                })
            },
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
            this.me()
        },
        mounted() {
            this.pedidosPaginados()
        }
    }
</script>