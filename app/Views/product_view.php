<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet"> -->
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
            width: 20vw;
            /* height: 10%; */
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

        .button {
            margin-left: 3px;
            margin-top: 5px;
            color: #F9F9F9;
            font-size: 12px;
        }

        .button:hover {
            animation: pulse;
            animation-duration: 2s;
        }
    </style>
</head>

<body>

    <div id="app">
        <main>
            <!-- Table List Product -->
            <!-- Start Nav List Product -->
            <nav class="navbar navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" style="margin-bottom: 10px;"><i class="ri-vuejs-line">ue.Js CRUD </i></a>
                    <!-- modal='true';  di dalam @click button di bawah untuk model tanpa boostrap -->
                    <button @click="form='insert';
                                    vdata={}" type="button" style="margin-bottom: 10px;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Add Data
                    </button>
                    <li class="breadcrumb-item"><a href="<?= site_url("/testing") ?>">testing</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url("/testing2") ?>">testing2</a></li>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search Product Name" aria-label="Search" v-model="search">
                    </form>
                </div>
            </nav>
            <!-- End Nav List Product -->

            <!-- Start Table List Product -->
            <div class="table-responsive">
                <table class="table table-bordered datatable text-center">
                    </th>
                    <thead>
                        <tr style="background-color: #CFF5E7">
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Expired</th>
                            <th scope="col">Download</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filterData" :key="product.product_id">
                            <td>{{ product.product_name }}</td>
                            <td>Rp. {{ product.product_price }}</td>
                            <td>{{ product.stock }}</td>
                            <td>{{ product.expired }}</td>
                            <td> <a @click="download(getItem(product))" class="btn btn-sm btn-success rounded-circle text-sm button"><i class="my-1 py-1 ri-download-cloud-line text-sm"></i></a></td>
                            <td>
                                <a @click="getItem(product,'update')" class="btn btn-sm btn-primary rounded-circle text-sm button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="my-1 py-1 ri-file-edit-fill text-sm"></i></a>
                                <a @click="getItem(product,'delete')" class="btn btn-sm btn-danger rounded-circle text-sm button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="my-1 py-1 ri-delete-bin-2-fill text-sm"></i></a>
                                <a @click="getItem(product,'view')" class="btn btn-sm btn-warning rounded-circle text-sm button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="my-1 py-1 ri-search-line text-sm"></i></a>
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
            <!-- form=='insert'?saveProduct():form=='update'?updateProduct():deleteProduct() ---- ternary operator untuk di form-->
            <!-- v-if="modal"  - --- - Unutk di modal jika tidak menggunakan boostrap.-->
            <form action="" @submit.prevent="form=='insert'?saveProduct():form=='update'?updateProduct():deleteProduct()">
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
                                    <div class="container">
                                        <h4 v-if="form=='delete'">Are sure want to delete <strong class="text-danger">"{{ vdata.product_name }}"</strong> ?</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <label v-if="form=='insert' || form=='update' || form=='view'" class="form-label">Product Name</label>
                                                <input type="text" v-if="form=='insert' || form=='update'" class="form-control" v-model="vdata.product_name" required>
                                                <input type="text" v-else-if="form=='view'" class="form-control" v-model="vdata.product_name" disabled>
                                                </input>
                                            </div>
                                            <div class="col-6">
                                                <label v-if="form=='insert' || form=='update' || form=='view'" class="form-label">Product Price</label>
                                                <input type="number" v-if="form=='insert' || form=='update'" class="form-control" v-model="vdata.product_price" required>
                                                <input type="number" v-else-if="form=='view'" class="form-control" v-model="vdata.product_price" disabled>
                                                </input>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6" style="padding-top:10px;">
                                                <label v-if="form=='insert' || form=='update' || form=='view'" class="form-label">Expired</label>
                                                <input type="date" v-if="form=='insert' || form=='update'" class="form-control" v-model="vdata.expired" required>
                                                <input type="date" v-else-if="form=='view'" class="form-control" v-model="vdata.expired" disabled>
                                            </div>
                                            <div class="col-6" style="padding-top:10px;">
                                                <label v-if="form=='insert' || form=='update' || form=='view'" for="formFile" class="form-label">Attachment</label>
                                                <input v-if="form=='insert' || form=='update'" class="form-control" type="file" id="file" accept="application/pdf" ref="file" v-on:change="handleFileUpload()">
                                                <div v-else-if="form=='view'"> <a @click="download()" class="btn btn-sm btn-success text-sm button"><i class="my-1 py-1 ri-download-cloud-line text-sm"></i> Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" v-if="form=='insert'">Save</button>
                                <button type="submit" class="btn btn-primary" v-else-if="form=='update'">Update</button>
                                <button type="submit" class="btn btn-danger" v-else-if="form=='delete'">Delete</button>
                                <!--    <button @click="getAlert" type="button" id="primary" class="btn btn-primary m-1">Primary</button> -->
                            </div>
                        </div>
                    </div>
                    <!-- Button trigger close modal -->
                    <button type="button" id="closeModal" class="btn btn-secondary" style="position:absolute;z-index:-100;top:-1000px;" data-bs-dismiss="modal"></button>
                </div>
            </form>
            <div class="animate__animated animate__bounceInDown modul-alert" :class="alert2?'update':alert3?'delete':''" id="modal-alert" v-if="alert1 || alert2 || alert3">
                <h6 v-if="alert1"> <i class="ri-checkbox-circle-fill"></i> Add data succces</h6>
                <h6 v-else-if="alert2"><i class="ri-checkbox-circle-fill"></i> Update data succces</h6>
                <h6 v-else-if="alert3"> <i class="ri-fire-fill"></i> Delete data succces</h6>
            </div>
            <!-- End Modal Save Product -->

            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <h3 class="card-header">Data Chart Block</h3>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <h3 class="card-header">Data Chart Spline</h3>
                            <div class="card-body">
                                <div id="chart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/js/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.lite.min.css"></script> -->

    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script> -->

    <script type="module">
        let formData;
        new Vue({
            el: '#app',
            data() {
                return {
                    products: [],
                    // modal: true, //variable close modal di button add data dan modal save TAPI gk diperlukan lagi karena sudah pake boostrap
                    form: 'insert',
                    search: '',
                    // page: 1,
                    vdata: {},
                    alert: false,
                    alert1: false,
                    alert2: false,
                    alert3: false,
                    file: '',
                    chart: <?= json_encode($company) ?>,
                }
            },
            created: function() {
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                this.getProducts();
            },
            computed: {
                filterData() {
                    let data = this.products
                    data = data.filter(e => e.product_name.toLowerCase().indexOf(this.search.toLowerCase()) != -1);
                    return data;
                }
            },
            methods: {
                // Get Product in table
                getProducts: function() {
                    axios.get('product/getproduct')
                        .then(res => {
                            // handle success
                            this.products = res.data;
                            // this.products = res.data.company;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },
                // Get Item untuk modal Edit, View, delete Product
                getItem: function(product, form) {
                    if (form == 'update') {
                        this.form = 'update'
                        // this.modal = true; // harusnya gk kepake karena sudah pake modal boostrap
                    } else if (form == 'view') {
                        this.form = 'view'
                        // this.modal = true;
                    } else {
                        this.form = 'delete'
                        // this.modal = true;
                    }
                    this.vdata = JSON.parse(JSON.stringify(product))
                },

                handleFileUpload() {
                    this.file = this.$refs.file.files[0];
                },
                clearFileUpload() {
                    this.$refs.file.value = null; //clear field input pada form file
                },
                //async menunggu method ini di run maka method selanjutnya tidak bisa jalan dulu
                async upload() {
                    formData = new FormData();
                    formData.append('file', this.file);
                    return await axios.post('product/upload',
                        formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    )
                },
                // Save Product
                saveProduct: async function() { //di tutup dengan async function
                    document.getElementById('closeModal').click();
                    let res = await this.upload(); //bagusnya metode ini karena dapat mengetahui jika method sebelumnya gagal
                    if (res.data.success == '2') {
                        alert('File gagal di upload')
                        return
                    }
                    this.vdata.attch = res.data.filepath;
                    axios.post('product/save', this.vdata)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.productName = '';
                            this.productPrice = '';
                            this.expired = '';
                            this.attch = '';
                            this.popAlert('alert1');
                            this.clearFileUpload();
                            // document.getElementById('modal-alert').classList.remove('animated__fadeOutDown');
                            // this.$forceUpdate();
                            console.log('SUCCESS!!')
                        })
                        .catch(err => {
                            // handle error
                            console.log('FAILURE!!');
                            console.log(err);
                        })

                },

                //Update Product
                updateProduct: async function() {
                    document.getElementById('closeModal').click();
                    let res = await this.upload(); //bagusnya metode ini karena dapat mengetahui jika method sebelumnya gagal
                    if (res.data.success == '2') {
                        alert('File gagal di upload')
                        return
                    }
                    this.vdata.attch = res.data.filepath;
                    axios.put(`product/update/${this.vdata.product_id}`, this.vdata)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.popAlert('alert2');
                            this.clearFileUpload();

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
                            this.modals = false;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },

                // Delete Product
                deleteProduct: function() {
                    document.getElementById('closeModal').click();
                    axios.delete(`product/delete/${this.vdata.product_id}`)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.popAlert('alert3');
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },
                popAlert(item) {
                    this.modals = false;
                    this[item] = !this[item]
                    setTimeout(() => {
                        document.getElementById('modal-alert').classList.add('animate__fadeOutDown');
                        setTimeout(() => {
                            this[item] = false;
                        }, 500);
                    }, 2500);
                },
                download() {
                    let data = {
                        path: `${this.vdata.attch}`
                    }
                    let name = `${this.vdata.attch}`.split('/')[2]
                    axios.post("<?= site_url() ?>" + `/product/download_pdf`, data, {
                        responseType: 'blob'
                    }).then(response => {
                        const href = URL.createObjectURL(response.data);
                        const link = document.createElement('a');
                        link.href = href;
                        link.setAttribute('download', `PDFku-0${this.vdata.product_id}.pdf`); //or any other extension
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });

                },
            },
            mounted: function() {
                let key = [...new Set(this.chart.map(e => e.code_comp))]; //key map . Dari this.chart.map itu mendapatkan code company namun dengan ..new set menghilangkan duplikat unik variabel code company tsb.
                let data = key.map(e => { //array dari variabel key tersebut di return sebagai object
                    return {
                        name: e, //variabel name di graphic di isi dengan code.comp 
                        data: this.chart.filter(k => e == k.code_comp).map(x => x.profit) // variabel data di graphic di filter untuk mendapatkan semua data profit sesuai dengan code company nya.
                    }
                })
                console.log(data)
                var options = {
                    series: data, //variabel data dari hasil mapping array
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        // colors: ['transparent']
                        colors: ['black']
                    },
                    xaxis: {
                        categories: ['Oct', 'Nov', 'Des'],
                    },
                    yaxis: {
                        title: {
                            text: 'Rp. (Rupiah)'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "Rp. " + val + ",00"
                            }
                        }
                    }
                };
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
                var options = {
                    series: [{
                        name: 'series1',
                        data: [31, 40, 28, 51, 42, 109, 100]
                    }, {
                        name: 'series2',
                        data: [11, 32, 45, 32, 34, 52, 41]
                    }],
                    chart: {
                        height: 350,
                        type: 'area'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    },
                };
                var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
                chart2.render();
            },
        })
    </script>
</body>

</html>