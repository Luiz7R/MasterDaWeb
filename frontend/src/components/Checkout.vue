<template>

    <div class="container">
        <div v-if="!compraFinalizada && produtosNoCarrinho.length > 0 ">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="background-color:rgb(71, 153, 124);">
                        <div class="card-header">
                            <h2>Metodo de Pagamento</h2>
                        </div>
                        <div class="card-body">
                            <p>
                                <label for="" style="margin-right: 85px;">
                                    <img src = "../assets/visa_icon.svg" class="visa"/>
                                    <strong>Visa</strong>
                                </label>
                                <input checked id="visa" v-model="metodoPagamentoEscolhido" type="radio" value="Visa"/>
                            </p>
                            <p>
                                <label for="" style="padding-right: 30px;">
                                    <img src = "../assets/mastercard.svg" class="mastercard"/>
                                    <strong>Mastercard</strong>
                                </label>
                                <input checked id="pix" v-model="metodoPagamentoEscolhido" type="radio" value="Mastercard" />
                            </p>
                            <p>
                                <img src = "../assets/pix.svg" class="pix"/>
                                <label for="">
                                    <strong style="margin-bottom: 20px; margin-right: 6rem;">Pix</strong>
                                </label>
                                <input checked id="pix" v-model="metodoPagamentoEscolhido" type="radio" value="Pix" />
                            </p>
                        </div>
                        <div class="card-header">
                            <h2>Resumo do pedido</h2>
                        </div>
                        <div class="card-body">
                            <p><strong>Total de itens:</strong> {{ produtosNoCarrinho.length }}</p>
                            <p><strong>Taxa de Entrega:</strong> {{ taxaEntrega }}</p>
                            <p><strong>Valor Produtos:</strong> {{ valorTotal }}</p>
                            <hr>
                            <p><strong>Total a pagar:</strong> {{ valorTotal+taxaEntrega }}</p>
                            <button @click="finalizarCompra(produtosNoCarrinho)" class="btn btn-lg botao-checkout" style="background-color: blanchedalmond;">
                                Finalizar Compra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <div class="position-absolute bottom-left" style="margin-top: 1.5rem;">
                    <button type="button" class="btn botao-voltar">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .produtos {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
    }

    .visa {
        max-width: 40px;
        margin-right: 10px;
        margin-left: 2.5rem;
    }

    .mastercard {
        max-width: 40px;
        margin-right: 10px;
        margin-left: 2.5rem;
    }

    .pix {
        max-width: 30px;
        margin-right: 1rem;
        margin-left: 2.5rem;
    }

    .produto-card {
    background-color: #f5f5f5;
    border-radius: 5px;
    padding: 1rem;
    }

    .botao-voltar {
        background-color: rgb(126, 168, 152) !important;
    }

    .botao-voltar:hover {
        background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
        background-color:#fbfcfc;
    }
    .botao-checkout:hover {
        background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
        background-color:#fbfcfc;
    }

    .botao-checkout {
        padding: 1rem 2rem;
        font-size: 1.2rem;
        background-color: #94c2f3 !important;
        color: white;
        font-size: 15px;
        border: none;
        border-radius: 5px;
    }

    :root {
        --color-background: #fae3ea;
        --color-primary: #fc8080;
        --font-family-base: Poppin, sans-serif;
        --font-size-h1: 1.25rem;
        --font-size-h2: 1rem;
    }

    fieldset {
        border: 0;
        margin: 0;
        padding: 0;
    }

    input[type="radio"] {
        accent-color: var(--color-primary);
    }

    .form__radios {
        display: grid;
        gap: 1em;
    }

    .form__radio {
        align-items: center;
        background-color: #fefdfe;
        border-radius: 1em;
        box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
        display: flex;
        padding: 1em;
    }

    .form__radio label {
        align-items: center;
        display: flex;
        flex: 1;
        gap: 1em;
    }
</style>

<script>
    import { mapGetters } from 'vuex';
    import Swal from 'sweetalert2';

    export default {
        name: 'Checkout',
        data () {
            return {
                taxaEntrega: 17.87,
                compraFinalizada: false,
                metodoPagamentoEscolhido: 'Pix',
                produtosCarrinho: []
            }
        },
        computed: {
          ...mapGetters(['produtosNoCarrinho']),
            valorTotal() {
                let total = 0;
                this.produtosCarrinho = this.produtosNoCarrinho;
                this.produtosNoCarrinho.forEach((produto) => {
                    total += produto.preco;
                });
                return total;
            }
        },
        methods: {
            async finalizarCompra()
            {
                this.produtosCarrinho.metodoPagamento = this.metodoPagamentoEscolhido

                try {
                    await this.$http.post('/checkout', this.produtosNoCarrinho)
                          .then(response => response.data)
                          .then(data => {

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Compra Realizada com Sucesso!'
                            })

                            setTimeout(() => {
                                this.$router.push('/');    
                            }, 4000);
                          });
                } catch (error) {
                    console.error(error);
                }
            }
        }
    }
</script>