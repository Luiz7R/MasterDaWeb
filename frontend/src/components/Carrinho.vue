<template>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h3 class="text-center text-dark bg-success" style="border-radius: 3px;">Carrinho</h3>
                <table class="table table-dark table-striped" style="border-radius: 3px;" v-if="produtosNoCarrinho.length > 0">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Preço Unitário</th>
                            <th scope="col">SubTotal</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in produtosNoCarrinho" :key="item.id">
                            <th scope="row">{{ item.nome }}</th>
                            <th scope="row">{{ item.precoUnitarioFormatado }}</th>
                            <th scope="row">{{ item.precoTotalFormatado }}</th>
                            <th scope="row">
                                <div>
                                    <input type="number" class="text-center" @change="alterarQuantidade(item)" v-model="item.quantidade" style="max-width: 50px; border-radius: 7px;">
                                </div>
                            </th>
                            <th scope="row">
                                <a href="javascript:undefined" style="color: white !important;" @click="remover(item)">
                                    <font-awesome-icon :icon="['fas', 'trash-can']" />
                                </a >
                            </th>
                        </tr>
                    </tbody>
                </table>
                <div v-if="!produtosNoCarrinho.length > 0">
                    <h4 class="text-center text-white">
                        Nenhum produto no Carrinho!
                    </h4>
                </div>
            </div>
            <div class="col-4" style="background-color:rgb(39, 156, 117); border-radius: 5px; max-height: 20%;">
                <div class="container">
                    <div class="row">
                        <div class="col text-left pb-2 pt-3">
                            <h3>Produtos</h3>
                        </div>
                        <div class="pt-3" v-if="produtosNoCarrinho.length > 0">
                            <h5>Total de Itens:</h5>
                            <h3>{{ produtosNoCarrinho.length }}</h3>
                        </div>
                        <div class="pt-3">
                            <h5>Total dos Produtos:</h5>
                            <h3>R$ {{ valorTotal }}</h3>
                        </div>
                        <div class="cart-checkout mt-5 mb-2">
                            <button class="btn checkoutBtn text-white" style="font-size: 20px;" 
                                @click="fecharPedido" :disabled="!desativado">
                                    <font-awesome-icon :icon="['fas', 'cart-shopping']" /> 
                                    Fechar Pedido
                            </button>
                        </div>
                        <div class="mt-2 mb-2">
                            <button class="btn text-white comprarMBtn" @click="comprarMais">
                                Comprar Mais
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<style>

    .cart {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 5px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .cart-total {
      font-size: 24px;
    }

    .cart-quantity {
      font-size: 24px;
      margin: 0 20px;
    }

    .checkout-btn {
      font-size: 18px;
    }
    
.checkoutBtn {
	box-shadow: -1px 1px 6px 1px #276873;
	background:linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
	background-color:#599bb3;
	border-radius:8px;
	border:1px solid #29668f;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Georgia;
	font-size:15px;
	font-weight:bold;
	padding:7px 22px;
	text-decoration:none;
	text-shadow:2px 4px 0px #3d768a;
}

.comprarMBtn {
	box-shadow: 0px 10px 14px -7px #276873;
	background:linear-gradient(to bottom, #e86f12 5%, #997140 100%);
	background-color:#e86f12;
	border-radius:8px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:20px;
	font-weight:bold;
	padding:13px 32px;
	text-decoration:none;
	text-shadow:0px 1px 0px #3d768a;
}
.comprarMBtn:hover {
	background:linear-gradient(to bottom, #997140 5%, #e86f12 100%);
	background-color:#997140;
}
.comprarMBtn:active {
	position:relative;
	top:1px;
}

.checkoutBtn:hover {
	background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
	background-color:#fbfcfc;
}
.checkoutBtn:active {
	position:relative;
	top:1px;
}

.swal2-popup {
    height: unset;
}

</style>

<script>

import Swal from 'sweetalert2';

export default {
    name: 'Carrinho',
    components: {
        Swal
    },
    data() {
        return {
            produtosNoCarrinho: [],
            valorTotal: 0,
            checkoutComp: false
        }
    },
    methods: {
        comprarMais() {
            this.$router.push('/');
        },
        produtosCarrinho() {
            this.$http.get('/carrinho')
                .then(response => response.data)
                .then(data => {
                    this.produtosNoCarrinho = data
                    this.somarValorTotalProdutos()
                    this.$store.dispatch('produtosNoCarrinho',data)
                })
        },
        formatarValor(valor) {
            return valor.toLocaleString('pt-br', {minimumFractionDigits: 2})
        },
        somarValorTotalProdutos() {
            let total = 0;
            this.produtosNoCarrinho.forEach((produto) => {
                total += produto.preco;
            });
            this.valorTotal = this.formatarValor(total);
        },
        fecharPedido() {
            this.$emit('checkout', this.produtosNoCarrinho);
            this.$router.push('/checkout');
        },
        alterarQuantidade(produto) {
            if ( produto.quantidade > 0 ) 
            {
                produto.precoTotalFormatado = this.formatarValor(produto.preco * produto.quantidade)
                this.$http.patch('/carrinho/'+produto.id, JSON.stringify(produto))
                    .then(response => {
                        console.log(response.data)
                    }).catch((error) => {
                        console.error(error)
                    })
            }
        },
        remover(produto)
        {
            Swal.fire({
                title: 'Deseja Remover o Produto: ?',
                showCancelButton: true,
                confirmButtonText: 'Remover',
                cancelButtonText: `Manter`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$http.delete('/carrinho/'+produto.id, produto.id)
                    .then(response => {
                        if ( response.status == 200 ) 
                        {
                            this.produtosNoCarrinho.splice(produto.id,1);
                            Swal.fire('Removido com Sucesso!', '', 'success')
                            
                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        }
                    })
                } else if (result.isDenied) {
                }
            })
        }
    },
    created() {
        this.produtosCarrinho();
    },
    computed: {
        checkoutComponent: function()
        {
            this.checkoutComp = true
        },
        desativado: function() {
            return !!this.produtosNoCarrinho.length > 0;
        }
    }
}

</script>