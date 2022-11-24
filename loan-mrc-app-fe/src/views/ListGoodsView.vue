<template>
  <div>
    <NavbarComponent />

    <main class="content py-4">
      
    <div class="container-history">
      <div class="row">
        <div class="col-2">
          <h3 class="my-4">List Barang</h3>
        </div>
        <div class="col-auto">
          <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="my-4 btn btn-primary"><i class="fa-solid fa-plus"></i></button>
        </div>
      </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>no</th>
                <th>Nama Barang</th>
                <th>Barang Tersedia</th>
                <th>Barang Terpinjam</th>
                <th>hapus/ubah</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in all_goods" :key="item.id">
                <td>{{ index + 1 }}</td>
                <td>{{ item.goods_name }}</td>
                <td>{{ item.stock }}</td>
                <td>
                  
                </td>
                <td>
                  <div class="d-flex">
                    <button class="btn btn-outline-danger me-3" @click="deleteGoods(item.id)"><i class="bi bi-trash3-fill"></i></button>
                    <button class="btn btn-outline-warning me-3"><i class="bi bi-pencil-square"></i></button>
                  </div>
                </td>
            </tr>
            
            </tbody>
        </table>

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
  name: 'ListGoodsView',
  components: {
    NavbarComponent
  },
  data() {
    return {
        success_create: false,
        goods_name: null,
        stock: null,
        goods_category_id: null,
        all_goods: []
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
    },
    listGoods(token){
      axios.get(`http://127.0.0.1:8000/api/list-goods?token=${token}`).then(
        response => {
          console.log(response)
          this.all_goods = response.data.goods
        }
      ).catch(
        error => {
          console.log(error)
        }
      )
    },
    deleteGoods(id){
      axios.get(`http://127.0.0.1:8000/api/delete-goods/${id}?token=${localStorage.getItem('token')}`).then(
        response => {
          Swal.fire({
            icon: 'success',
            title: response.data.message,
            timer: 1000,
            showConfirmButton: false
          })

          setTimeout(() => {
            location.reload()
          }, 1000)
        }
      )

    }
  },
  mounted() {
    const token = localStorage.getItem('token')


    if (token == null) {
      this.$router.push('/')
    } else {
      this.listGoods(token)
    }
  },
}
</script>
