<template>
    <div>
        <NavbarComponent />

        <main class="content py-4">
      
      <div class="container-history">
        <div class="row">
            <h3 class="my-4">Pengembalian</h3>
           
        </div>
          <table class="table table-striped">
              <thead>
              <tr>
                  <th>no</th>
                  <th>Nama Barang</th>
                  <th>Nama Peminjam</th>
                  <th>tanggal peminjaman</th>
                  <th>durasi peminjaman</th>
                  <th></th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(item, index) in data_loans" :key="item.id" >
                  <td>{{ index + 1 }}</td>
                  <td>
                    <div  class="d-flex">
                        <div v-for="(goodsLoan, index) in item.goods_loans" :key="goodsLoan">
                            {{ goodsLoan.goods_name }} ({{ goodsLoan.quantity }}){{ index > 0 ? '.' : ', '  }}
                        </div>
                    </div>
                  </td>
                  <td>{{ item.borrower }}</td>
                  <td>{{ item.loan_date }}</td>
                  <td>{{ item.loan_duration }}</td>
                  <td>
                    <div class="d-flex">
                      <button class="btn btn-info text-white me-3" @click="returnGoods(item.id)">selesai</button>
                    </div>
                  </td>
              </tr>
              
              </tbody>
          </table>


          </div>

          </main>
    </div>
</template>

<script>
import NavbarComponent from '@/components/NavbarComponent.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

    export default {
    name: "ReturnView",
    data() {
        return {
            data_loans: null
        }
    },
    components: { NavbarComponent },
    methods: {
        returnGoods(id){
            axios.get(`http://127.0.0.1:8000/api/return-goods/${id}?token=${localStorage.getItem('token')}`).then(
                response => {
                    console.log(response)
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: response.data.message,
                        timer: 2000,
                        showConfirmButton: false
                    })

                    location.reload()
                }
            ).catch(
                error => {
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: error.response.data.message,
                        timer: 2000,
                        showConfirmButton: false
                    })
                }
            )
        },
        loans(token){
            axios.get(`http://127.0.0.1:8000/api/data-loans?token=${token}`).then(
                response => {
                    console.log(response)
                    this.data_loans = response.data.loans
                }
            ).catch(
                error => {
                    console.log(error)
                }
            )
        }
    },
    mounted() {
        const token = localStorage.getItem('token')

        if(token == null){
            this.$router.push('/')
        } else {
            this.loans(token)
        }
    },
}
</script>