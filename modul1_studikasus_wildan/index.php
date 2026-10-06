<?php
// Data produk (array PHP)
$produk = [
    ["nama" => "Monitor 24 Inch",       "kategori" => "Monitor",     "harga" => 2000000, "stok" => 5],
    ["nama" => "Laptop Productivity",   "kategori" => "Laptop",      "harga" => 8500000, "stok" => 4],
    ["nama" => "Mouse Wireless",        "kategori" => "Aksesoris",   "harga" => 150000,  "stok" => 15],
    ["nama" => "Keyboard Mechanical",   "kategori" => "Aksesoris",   "harga" => 650000,  "stok" => 7],
    ["nama" => "Headset Gaming",        "kategori" => "Audio",       "harga" => 450000,  "stok" => 0],
    ["nama" => "Smartphone Lite",       "kategori" => "Smartphone",  "harga" => 3200000, "stok" => 5],
    ["nama" => "Flashdisk 64GB",        "kategori" => "Penyimpanan", "harga" => 85000,   "stok" => 0],
    ["nama" => "Webcam Full HD",        "kategori" => "Aksesoris",   "harga" => 1000000, "stok" => 2],
];
const BATAS_DISKON  = 1000000; // harga minimal untuk dapat diskon
const PERSEN_DISKON = 10;      // besar diskon (%)

function formatRupiah($angka) {
    return "Rp" . number_format($angka, 0, ",", ".");
}

function dapatDiskon($harga) {
    return $harga >= BATAS_DISKON;
}

function hitungHargaDiskon($harga) {
    $potongan = $harga * PERSEN_DISKON / 100;
    return $harga - $potongan;
}

$totalProduk = count($produk);
$kartuHtml = "";

foreach ($produk as $item) {
    $nama     = htmlspecialchars($item["nama"]);
    $kategori = htmlspecialchars($item["kategori"]);
    $stok     = $item["stok"];

    if ($stok > 0) {
        $status = '<span class="status status-ok">Tersedia</span>';
        $tombol = '<button class="btn btn-dark" type="button">Beli Sekarang</button>';
    } else {
        $status = '<span class="status status-out">Stok Habis</span>';
        $tombol = '<button class="btn btn-dark" type="button" disabled>Stok Habis</button>';
    }

    if (dapatDiskon($item["harga"])) {
        $tagDiskon = '<span class="discount-tag">Diskon ' . PERSEN_DISKON . '%</span>';
        $harga = '<span class="price-old">' . formatRupiah($item["harga"]) . '</span>'
               . '<span class="price">' . formatRupiah(hitungHargaDiskon($item["harga"])) . '</span>';
    } else {
        $tagDiskon = "";
        $harga = '<span class="price-old price-placeholder">&nbsp;</span>'
               . '<span class="price">' . formatRupiah($item["harga"]) . '</span>';
    }

    $kartuHtml .= <<<HTML
            <article class="card">
                <p class="card-category">{$kategori} {$tagDiskon}</p>
                <h3>{$nama}</h3>
                <div class="price-box">{$harga}</div>
                <div class="card-meta">
                    <span>Stok: {$stok}</span>
                    {$status}
                </div>
                {$tombol}
            </article>

HTML;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cia Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="navbar">
        <div class="container navbar-inner">
            <a href="#home" class="logo">Cia Store</a>
            <nav class="nav-links">
                <a href="#home">Home</a>
                <a href="#produk">Products</a>
                <a href="#footer">About</a>
            </nav>
        </div>
    </header>

    <main class="container">

        <section class="hero" id="home">
            <p class="hero-label">Cia Store</p>
            <h1>Simple Tech Store.</h1>
            <p class="hero-desc">Temukan berbagai perangkat dan aksesoris teknologi untuk kebutuhanmu.</p>
            <a href="#produk" class="btn btn-light">Lihat Produk</a>
        </section>

        <section class="catalog-head" id="produk">
            <div>
                <p class="section-label">Our Products</p>
                <h2>Katalog Produk</h2>
            </div>
            <div class="total-badge">Total Produk: <strong><?= $totalProduk ?></strong></div>
        </section>

        <section class="grid">
<?= $kartuHtml ?>
        </section>

    </main>

    <footer class="footer" id="footer">
        <div class="container">
            <p>&copy; <?= date("Y") ?> Cia Store. Toko perangkat dan aksesoris teknologi.</p>
        </div>
    </footer>

</body>
</html>