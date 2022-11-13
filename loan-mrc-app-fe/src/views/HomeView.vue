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
        <div class="row">
            <div class="col-4 mb-3">   
              <div class="card">
                <div class="card-body p-4">
                  <h4>Laptop</h4>
                  <div class="text-center">
                      <div class="row">
                          <div class="col text-muted">Jumlah Barang</div>
                          <div class="col">82</div>
                      </div> 
                      <div class="row">
                          <div class="col text-muted">Tersedia</div>
                          <div class="col">87</div>
                      </div>
                      <div class="row">
                          <div class="col text-muted">Dipinjam</div>
                          <div class="col">38</div>
                      </div>
                      <div class="row mt-3">
                        <button class="btn btn-info text-white">pinjam</button>
                      </div>
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
        <form class="row g-3">
  <div class="col-md-8">
    <label for="barang" class="form-label">Nama Barang</label>
    <input type="email" class="form-control" id="barang">
  </div>
  <div class="col-md-4">
    <label for="stock" class="form-label">stock</label>
    <input type="number" class="form-control" id="stock">
  </div>
  <div class="col-12">
    <label for="category" class="form-label">category</label>
    <select name="" class="form-control" id="category">
      <option>pilih</option>
      <option value="1">notebook dan netbook</option>
      <option value="2">tools dan barang lainnya</option>
      <option value="3">lcd projector</option>
      <option value="4">Tablet</option>
    </select>
  </div>
 
   
</form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         <button type="button" class="btn btn-primary">Oke</button>
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

export default {
  name: 'HomeView',
  components: {
    NavbarComponent
  },
  data() {
    return {

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
