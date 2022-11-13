<template>
    <div>
        <main class="content py-4">
            <div class="container">
                <h3 class="my-5 text-center">Loan Gudang</h3>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3 text-center">Login</h5>
                                    <form @submit.prevent="login()">
                                        <div class="form-group mb-4">
                                            <label for="username" class="mb-2">Username</label>
                                            <input type="text" v-model="username" class="form-control" autofocus>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="username" class="mb-2">Password</label>
                                            <input type="password" v-model="password" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </main>
    </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
    export default {
        name: 'LoginView',
        data() {
            return {
                username: null,
                password: null
            }
        },
        methods: {
            login(){
                axios.post(`http://127.0.0.1:8000/api/login`, {
                    username: this.username,
                    password: this.password
                }).then(
                    response => {
                        localStorage.setItem('username', response.data.user.username)
                        localStorage.setItem('token', response.data.user.token)
                        this.$router.push('/beranda')
                        Swal.fire({
                            title: 'Success',
                            text: response.data.message,
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,

                        })
                    }
                ).catch(
                    error => {
                        Swal.fire({
                            title: 'Error!',
                            text: error.response.data.message,
                            icon: 'error',
                            confirmButtonText: 'Oke'
                        })
                    }
                )
            }
        },
        mounted() {
            const token = localStorage.getItem('token')

            if(token != null){
                this.$router.push('/beranda')
            }
        },
    }
</script>