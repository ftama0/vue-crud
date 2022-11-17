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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
    <div id="app">
        <main>

            <!-- Table List Product -->
            <!-- Button Add New Product -->
            <!-- <btn color="primary" dark @click="modal = true;form='insert';vdata={}">Add New</btn> -->

            <!-- Start Nav List Product -->
            <nav class="navbar navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand">Vue.Js CRUD</a>
                    <!-- <button class="btn btn-success" @click="modal = true;form='insert';vdata={}" type="submit"><i class="bi bi-plus me-1" data-bs-toggle="modal" data-bs-target="#verticalycentered"></i>Add Data</button> -->
                    <button @click="modal = true;
                                    form='insert';
                                    vdata={}"
                                    type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
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
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" v-if="form=='insert' || form=='update' || form=='view'">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel" v-if="form=='insert'">Add New Product</h5>
                                <h5 class="modal-title" id="staticBackdropLabel" v-if="form=='update'">Update New Product</h5>
                                <h5 class="modal-title" id="staticBackdropLabel" v-else>View New Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label">Product Name</label>
                                        <input v-if="form=='insert' || form=='update'" label="Product Name*" v-model="vdata.product_name" required>
                                        <input v-if="form=='view'" label="Product Name*" v-model="vdata.product_name" disabled>
                                        </input>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Product Price</label>
                                        <input v-if="form=='insert' || form=='update'" label="Price*" v-model="vdata.product_price" required>
                                        <input v-if="form=='view'" label="Price*" v-model="vdata.product_price" disabled>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal" @click="saveProduct" v-if="form=='insert'">Save</button>
                                <button type="button" class="btn btn-primary" @click="updateProduct" v-if="form=='update'">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" v-else>
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Delete Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <h3>Are sure want to delete <strong>"{{ vdata.product_name }}"</strong> ?</h3>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" @click="deleteProduct">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                }
            },
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
                // Get Product
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
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },

                // Get Item Edit Product
                getItem: function(product, modal) {
                    if (modal == 'update') {
                        this.form = 'update'
                        this.modal = true;
                    } 
                    else if(modal == 'view'){
                        this.form = 'view'
                        this.modal = true;
                    }
                    else {
                        this.form = 'delete'
                        this.modal = true;
                    }
                    this.vdata = product
                },

                //Update Product
                updateProduct: function() {
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

                // Get Item Delete Product

                // Delete Product
                deleteProduct: function() {
                    axios.delete(`product/delete/${this.vdata.product_id}`)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.modal = false;
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