<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        .input {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <form id="app" @submit="checkForm" method="post">

        <p v-if="errors.length">
            <b>Please correct the following error(s):</b>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
        </p>

        <p>
            <label for="name">New Product Name: </label>
            <input type="text" name="name" id="name" v-model="name">
        </p>

        <p>
            <input type="submit" value="Submit">
        </p>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="module">
        // const apiUrl = 'https://vuecookbook.netlify.app/.netlify/functions/product-name?name

        const app = new Vue({
            el: '#app',
            data: {
                errors: [],
                name: ''
            },
            methods: {
                checkForm: function(e) {
                    e.preventDefault();
                    this.errors = [];
                    if (this.name == 0) {
                        this.errors.push("Product name is required.");
                    } else {
                        fetch(apiUrl + encodeURIComponent(this.name))
                            .then(async res => {
                                if (res.status == 204) {
                                    alert('Ok!')
                                } else if (res.status == 400) {
                                    let errorResponse = await res.json();
                                    this.errors.push(errorResponse.error);
                                }
                            });
                    }
                }
            }
        })
    </script>
</body>

</html>