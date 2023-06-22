<template>
  <div class="container">
    <div class="col-lg-5">
        <div class="row">
            <div class="col-lg-10 offset-md-10">
                <div class="card border-info mb-3 card-color">
                    <div class="card-header text-white">Login</div>
                    <div class="card-body text-white">
                        <form method="post" action="" @submit.prevent="login">
                            <div class="form-group mt-2 mb-4">
                                <label class="mb-1" for="email">Email:</label>
                                <input type="email" class="form-control" v-model="email" placeholder="Digite seu email">
                            </div>
                            <div class="form-group mb-4">
                                <label class="mb-1" for="password">Senha:</label>
                                <input type="password" class="form-control" v-model="password" placeholder="Digite sua senha">
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Login</button>
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
                email: '',
                password: ''
            }
        },
        methods: {
            login(e)
            {
                const credentials = JSON.stringify({
                    'email': this.email,
                    'password': this.password
                })

                this.$http.post('/login', credentials)
                    .then(response => response.data)
                    .then(data => {
                        document.cookie = 'token=' + data.access_token + ';SameSite=Lax'
                        localStorage.setItem('token', data.access_token)
                        this.$store.dispatch('isLoggedIn', true)
                        this.$nextTick(() => {
                            window.location.href = '/';
                        });
                    }).catch((error) => {
                        console.error(error)

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });

                        Toast.fire({
                            icon: 'warning',
                            title: 'Email ou Senha, incorretos'
                        })
                    })
            }
        }
    }
</script>
