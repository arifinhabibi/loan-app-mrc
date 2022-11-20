<template>
  <div>
    <NavbarComponent />

    <main class="content py-4">
      
    <div class="container">
      <div class="row">
        <div class="col-2">
          <h3 class="my-4">List Barang</h3>
        </div>
        <div class="col-auto">
          <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="my-4 btn btn-primary"><i class="fa-solid fa-plus"></i></button>
        </div>
      </div>
<div class="row text-capitalize">
  
  <div class="col-3">
    <div class="card">
      <div class="card-body">
        <h4>laptop</h4>
        <div class="row">
          <div class="col-9">jumlah barang</div>
          <div class="col-auto">424</div>
        </div>
        <div class="row">
          <div class="col-9">barang tersedia</div>
          <div class="col-auto">24</div>
        </div>
        <div class="row">
          <div class="col-9">peminjaman</div>
          <div class="col-auto">2</div>
        </div>

        <div class="d-flex mt-3">
            <a href="#" class="btn btn-warning me-3">edit</a>
            <a href="#" class="btn btn-danger me-3">hapus</a>
        </div>

      </div>
    </div>
  </div>   
  
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form class="row g-3" @submit.prevent="createGoods()">
          <div class="col-md-8">
            <label for="barang" class="form-label">Nama Barang</label>
            <input type="text" v-model="goods_name" class="form-control" id="barang">
          </div>
          <div class="col-md-4">
            <label for="stock" class="form-label">jumlah barang</label>
            <input type="number" v-model="stock" class="form-control" id="stock">
          </div>
          <div class="col-12">
            <label for="category" class="form-label">kategori</label>
            <select v-model="goods_category_id" class="form-control" id="category">
              <option value="null">pilih</option>
              <option value="1">notebook dan netbook</option>
              <option value="2">tools dan barang lainnya</option>
              <option value="3">lcd projector</option>
              <option value="4">Tablet</option>
            </select>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Oke</button>
          </div>
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
import NavbarComponent from '@/components/NavbarComponent'
import axios from 'axios'
import Swal from 'sweetalert2'

export default {
  name: 'HomeView',
  components: {
    NavbarComponent
  },
  data() {
    return {
        'success_create': false,
        'goods_name': null,
        'stock': null,
        'goods_category_id': null
    }
  },
  methods: {
    createGoods(){
      axios.post(`http://127.0.0.1:8000/api/create-goods?token=${localStorage.getItem('token')}`, {
        goods_name: this.goods_name,
        stock: this.stock,
        goods_category_id: this.goods_category_id
      }).then(
        response => {
          Swal.fire({
            title: 'Berhasil',
            text: response.data.message,
            icon: 'success',
            timer: 1000,
            showConfirmButton: false,
          })

          setTimeout(() => {
            location.reload()
          }, 1000);
        }
      ).catch(
        errors => {
          Swal.fire({
            title: 'Gagal',
            text: [ 
            errors.response.data.errors.goods_name, 
            ' '+ errors.response.data.errors.stock,
            ' ' + errors.response.data.errors.goods_category_id
            ],
            icon: 'error',
          })
        }
      )
    }
  },
  mounted() {
    const token = localStorage.getItem('token')


    if (token == null) {
      this.$router.push('/')
    }
  },
}
</script>
