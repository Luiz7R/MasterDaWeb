<template>
  <div class="container">
    <table class="table table-dark table-striped" style="border-radius: 10px;">
        <thead>
            <tr>
              <th scope="col">Produto</th>
              <th scope="col">Preço</th>
              <th scope="col">Carrinho</th>
            </tr>
        </thead>
        <tbody>
          <tr v-for="produto in produtosPaginados.data" :key="produto.id">
            <th scope="row">{{ produto.nome }}</th>
            <th scope="row">R$ {{ produto.preco }}</th>
            <th scope="row">
              <button type="submit" class="add-to-cart btn btn-primary text-white" @click="adicionarCarrinho(produto)">
                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
              </button>
            </th>
          </tr>
        </tbody>
    </table>

    <paginacao :data="produtosPaginados" @pagination-change-page="produtosPaginado" align="center">
        <span slot="prev-nav">&lt; Anterior</span>
        <span slot="next-nav">Próximo &gt;</span>
    </paginacao>
  </div>
</template>

<style>
.swal-text {
  text-align: center;
  color: #f1ebe9;
  font-size: 15px;
}

</style>
<script>
import HelloWorld from '@/components/HelloWorld.vue'
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { mapGetters } from 'vuex';

export default {
    name: 'HomeView',
    components: {
      HelloWorld,
      Swal
    },
    data() {
      return {
        produtos: ref({}),
        produtosPaginados: {}
      }
    },
    methods: {
      async produtosPaginado(pagina = 1)
      {
        this.$http.get(`produtos?page=${pagina}`)
          .then(response => {
            const produtosValoresFormatados = response.data.data.map((produto) => {
                return {
                  preco: this.formatarValor(produto.preco),
                  ...produto
                }
            });
            this.produtosPaginados = response.data
          })
      },
      adicionarCarrinho(produto) {
        if ( this.produtosNoCarrinho.indexOf(produto) === -1 )
        {
            produto.quantidade ? produto.quantidade++ : produto.quantidade = 1;
            
            this.$http.post('/carrinho', produto)
              .then(response => console.log(response.data))
              .catch(error => console.error(error))
            this.notificacaoSwal()
        }
      },
      formatarValor(valor) {
            return valor.toLocaleString('pt-br', {minimumFractionDigits: 2})
      },
      notificacaoSwal()
      {
          Swal.fire({
              title: 'Sucesso',
              html: '<span class="swal-text">Produto Adicionado ao Carrinho com Sucesso!</span>',
              width: 400,
              timer: 1000,
              timerProgressBar: true,
              position: 'top-end',
              background: '#0d8527',
              customClass: {
                title: 'text-white'
              },
              showConfirmButton: false
          });
      }
    },
    computed: {
          ...mapGetters(['produtosNoCarrinho']),
    },
    mounted() {
      this.produtosPaginado()
    }
}
</script>
