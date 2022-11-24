<template>
    <div>
        <nav class="navbar navbar-expand-lg" style="background-color: rgb(77, 131, 207);">
            <div class="container">
                <router-link class="navbar-brand text-white" @click="refresh()" to="/peminjaman">Loan App</router-link>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <router-link class="nav-link text-white" @click="refresh()" to="/peminjaman">Peminjaman</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link text-white" to="/pengembalian">Pengembalian</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link text-white" to="/list-barang">List Barang</router-link>
                    </li> 
                    <li class="nav-item">
                        <router-link class="nav-link text-white" to="/riwayat-peminjaman">Riwayat Peminjaman</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ username }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-dark" href="">Ubah Password</a>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" @click="logout()">Keluar</button>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

    </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
    export default {
        name: 'NavbarComponent',
        data() {
            return {
                username: localStorage.getItem('username')
            }
        },
        methods: {
            logout(){
                const token = localStorage.getItem('token')
                axios.post(`http://127.0.0.1:8000/api/logout?token=${token}`).then(
                    response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message,
                            timer: 1000,
                            showConfirmButton: false

                        })
                        localStorage.removeItem('token')
                        localStorage.removeItem('username')
                        this.$router.push('/')
                    }
                ).catch(
                    error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: error.response.data.message
                        })
                    }
                )
            },
            refresh(){
                setTimeout(() => {
                    location.reload()
                }, 100)
            }
        },
    }
</script>