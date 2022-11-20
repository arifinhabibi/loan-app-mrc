<template>
    <div>
        <NavbarComponent />

        <main class="content py-4">
    <div class="container-history">
        <h4 class="my-4">Riwayat Peminjaman Bulan </h4>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Barang Pinjaman</th>
                <th>Nama Peminjam</th>
                <th>Keperluan</th>
                <th>Tanggal Pinjaman</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <ul>
                        <li style="list-style: none;">laptop<i class="bi bi-patch-check-fill" style="color: green;margin-left: 2px;"></i></li>
                        <li style="list-style: none;">tablet advan<i class="bi bi-x-circle-fill" style="color: red;margin-left: 2px;"></i></li>
                        <li style="list-style: none;">proctor</li>
                        <li style="list-style: none;">terminal</li>
                    </ul>
                </td>
                <td>24 May 2022</td>
                <td>10:00</td>
                <td>D05 dan D06.</td>
            </tr>
            
            </tbody>
        </table>
    </div>
</main>

    </div>
</template>

<script>
import NavbarComponent from '@/components/NavbarComponent.vue';

    export default {
    name: "HistoryView",
    components: { NavbarComponent },
    data(){
        return {

        }
    },
    mounted(){
        const token = localStorage.getItem('token')

        if (token == null) {
            this.$router.push('/')
        }
    }
}
</script>