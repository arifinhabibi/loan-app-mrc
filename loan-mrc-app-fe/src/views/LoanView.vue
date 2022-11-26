<template>
    <div>
        <NavbarComponent />

        <main class="content py-4">
                <div class="sidebar" v-if="borrower != null">
                    <div class="card-body">
                        <form @submit.prevent="orderConfirm()">
                            <div class="row mb-3">
                                <div class="col-8">
                                    <h4>peminjaman</h4>
                                </div>
                                <div class="col-auto">tgl: {{ date_now.toLocaleDateString() }}</div>
                            </div>
                            <div class="borrower-name mb-3">
                                <b>nama:</b> <span style="margin-left: 10px;">{{ borrower == null ? 'scan id card dahulu' : borrower }}</span>
                            </div>
                            <div class="goods-choosen mb-2">
                                <div class="row">
                                    <div class="col-2"><b>barang:</b></div>
                                        <!-- list goods choosen -->
                                        
                                    </div>
                                </div>

                                <div class="bg-warning text-center p-3" v-if="orderGoodsName.length == 0">
                                    silahkan pilih barang di sisi sebelah kanan
                                </div>
                                
                                <ul>
                                    <li style="list-style-type: circle;" v-for="(item, index) in orderGoodsName" :key="item">
                                        <div class="row mb-2">
                                            <div class="goods">{{ item }}:</div>
                                        </div>
                                        <div class="d-flex align-items-baseline mb-3">
                                            <input type="text" v-on:change="typeGoods()" :value="null" class="form-control me-2 typeGoods" placeholder="no/type/merek">
                                            <input type="number" v-on:change="quantityGoods(item, index)" :value="null" class="form-control me-2 quantity" placeholder="jumlah" required>
                                            <div class="close-button" @click="deleteOrder(item, index)"><i class="fa-solid fa-trash"></i></div>
                                        </div>
                                    </li>
                                </ul>
                                
                            
                            <div class="necessity mb-3  mt-3">
                                <label for="necessity"><b>keperluan: </b></label>
                                <textarea name="" class="form-control mt-2" v-model="necessity" id="necessity" cols="30" rows="4" placeholder="isi disini"></textarea>
                            </div>
                            <div class="loan-duration mb-3">
                                <label for="duration"><b>durasi peminjaman: </b></label>
                                <input type="date" v-model="loan_duration" id="duration" class="form-control mt-2">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">selesai</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="main-content">
                    <div class="message-not-borrower" v-if="borrower == null">
                            <label for="borrower">silahkan scan id card terlebih dahulu</label>
                            <input type="text" id="borrower" class="ui_code_input form-control" v-on:change="getAllGoods(id_card)" v-model="id_card" autofocus>
                            <!-- <a href="#" style="font-size: 18px;position:absolute; bottom: 10px;">pendaftaran id card</a> -->
                    </div>
                    <div class="row" v-if="borrower != null">
                            <h3 style="margin-bottom: 20px;">List barang</h3>
                            <div class="col-4" v-for="(item) in goods" :key="item.id">
                                <button class="box" @click="orderGoods(item.goods_name, item.id)" >
                                        <!-- bi-laptop -->
                                            <div class="goods-category-icon">
                                                <i class="bi " :class="{ 'bi-laptop': item.goods_category_id == 1, 'bi-tools': item.goods_category_id == 2, 'bi-tablet': item.goods_category_id == 4, 'bi-projector': item.goods_category_id == 3 }"></i>
                                            </div>
                                            <div class="menu">
                                                <h6>{{ item.goods_name }}</h6>
                                                <p>Tersedia ({{ item.stock }})</p>
                                            </div>
                                    </button>
                            </div> 
                          
                        </div>
                    </div>
            </main>
        </div>
</template>

<script>
    import NavbarComponent from '@/components/NavbarComponent.vue'
    import axios from 'axios'
import Swal from 'sweetalert2'

    export default {
        name: 'LoanView',
        data() {
            return {
                date_now: new Date(),
                id_card: null,
                borrower: null,
                goods: [],
                goods_id: [],
                orderType: [],
                type: [],
                quantity: [],
                goods_choosen: [],
                orderGoodsName: [],
                loan_duration: null,
                necessity: null,
                goods_loans: []
            }
        },
        methods: {
            getAllGoods(id_card){
                axios.get(`http://127.0.0.1:8000/api/loan?token=${localStorage.getItem('token')}&id_card=${id_card}`).then(
                    response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Ditemukan',
                            text: response.data.borrower.name,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        this.borrower = response.data.borrower.name
                        this.goods = response.data.goods
                    }
                ).catch(
                    error => {
                        Swal.fire({
                            icon: 'info',
                            title: 'peringatan',
                            text: error.response.data.message,
                            showConfirmButton: false
                        })
                        setTimeout(() => {
                            location.reload()
                        }, 5000)
                    }
                )
            },
            orderGoods(goods_name, id){
                this.orderGoodsName.push(goods_name)

                this.goods_id.push(id)
                this.quantity.push(0)

                this.type = []
                setTimeout(() => {
                    let typeGoods = document.querySelectorAll('.typeGoods')
                    this.orderType.push(typeGoods.length - 1)  
                    this.orderType.forEach((item, indexOrder) => {
                        this.type.push(typeGoods[indexOrder].value)
                    })

                }, 1);

            },
            deleteOrder(item, indexOrder){
                this.goods_id.splice(indexOrder, 1)
                this.type.splice(indexOrder, 1)
                this.orderGoodsName.splice(indexOrder, 1)
                
                let index = 0
                this.goods.forEach((itemGoods) => {
                    if (itemGoods.goods_name == item) {
                        this.goods[index].stock = parseInt(this.goods[index].stock)  +  parseInt(this.quantity[indexOrder])
                    }
                    index++
                })
                this.quantity.splice(indexOrder, 1)
                this.orderType.pop()
            },
            typeGoods(){
                let typeGoods = document.querySelectorAll('.typeGoods')
                this.type = []
                this.orderType.forEach((item, indexOrder) => {
                    this.type.push(typeGoods[indexOrder].value)
                })
                
            },
            quantityGoods(item, index){
                
                this.goods.forEach((goods, index2) => {
                    if (goods.goods_name == item) {
                        this.goods[index2].stock = parseInt(this.goods[index2].stock) + parseInt(this.quantity[index])
                    }
                })
                    
                let quantity = document.querySelectorAll('.quantity')

                this.quantity.splice(index, 1)
                this.quantity.splice(index, 0, parseInt(quantity[index].value))
                

                this.goods.forEach((goods, index2) => {
                    if (goods.goods_name == item) {
                        this.goods[index2].stock = this.goods[index2].stock - parseInt(quantity[index].value)
                    }
                })
            },
            orderConfirm(){
                if (this.borrower != null) {
                    for(let num = 0; num < this.orderGoodsName.length; num++){
                        let array = []

                        array.push(this.goods_id[num])
                        array.push(this.orderGoodsName[num])
                        array.push(this.type[num])
                        array.push(this.quantity[num])

                        this.goods_loans.push(array)
                    }


                    axios.post(`http://127.0.0.1:8000/api/loan?token=${localStorage.getItem('token')}`, {
                        'borrower': this.borrower,
                        'necessity': this.necessity,
                        'loan_duration': this.loan_duration,
                        'goods_loans': this.goods_loans
                    }).then(
                        response => {
                            console.log(response)

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message,
                                timer: 2000,
                                showConfirmButton: false
                            })

                            setTimeout(() => {
                                location.reload()
                            }, 2000)
                        }
                    ).catch(
                        error => {
                            console.log(error)

                            Swal.fire({
                                icon: 'error',
                                title: 'gagal',
                                text: [ 
                                    error.response.data.errors.necessity, 
                                    ' '+ error.response.data.errors.loan_duration
                                    ],
                                timer: 2000,
                                showConfirmButton: false
                            })
                        }
                    )
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'peringatan',
                        text: 'silahkan scan id card terlebih dahulu',
                        timer: 3000,
                        showConfirmButton: false
                    })
                    setTimeout(() => {
                        location.reload()
                    }, 3000)
                }
                
                
            }
        },
        components: {
            NavbarComponent
        },
        mounted() {
            const token = localStorage.getItem('token')


            if (token == null) {
                this.$router.push('/')
            }
        },
    }
</script>