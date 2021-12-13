<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body background="sky2.svg">
<div id="crudApp">

    <div class="container">
        <div class="row align-items-start">
            <div class="col"></div>
            <div class="col">
                <div class="text-center">
                    <img src="Green%20nature.svg" class="img-thumbnail rounded" alt="..." width="100%">
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <form action="submit" v-on:submit.prevent="" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">
                <span class="badge bg-primary"><h4 style="color: white">Имя: </h4></span>
            </label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="name">

        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">
                <span class="badge bg-primary"><h4 style="color: white">Комментарий: </h4></span>
            </label>
            <input type="text" class="form-control" id="exampleInputPassword1" v-model="text">
        </div>
        <button class="btn btn-primary" @click="updateOp"><h5>Добавить комментарий</h5></button>
    </form>

    <div class="container" style="margin: 5px" v-for="row in getData">
        <div class="row border border-info" style="color: black">
            <div class="col-12"> <span><h6>{{ row.name }}</h6> Время добавления: {{ row.date }} {{ row.time }}</span> </div>
            <div class="col-12 rounded float-start border border-info">{{ row.text }}</div>
            <div class="col-6">
                <button class="btn btn-danger" style="margin: 4px" @click="updateDelete(row.id)">Удалить</button>
            </div>
        </div>
    </div>

</div>
</body>
</html>

<script>
    const application = new Vue({
        el: '#crudApp',
        data: {
            allData: [], name: '', text: '', deleteidx: -1
        },
        methods: {
            async updateOp() {
                await this.postFetch()
                this.myFetch()

            },
            myFetch: function () {
                const url = `http://sql-php-vue-axios/newfetch.php`
                axios.get(url).then(response => response.data)
                    .then((data) => {
                        this.allData = data
                    })
            },
            postFetch: function () {
                let formData = new FormData()
                formData.append("added", 1)
                formData.append("name", this.name)
                formData.append("text", this.text)
                formData.append("dated", this.Dated)
                formData.append("timed", this.Timed)
                this.name = ""
                this.text = ""

                axios({
                    method: `post`,
                    url: `http://sql-php-vue-axios/newfetch.php`,
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'text/html',
                            "Access-Control-Allow-Origin": " *",
                            "charset": "utf8mb4_general_ci"
                        }
                    }
                })
                    .then(function (response) {
                    })
                    .catch(function (response) {
                    });
                this.myFetch()
            },
            deleteFetch: function () {
                let formData = new FormData()
                formData.append("added", 1234567890)
                formData.append("idx", this.deleteidx)
                axios({
                    method: `post`,
                    url: `http://sql-php-vue-axios/newfetch.php`,
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'text/html',
                            "Access-Control-Allow-Origin": " *",
                            "charset": "utf8mb4_general_ci"
                        }
                    }
                })
                    .then(function (response) {
                    })
                    .catch(function (response) {
                    });
                this.myFetch()
            },
            updateDelete(idx) {
                this.deleteidx = idx
                this.deleteFetch()
                this.myFetch()
            }
        },
        computed: {
            Dated() {
                function toIsoString(date) {
                    var tzo = -date.getTimezoneOffset(),
                        dif = tzo >= 0 ? '+' : '-',
                        pad = function (num) {
                            var norm = Math.floor(Math.abs(num));
                            return (norm < 10 ? '0' : '') + norm;
                        };

                    return date.getFullYear() +
                        '-' + pad(date.getMonth() + 1) +
                        '-' + pad(date.getDate()) +
                        'T' + pad(date.getHours()) +
                        ':' + pad(date.getMinutes()) +
                        ':' + pad(date.getSeconds()) +
                        dif + pad(tzo / 60) +
                        ':' + pad(tzo % 60);
                }

                const t = new Date()
                return toIsoString(t).slice(0, 10)

            },
            Timed() {
                function toIsoString(date) {
                    var tzo = -date.getTimezoneOffset(),
                        dif = tzo >= 0 ? '+' : '-',
                        pad = function (num) {
                            var norm = Math.floor(Math.abs(num));
                            return (norm < 10 ? '0' : '') + norm;
                        };

                    return date.getFullYear() +
                        '-' + pad(date.getMonth() + 1) +
                        '-' + pad(date.getDate()) +
                        'T' + pad(date.getHours()) +
                        ':' + pad(date.getMinutes()) +
                        ':' + pad(date.getSeconds()) +
                        dif + pad(tzo / 60) +
                        ':' + pad(tzo % 60);
                }

                const t = new Date()
                return toIsoString(t).slice(11, 16)
            },
            getData() {
                return this.allData.slice().reverse();
            },
        },
        created: function () {
            this.myFetch()
        }
    });
</script>