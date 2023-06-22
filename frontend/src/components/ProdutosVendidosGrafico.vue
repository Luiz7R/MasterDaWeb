<template>
  <div>
    <canvas id="myChart"></canvas>
  </div>
</template>

<script>

import Chart from 'chart.js/auto'

export default {
  name: 'ProdutosVendidosGrafico',
  data() {
    return {
      nomeProdutos: {},
      quantidadeVendida: []
    }
  },
  methods: {
      buscarProdutosMaisVendidos()
      {
          this.$http.get('/admin/produtosMaisVendidos')
          .then(response => {
              const produtosMaisVendidos = response.data

              this.nomeProdutos = produtosMaisVendidos.map((produto) => {
                return produto.nome_produto
              })

              this.quantidadeVendida = produtosMaisVendidos.map((produto) => {
                return produto.quantidade_vendida
              })   
              
              const chartData = {
                  labels: this.nomeProdutos,
                  datasets: [{
                    label: 'Quantidades Vendidas',
                    data: this.quantidadeVendida
                  }]
              }

              const config = {
                type: 'doughnut',
                data: chartData
              }

              const myChart = new Chart(
                document.getElementById('myChart'),
                config
              )
          })  
      }
  },
  mounted() {
    this.buscarProdutosMaisVendidos()
  }
}
</script>