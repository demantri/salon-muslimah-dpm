<?php
$judulCard = [
    'Total Product Terjual',
    'Total Penjualan'
];
$volumeCard = [
    '3 pcs',
    'Rp 60.000'
]
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header" style="box-shadow: 7px 0px 7px rgba(0,0,0,0.75);">
            <div class="col-md-6">
                <h2>DASHBOARD</h2>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class=" breadcrumb mt-3 d-flex justify-content-end" style="background-color: white;">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <div class="row">
        <?php for ($i = 0; $i < 2; $i++) : ?>
            <div class="col-xl-4 section text-center">
                <!-- <div class="card" style="border-radius: 20px; box-shadow: 0px 2px 2px 0px rgba(0,0,0,0.75); "> -->
                <div class="card info_card" style="
                background: rgba(255, 255, 255, 0);
                border-radius: 16px;
                backdrop-filter: blur(1.2px);
                -webkit-backdrop-filter: blur(1.2px);
                border: 1px solid rgba(255, 255, 255, 0.29);
                box-shadow: 1px 4px 5px 3px rgba(0,0,0,0.75);
                ">
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 20px;">
                            <p style="font-weight: bold;"><?= $judulCard[$i]; ?></p>
                        </h3>
                        <h3 class="card-subtitle mb-2 text-muted mt-2 font-size: 14px;">
                            <?php if ($judulCard[$i] == 'Total Product Terjual') : ?>
                                <?php foreach ($totalHistoryPembayaran->getResult() as $row) : ?>
                                    <p><?= $row->totalProduk ?> pcs</p>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?php foreach ($totalHistoryPembayaran->getResult() as $row) : ?>
                                    <p>Rp<?= $row->totalPembayaran ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <section class="section" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
        <div class="row">
            <div class="col-md-10">
                <h4>Data Pembelian Product</h4>
            </div>
        </div>
        <div class="row">
            <div class="col mt-2">
                <table id="tabelmenu" class="table table-striped table-sm">
                    <!-- <thead>
                        <tr class="text-center">
                            <th class="table-bordered"><a class="text-dark" href="/user/dashboard/product/offline-shipping" style="text-decoration: none;">Offline Shipping</a></th>
                            <th class="table-bordered" style="background-color: #eaeaea;"><a class="text-dark" href="/user/dashboard/product/pembayaran" style="text-decoration: none;">Pembayaran</a></th>
                            <th class="table-bordered"><a class="text-dark" href="/user/dashboard/product/history" style="text-decoration: none;">History</a></th>
                        </tr>
                    </thead> -->
                    <a class="btn btn-light mr-1 mb-2 text-dark" style="background-color: #eaeaea;" href="/user/dashboard/product/offline-shipping" style="text-decoration: none;">Offline Shipping</a>
                    <a class="btn btn-light mr-1 mb-2 text-dark" href="/user/dashboard/product/pembayaran" style="text-decoration: none;">Pembayaran</a>
                    <a class="btn btn-light mr-1 mb-2 text-dark" style="background-color: #eaeaea;" href="/user/dashboard/product/history" style="text-decoration: none;">History</a>
                    <thead>
                        <tr class="text-center" style="background-color: #eaeaea; box-shadow: 2px 1px 3px 0px rgba(0,0,0,0.75);">
                            <th>ID</th>
                            <th>Nama Product</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Nama Admin</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($dataTransaksi->getResult() as $row) : ?>
                            <tr class="text-center">
                                <td>
                                    <?= $row->kodetransaksi; ?>
                                </td>
                                <td>
                                    <?php foreach ($all_data->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <p><?= $row2->namaProduk; ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($all_data->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <p><?= $row2->jumlahProduk; ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($all_data->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <p><?= $row2->price; ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($namaAdmin->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <p><?= $row2->namaAdmin; ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($tanggalPembelian->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <p><?= $row2->tanggalPembelian; ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <form action="/Product/updateStatusPembayaran/<?= $row->id; ?>" method="post">
                                        <input type="hidden" name="statusPembayaran" value="Sudah Membayar">
                                        <input type="hidden" name="tanggalPembayaran" value="<?= date('Y-m-d'); ?>">
                                        <input type="hidden" id="kodetransaksi" name="kodetransaksi" value="<?= $row->kodetransaksi; ?>">
                                        <input type="hidden" id="totalPembayaran" name="totalPembayaran" value="
                                        <?php foreach ($totalPembelian->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <?= $row2->total ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                        ">
                                        <input type="hidden" id="totalProduk" name="totalProduk" value="
                                        <?php foreach ($totalPembelian->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <?= $row2->jumlahProduk ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                        ">
                                        <?php foreach ($statusPembayaran->getResult() as $row2) : ?>
                                            <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                                <?php if ($row2->statusPembayaran == null) : ?>
                                                    <button type="submit" class="btn btn-warning" id="<?= $row->kodetransaksi; ?>" onclick="return confirm('Apakah anda yakin?')">Bayar</button>
                                                <?php else : ?>
                                                    <span class="badge badge-success">Sudah Bayar</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </form>
                                </td>
                                <td>
                                    <?php foreach ($totalPembelian->getResult() as $row2) : ?>
                                        <?php if ($row2->kodetransaksi == $row->kodetransaksi) : ?>
                                            <p><?= $row2->total ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script>
            </div>
        </div>
    </section>
</div>
<script src="<?= base_url('/js/vanilla-tilt.js'); ?>"></script>
<script type="text/javascript">
    VanillaTilt.init(document.querySelectorAll(".info_card"), {
        max: 25,
        speed: 4300,
        glare: true,
        "max-glare": 1,
    });
</script>