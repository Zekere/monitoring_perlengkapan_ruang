<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Perlengkapan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1>✅ Monitoring Perlengkapan Barang</h1>
            <p class="lead">Sistem pelacakan aset dan kelengkapan ruangan</p>
        </div>

        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h3>{{ $stats['ruangan'] }}</h3>
                        <p>Ruangan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h3>{{ $stats['item'] }}</h3>
                        <p>Item</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h3>{{ $stats['pengecekan'] }}</h3>
                        <p>Pengecekan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h3>{{ $stats['hilang'] }}</h3>
                        <p>Item Hilang</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p>✅ Database terhubung. Laravel siap dikembangkan!</p>
        </div>
    </div>
</body>
</html>