@extends('layout.app')
  
@section('title', 'Informasi - Cafe ')
  
@section('contents')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Total Pendapatan Cafe</title>
    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div>
        <div style="border:1px solid lightblue; padding:1.5rem;width: 320px; height: 240;">
            <h3>Total Stok</h3>
            <h5>{{$total_stok}}</h5>
        </div>
    </div>
    <hr>
    <div style="width: 600px; height: 400px;">
        <!-- !! FILTER -->
        <div>
            <h2>Filter Chart</h2>
            <div>
                <label for="minDate">Tanggal Awal: </label>
                <input chart-filter-date type="date" id="minDate" name="minDate" onchange="handleDateChange(this,'minDate')">
            </div>
            <div>
                <label for="maxDate">Tanggal Akhir: </label>
                <input chart-filter-date type="date" id="maxDate" name="maxDate" onchange="handleDateChange(this,'maxDate')">
            </div>
        </div>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <script>
        let minDate = false;
        let maxDate = false;
        renderChart(minDate, maxDate)

        function handleDateChange(event, date){
            console.log('handleDateChange:',date,event.value)
            switch(date){
                case "minDate":
                    minDate = event.value
                    break;
                case "maxDate":
                    maxDate = event.value
                    break;
            }
            renderChart()
        }
        // let chartFilterInput = document.querySelectorAll("[chart-filter-date]")
        // chartFilterInput.onChange =
        // Fungsi untuk memformat nilai ke dalam format Rupiah
        let ctx = document.getElementById('myChart').getContext('2d');
        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + ribuan;
        }

        // Membuat chart
        async function renderChart(){
            let url = `data_chart?`
            if(minDate){
                url += `minDate=${minDate}&`
            }
            if(maxDate){
                url += `maxDate=${maxDate}`
            }
            console.log(url)
            let fetchData = await fetch(url).then(r=>{console.log(r);return r.json()})
            .then(d=>{console.log(d);return d})
            .catch(er=>console.log(er))

            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: fetchData.map(item => item.tanggal),
                    datasets: [{
                        label: 'Total Pendapatan Cafe',
                        data: fetchData.map(item => item.total_harga), // Misalnya pendapatan dalam Rupiah
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options:  {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                // Panggil fungsi formatRupiah untuk setiap nilai di sumbu Y
                                return formatRupiah(value);
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            // Panggil fungsi formatRupiah untuk tooltip
                            return 'Total Pendapatan: ' + formatRupiah(value);
                        }
                    }
                }
            }
            });
        }
    </script>
</body>
</html>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* Styling for sections */
        section {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        /* Styling for section headings */
        h2 {
            color: #333;
            font-size: 24px;
            margin-top: 0;
        }
        
        /* Styling for section paragraphs */
        p {
            color: #666;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <section id="tentang-aplikasi">
        <h2>Tentang Aplikasi</h2>
        <p>Aplikasi ini mempermudah segalanya</p>
    </section>
    <section id="layanan-aplikasi">
        <h2>Layanan Aplikasi</h2>
        <p>Selalu ada barang disini</p>
    </section>
    <section id="sejarah-aplikasi">
        <h2>Sejarah Aplikasi</h2>
        <p>Aplikasi dibuat dicampur sama bantuan tangan teman</p>
    </section>
</body>
</html> -->

<!-- Tambahkan kode HTML untuk menampilkan alamat lengkap -->
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Alamat dan Peta Kami</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
        }
        .container > * {
            flex: 1 1 45%;
            margin: 10px;
        }
        .map-container {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; /* Aspect ratio 16:9 */
        }
        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head> -->
<!-- <body>
    <h3>Alamat dan Peta Kami</h3>
    <p>Jalan Kh Achmad Munawar No.1 Bandung, JawaBarat, Indonesia</p>
    <div class="container">
        <div class="office-image">
            <img src="https://png.pngtree.com/thumb_back/fw800/png-vector/20200530/ourmid/pngtree-indoor-office-png-image_2215291.jpg" width="100%" height="auto">
        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="auto" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <h3>Hubungi Kami Jika Ada Kendala</h3>
        @csrf
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="message">Pesan:</label>
        <input type="pesan" id="pesan" name="pesan" required>
        <button type="submit">Kirim</button>
    </form>
</body>
</html> -->


@endsection