<template>
  <div class="container">
    <div class="col-lg-5">
        <div class="row">
            <div class="col-lg-10 offset-md-10">
                <div class="card border-info mb-3 card-color">
                    <div class="card-header text-white">Registrar</div>
                    <div class="card-body text-white">
                        <form method="post" action="" @submit.prevent="registrar">
                            <div class="form-group mt-2 mb-4">
                                <label class="mb-1" for="nome">Nome:</label>
                                <input type="text" class="form-control" v-model="nome" placeholder="Digite seu nome">
                            </div>
                            <div class="form-group mt-2 mb-4">
                                <label class="mb-1" for="email">Email:</label>
                                <input type="email" class="form-control" v-model="email" placeholder="Digite seu email">
                            </div>
                            <div class="form-group mb-4">
                                <label class="mb-1" for="password">Senha:</label>
                                <input type="password" class="form-control" v-model="password" placeholder="Digite sua senha">
                            </div>
                            <div class="form-group mb-4">
                                <label class="mb-1" for="password">Confirme a Senha:</label>
                                <input type="password" class="form-control" v-model="password_confirmation" placeholder="Digite sua senha">
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>

  </div>
</template>

<style>

.card-color {
    background-color: #2a2b5c !important;
    background: radial-gradient(circle, rgb(15, 22, 61) 0%, rgb(9, 66, 42) 100%);
}

</style>

<script>
    import Swal from 'sweetalert2';

    export default 
    {
        data() {
            return {
                nome: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        },
        methods: {
            registrar(e)
            {
                const credentials = JSON.stringify({
                    'name': this.nome,
                    'email': this.email,
                    'password': this.password,
                    'password_confirmation': this.password
                })

                this.$http.post('/registrar', credentials)
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
                            title: 'Cadastrado com Sucesso ! Faça o Login'
                        })

                        this.$nextTick(() => {
                            setTimeout(() => {
                                window.location.href = '/#/login';
                            }, 3000);
                        });
                    }).catch((error) => {
                        console.error(error.response.data.message)

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });

                        Toast.fire({
                            icon: 'warning',
                            title: 'Erro ao se cadastrar !' + error.response.data.message
                        })
                    })
            }
        }
    }
</script>
