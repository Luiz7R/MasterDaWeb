<template>
    <div>
      <canvas id="lucroProdutosGrafico"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js/auto'

export default {
    name: 'LucroProdutosGrafico',
    data() {
        return {
            nomeProdutos: {},
            LucroProdutos: []
        }
    },
    methods: {
        buscarLucroProdutos()
        {
            this.$http.get('/admin/lucroProdutos')
            .then(response => {
                const produtos = response.data

                this.nomeProdutos = produtos.map((produto) => {
                    return produto.nome_produto
                })

                this.lucroProdutos = produtos.map((produto) => {
                    return produto.lucro
                })   
                
                const chartData = {
                    labels: this.nomeProdutos,
                    datasets: [{
                        label: 'Lucro Produtos',
                        data: this.lucroProdutos
                    }]
                }

                const config = {
                    type: 'doughnut',
                    data: chartData
                }

                const myChart = new Chart(
                    document.getElementById('lucroProdutosGrafico'),
                    config
                )
            })  
        }
    },
    mounted() {
        this.buscarLucroProdutos()
    }
}

</script>