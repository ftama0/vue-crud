<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <style>
        .modul-alert {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 30vw;
            height: 40px;
            z-index: 10;
            background-color: #B6E2A1;
            border-radius: 10px;
            font-weight: bold;
            padding: 10px;
            color: black;
        }

        .modul-alert.update {
            background-color: #5F9DF7;
        }

        .modul-alert.delete {
            background-color: #FF8787;
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Trigger buttons -->
        <!-- <button @click="getAlert" type="button" id="primary" class="btn btn-primary m-1">Primary</button> -->

        <!-- Alerts -->
        <!-- <div class="animate__animated animate__bounceInDown modul-alert" id="modal-alert" v-if="alert1">
            A simple primary alert with
        </div> -->

        <main>
            <!-- Table List Product -->
            <!-- Start Nav List Product -->
            <nav class="navbar navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand">Vue.Js CRUD</a>
                    <div v-if="alert" class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <button @click="modal = true;
                                    form='insert';
                                    vdata={}" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Add Data
                    </button>

                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" v-model="search">
                    </form>
                </div>
            </nav>
            <!-- End Nav List Product -->

            <!-- Start Table List Product -->
            <div class="table-responsive">
                <table class="table table-bordered datatable text-center">
                    <thead>
                        <tr style="background-color: #CFF5E7">
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filterData" :key="product.product_id">
                            <td>{{ product.product_name }}</td>
                            <td>{{ product.product_price }}</td>
                            <td>
                                <a style="margin-left: 3px; margin-top: 5px;" @click="getItem(product,'update')" class="btn btn-sm btn-primary rounded-circle text-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="my-1 py-1 ri-file-edit-fill text-sm" style="font-size : 12px;"></i></a>
                                <a style="margin-left: 3px; margin-top: 5px;" @click="getItem(product,'delete')" class="btn btn-sm btn-danger rounded-circle text-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="my-1 py-1 ri-delete-bin-2-fill text-sm" style="font-size : 12px;"></i></a>
                                <a style="margin-left: 3px; margin-top: 5px;" @click="getItem(product,'view')" class="btn btn-sm btn-warning rounded-circle text-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="my-1 py-1 ri-search-line text-sm" style="font-size : 12px;"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <div class="text-center">
                <div v-model="page" :length="this.filterData.length" circle></div>
            </div> -->

            <!-- End Table List Product -->
            <!-- --------------------------------------------------------------------------------------------------------------------------------------- -->
            <!-- Modal Save Product -->
            <div v-if="modal">
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" v-if="form=='insert' || form=='update' || form=='view' || form=='delete'">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel" v-if="form=='insert'">Add New Product</h5>
                                <h5 class="modal-title" id="staticBackdropLabel" v-else-if="form=='update'">Update Product</h5>
                                <h5 class="modal-title" id="staticBackdropLabel" v-else-if="form=='view'">View Product</h5>
                                <h5 class="modal-title" id="staticBackdropLabel" v-else-if="form=='delete'">Delete Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-header">
                                    <form action="">
                                        <div class="row">
                                            <h4 v-if="form=='delete'">Are sure want to delete <strong class="text-danger">"{{ vdata.product_name }}"</strong> ?</h4>
                                            <div class="col">
                                                <label v-if="form=='insert' || form=='update' || form=='view'" class="form-label">Product Name</label>
                                                <input type="text" v-if="form=='insert' || form=='update'" label="Product Name*" v-model="vdata.product_name" required>
                                                <input type="text" v-else-if="form=='view'" label="Product Name*" v-model="vdata.product_name" disabled>
                                                </input>
                                            </div>
                                            <div class="col">
                                                <label v-if="form=='insert' || form=='update' || form=='view'" class="form-label">Product Price</label>
                                                <input type="number" v-if="form=='insert' || form=='update'" label="Price*" v-model="vdata.product_price" required>
                                                <input type="number" v-else-if="form=='view'" label="Price*" v-model="vdata.product_price" disabled>
                                                </input>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" @click="saveProduct" v-if="form=='insert'">Save</button>
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="updateProduct" v-else-if="form=='update'">Update</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="deleteProduct" v-else-if="form=='delete'">Delete</button>
                                    <!--    <button @click="getAlert" type="button" id="primary" class="btn btn-primary m-1">Primary</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="animate__animated animate__bounceInDown modul-alert" id="modal-alert" v-if="alert1">
                <h6> <i class="ri-checkbox-circle-fill"></i> Add data has been succces</h6>
            </div>
            <div class="animate__animated animate__bounceInDown modul-alert update" id="modal-alert" v-else-if="alert2">
                <h6><i class="ri-checkbox-circle-fill"></i> Update data has been succces</h6>
            </div>
            <div class="animate__animated animate__bounceInDown modul-alert delete" id="modal-alert" v-if="alert3">
                <h6> <i class="ri-fire-fill"></i> Delete data has been succces</h6>
            </div>
            <!-- End Modal Save Product -->
            <!-- Button trigger modal -->

            <!-- Modal -->

        </main>
    </div>

    <!-- <script src="https://vuejs.org/js/vue.min.js"></script> -->
    <!-- <script type="module">
        import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.esm.browser.js'
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/js/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.lite.min.css"></script> -->

    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script> -->

    <script type="module">
        new Vue({
            el: '#app',
            // vuetify: new Vuetify(),
            data() {
                return {
                    products: [],
                    modal: true, //variable di button add data dan modal save
                    form: 'insert',
                    search: '',
                    // page: 1,
                    vdata: {},
                    alert: false,
                    alert1: false,
                    alert2: false,
                    alert3: false
                }
            },
            mounted: function() {},
            created: function() {
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                this.getProducts();
            },
            computed: {
                filterData() {
                    let data = this.products
                    data = data.filter(e => e.product_name.indexOf(this.search) != -1);
                    return data;
                }
            },
            methods: {
                getAlert() {
                    this.alert1 = !this.alert1
                    // document.getElementById('modal-alert').classList.remove('animated__fadeOutDown');
                    setTimeout(() => {
                        // document.getElementById('modal-alert').classList.remove('animate__bounceInDown');
                        document.getElementById('modal-alert').classList.add('animate__fadeOutDown');
                        setTimeout(() => {
                            this.alert1 = false;
                        }, 500);
                    }, 2500);
                    this.$forceUpdate();
                },
                // Get Product in table
                getProducts: function() {
                    axios.get('product/getproduct')
                        .then(res => {
                            // handle success
                            this.products = res.data;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },
                // Save Product
                saveProduct: function() {
                    axios.post('product/save', this.vdata)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.productName = '';
                            this.productPrice = '';
                            this.modal = false;
                            this.alert1 = !this.alert1
                            // document.getElementById('modal-alert').classList.remove('animated__fadeOutDown');
                            setTimeout(() => {
                                // document.getElementById('modal-alert').classList.remove('animate__bounceInDown');
                                document.getElementById('modal-alert').classList.add('animate__fadeOutDown');
                                setTimeout(() => {
                                    this.alert1 = false;
                                }, 500);
                            }, 2500);
                            // this.$forceUpdate();

                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },

                // getAlert: function(alert) {
                //     this.alert = false;
                // },

                // Get Item Edit, View, delete Product
                getItem: function(product, modal) {
                    if (modal == 'update') {
                        this.form = 'update'
                        this.modal = true;
                    } else if (modal == 'view') {
                        this.form = 'view'
                        this.modal = true;
                    } else {
                        this.form = 'delete'
                        this.modal = true;
                    }
                    this.vdata = JSON.parse(JSON.stringify(product))
                },

                //Update Product
                updateProduct: function() {
                    axios.put(`product/update/${this.vdata.product_id}`, this.vdata)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.modal = false;
                            this.alert2 = !this.alert2
                            // document.getElementById('modal-alert').classList.remove('animated__fadeOutDown');
                            setTimeout(() => {
                                // document.getElementById('modal-alert').classList.remove('animate__bounceInDown');
                                document.getElementById('modal-alert').classList.add('animate__fadeOutDown');
                                setTimeout(() => {
                                    this.alert2 = false;
                                }, 500);
                            }, 2500);
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },

                //View Product
                viewProduct: function() {
                    axios.put(`product/update/${this.vdata.product_id}`, this.vdata)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.modal = false;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },

                // Delete Product
                deleteProduct: function() {
                    axios.delete(`product/delete/${this.vdata.product_id}`)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.modal = false;
                            this.alert3 = !this.alert3
                            // document.getElementById('modal-alert').classList.remove('animated__fadeOutDown');
                            setTimeout(() => {
                                // document.getElementById('modal-alert').classList.remove('animate__bounceInDown');
                                document.getElementById('modal-alert').classList.add('animate__fadeOutDown');
                                setTimeout(() => {
                                    this.alert3 = false;
                                }, 500);
                            }, 2500);
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                }

            },

        })
    </script>
</body>

</html>