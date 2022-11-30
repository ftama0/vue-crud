//src/components/fileUpload.vue
<template>
    <div class="container">
        <div class="row">
            <h1>Vuejs Vue CLI File Upload with Axios and PHP</h1>
            <label>File
                <input type="file" id="file" ref="file" />
            </label>
            <button v-on:click="uploadFile()">Upload</button>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                file: ''
            }
        },
        methods: {

            uploadFile: function() {

                this.file = this.$refs.file.files[0];
                let formData = new FormData();
                formData.append('file', this.file);
                this.$refs.file.value = '';
                this.axios.post('http://localhost/devtest/upload.php', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function(response) {

                        if (!response.data) {
                            alert('File not uploaded.');
                        } else {
                            alert('File uploaded successfully.');

                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    });

            }
        },

    }
</script>