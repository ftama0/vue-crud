<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                    <!-- Table List Product -->
                    <template>
                        <!-- Button Add New Product -->
                        <template>
                            <v-btn color="primary" dark @click="modal = true;form='insert';vdata={}">Add New</v-btn>
                        </template>
                        <input type="text" v-model="search">
                        <v-simple-table>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">Product Name</th>
                                        <th class="text-left">Price</th>
                                        <th class="text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in filterData" :key="product.product_id">
                                        <td>{{ product.product_name }}</td>
                                        <td>{{ product.product_price }}</td>
                                        <td>
                                            <template>
                                                <v-icon small class="mr-2" @click="getItem(product,'update')">
                                                    mdi-pencil
                                                </v-icon>
                                                <v-icon small @click="getItem(product,'delete')">
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <template>
                            <div class="text-center">
                                <v-pagination v-model="page" :length="this.filterData.length" circle></v-pagination>
                            </div>
                        </template>

                    </template>
                    <!-- End Table List Product -->

                    <!-- Modal Save Product -->
                    <template>
                        <v-dialog v-model="modal" persistent max-width="600px">
                            <v-card v-if="form=='insert' || form=='update'">
                                <v-card-title>
                                    <span class="headline" v-if="form=='insert'">Add New Product</span>
                                    <span class="headline" v-else>Update New Product</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field label="Product Name*" v-model="vdata.product_name" required>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field label="Price*" v-model="vdata.product_price" required>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <small>*indicates required field</small>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="modal = false">Close</v-btn>
                                    <v-btn color="blue darken-1" text @click="saveProduct" v-if="form=='insert'">Save</v-btn>
                                    <v-btn color="blue darken-1" text @click="updateProduct" v-else>Update</v-btn>
                                </v-card-actions>
                            </v-card>
                            <v-card v-else>
                                <v-card-title>
                                    <span class="headline"></span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <h3>Are sure want to delete <strong>"{{ vdata.product_name }}"</strong> ?</h3>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="modal = false">No</v-btn>
                                    <v-btn color="info darken-1" text @click="deleteProduct">Yes
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </template>
                    <!-- End Modal Save Product -->

                </v-container>
            </v-main>
        </v-app>
    </div>

    <!-- <script src="https://vuejs.org/js/vue.min.js"></script> -->
    <script type="module">
        import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.esm.browser.js'
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),

            data: {
                products: [],
                modal: false, //variable di button add data dan modal save
                form: 'insert',
                search: '',
                page: 1,
                vdata: {},
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
                    } else {
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