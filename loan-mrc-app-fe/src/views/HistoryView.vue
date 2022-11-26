<template>
    <div>
        <NavbarComponent />

        <main class="content py-4">
    <div class="container-history">
        <h4 class="my-4">Riwayat Peminjaman Bulan {{ month }}</h4>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Barang Pinjaman</th>
                <th>Nama Peminjam</th>
                <th>Keperluan</th>
                <th>Tanggal Pinjaman</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data_loans" :key="item.id" >
                  <td>{{ index + 1 }}</td>
                  <td>
                    <div  class="d-flex">
                        <div v-for="(goodsLoan, index) in item.goods_loans" :key="goodsLoan">
                            {{ goodsLoan.goods_name }} ({{ goodsLoan.quantity }}){{ index + 1 == item.goods_loans.length ? '.' : ','  }}
                        </div>
                    </div>
                  </td>
                  <td>{{ item.borrower }}</td>
                  <td>{{ item.necessity }}</td>
                  <td>{{ item.loan_date }}</td>
                   
              </tr>
            
            </tbody>
        </table>
    </div>
</main>

    </div>
</template>

<script>
import NavbarComponent from '@/components/NavbarComponent.vue';
import axios from 'axios'

    export default {
    name: "HistoryView",
    components: { NavbarComponent },
    data(){
        return {
            month: null,
            data_loans: null
        }
    },
    methods: {
        history(token){
            axios.get(`http://127.0.0.1:8000/api/history/?token=${token}`).then(
                response => {
                    console.log(response)
                    this.month = response.data.bulan
                    this.data_loans = response.data.loans
                }
            )
        }
    },
    mounted(){
        const token = localStorage.getItem('token')

        if (token == null) {
            this.$router.push('/')
        } else {
            this.history(token)
        }
    }
}
</script>