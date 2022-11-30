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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>

<body>
    <div id="app">
        <main>
            <div class="container" id="uploadApp">
                <br />
                <h3 align="center">How to upload file using Vue.js with PHP</h3>
                <br />
                <div v-if="successAlert" class="alert alert-success alert-dismissible">
                    <a href="#" class="close" aria-label="close" @click="successAlert=false">&times;</a>
                    {{ successMessage }}
                </div>

                <div v-if="errorAlert" class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" aria-label="close" @click="errorAlert=false">&times;</a>
                    {{ errorMessage }}
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="panel-title">Upload File</h3>
                            </div>
                            <div class="col-md-6" align="right">

                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4" align="right">
                                <label>Select Image</label>
                            </div>
                            <div class="col-md-4">
                                <input type="file" ref="file" />
                            </div>
                            <div class="col-md-4">
                                <button type="button" @click="uploadImage" class="btn btn-primary">Upload Image</button>
                            </div>
                        </div>
                        <br />
                        <br />
                        <div v-html="uploadedImage" align="center"></div>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/js/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.lite.min.css"></script> -->

    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script> -->

    <script type="module">
        var application = new Vue({
            el: '#uploadApp',
            data: {
                file: '',
                successAlert: false,
                errorAlert: false,
                uploadedImage: '',
            },
            methods: {
                uploadImage: function() {

                    application.file = application.$refs.file.files[0];

                    var formData = new FormData();

                    formData.append('file', application.file);

                    axios.post('product/do_upload', formData, {
                        header: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(function(response) {
                        if (response.data.image == '') {
                            application.errorAlert = true;
                            application.successAlert = false;
                            application.errorMessage = response.data.message;
                            application.successMessage = '';
                            application.uploadedImage = '';
                        } else {
                            application.errorAlert = false;
                            application.successAlert = true;
                            application.errorMessage = '';
                            application.successMessage = response.data.message;
                            var image_html = "<img src='" + response.data.image + "' class='img-thumbnail' width='200' />";
                            application.uploadedImage = image_html;
                            application.$refs.file.value = '';
                        }
                    });
                }
            },
        });
    </script>
</body>

</html>