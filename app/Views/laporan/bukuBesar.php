<?php
$judulCard = [
    'Total Product Terjual',
    'Total Penjualan'
];
$volumeCard = [
    '3 pcs',
    'Rp 60.000'
];
$totalGaji = 0;
$totalGaji1 = 0;
$totalGaji2 = 0;
$totalGaji3 = 0;
$totalGaji4 = 0;
$totalGaji5 = 0;
$namaBulan = [
    'Januari', 'Februari', 'Maret', 'April',
    'Mei', 'Juni', 'Juli', 'Agustus',
    'September', 'Oktober', 'November', 'Desember'
];
$periodeTahun = [
    2021, 2022
];
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
                        <li class="breadcrumb-item"><a href="#">Pencatatan kas</a></li>
                        <li class="breadcrumb-item"><a href="#">Pengeluaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Beban</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
                    <div class="card-header" style="background-color: #eaeaea;">
                        Filter Laporan Buku Besar
                    </div>
                    <div class="card-body">
                        <form action="/laporan/bukuBesar" method="post">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" name="bulan">
                                        <option class="text-center" value="" disabled selected>Pilih Bulan</option>
                                        <option class="text-center" value="1">Januari</option>
                                        <option class="text-center" value="2">Februari</option>
                                        <option class="text-center" value="3">Maret</option>
                                        <option class="text-center" value="4">April</option>
                                        <option class="text-center" value="5">Mei</option>
                                        <option class="text-center" value="6">Juni</option>
                                        <option class="text-center" value="7">Juli</option>
                                        <option class="text-center" value="8">Agustus</option>
                                        <option class="text-center" value="9">September</option>
                                        <option class="text-center" value="10">Oktober</option>
                                        <option class="text-center" value="11">November</option>
                                        <option class="text-center" value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" name="tahun">
                                        <option class="text-center" value="" disabled selected>Pilih Tahun</option>
                                        <option class="text-center">2021</option>
                                        <option class="text-center">2022</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama CoA</label>
                                <div class="col-sm-4">
                                    <select class="custom-select mr-sm-2" name="coa">
                                        <option class="text-center" value="" disabled selected>Pilih CoA</option>
                                        <option class="text-center" value="kas">Kas</option>
                                        <option class="text-center" value="aset">Aset</option>
                                        <option class="text-center" value="Perlengkapan">Perlengkapan</option>
                                        <option class="text-center" value="beban">Beban</option>
                                        <option class="text-center" value="gaji">Gaji</option>
                                        <option class="text-center" value="lainnya">Transaksi Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if ($filterByCoa == 'kas') : ?>
        <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Buku Besar</h4>
                    <h4 class="text-center">
                        Periode
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <?php if ($filterByBulan == $i && $filterByTahun == 2021) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2021
                            <?php elseif ($filterByBulan == $i && $filterByTahun == 2022) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2022
                            <?php endif; ?>
                        <?php endfor; ?>
                    </h4>
                </div>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <h5>Kas</h5>
                </div>
            </div>
            <div class="row">
                <div class="col mt-2">
                    <table class="table table-bordered" style="background-color:white;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Tanggal</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 25%" class="text-center">Keterangan</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 5%">Ref</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Kredit</th>
                                <th style="border: 1px solid #eaeaea;" colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td style="background-color: #eee">Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <?php foreach ($dataTransaksiAsetByFilter->getResult() as $row) : ?>
                                <tr>
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>Kas</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianAset->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalAset ?></p>
                                                <?php $totalGaji1 += $row2->totalAset;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>Rp 0 </td>
                                    <td>
                                        <?= $totalGaji1; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($dataTransaksiBebanByFilter->getResult() as $row) : ?>
                                <tr>
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>Kas</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalBeban ?></p>
                                                <?php $totalGaji2 += $row2->totalBeban;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>Rp 0</td>
                                    <td>
                                        <?= $totalGaji1 + $totalGaji2; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($dataTransaksiBahanByFilter->getResult() as $row) : ?>
                                <tr>
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>Kas</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianBahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <p><?= $row2->totalBahan ?></p>
                                                <?php $totalGaji3 += $row2->totalBahan;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>Rp 0</td>
                                    <td><?= $totalGaji1 + $totalGaji2 + $totalGaji3; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($dataTransaksiLainnyaByFilter->getResult() as $row) : ?>
                                <tr>
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>Kas</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianTransaksiLainnya->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalTransaksi ?></p>
                                                <?php $totalGaji4 += $row2->totalTransaksi;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>Rp 0</td>
                                    <td><?= $totalGaji1 + $totalGaji2 + $totalGaji3 + $totalGaji4; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($upahGajiByFilter->getResult() as $row) : ?>
                                <tr>
                                    <td><?= $row->tanggalPenggajian; ?></td>
                                    <td>Kas</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <?= $row->upahGaji; ?>
                                        <?php $totalGaji5 += $row->upahGaji;  ?>
                                    </td>
                                    <td>Rp 0</td>
                                    <td><?= $totalGaji1 + $totalGaji2 + $totalGaji3 + $totalGaji4 + $totalGaji5; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>-</td>
                                <td style='background-color: #eee'>Saldo Akhir</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <?php foreach ($dataTransaksiAsetByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianAset->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalGaji += $row2->totalAset;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($dataTransaksiBebanByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalGaji += $row2->totalBeban;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach ?>
                                    <?php foreach ($dataTransaksiBahanByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianBahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <?php $totalGaji += $row2->totalBahan;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach ?>
                                    <?php foreach ($dataTransaksiLainnyaByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianTransaksiLainnya->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalGaji += $row2->totalTransaksi;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($upahGajiByFilter->getResult() as $row) : ?>
                                        <?php $totalGaji += $row->upahGaji; ?>
                                    <?php endforeach; ?>
                                    <?= $totalGaji; ?>
                                </td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
    <?php elseif ($filterByCoa == 'aset') : ?>
        <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Buku Besar</h4>
                    <h4 class="text-center">
                        Periode
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <?php if ($filterByBulan == $i && $filterByTahun == 2021) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2021
                            <?php elseif ($filterByBulan == $i && $filterByTahun == 2022) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2022
                            <?php endif; ?>
                        <?php endfor; ?>
                    </h4>
                </div>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <h5>Aset</h5>
                </div>
            </div>
            <div class="row">
                <div class="col mt-2">
                    <table class="table table-bordered" style="background-color:white;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Tanggal</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 25%" class="text-center">Keterangan</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 5%">Ref</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Kredit</th>
                                <th style="border: 1px solid #eaeaea;" colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td style="background-color: #eee">Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <?php $totalSeluruhAset = 0; ?>
                            <tr>
                                <td>
                                    <?php foreach ($dataTransaksiAsetByFilter->getResult() as $row) : ?>
                                        <?= $row->tanggalPembayaran;
                                        break; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>Kas</td>
                                <td>-</td>
                                <td>
                                    <?php foreach ($dataTransaksiAsetByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianAset->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalSeluruhAset += $row2->totalAset;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <p><?= $totalSeluruhAset; ?></p>
                                </td>
                                <td>-</td>
                                <td>
                                    <?= $totalSeluruhAset; ?>
                                </td>
                                <td>Rp 0</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td style='background-color: #eee'>Saldo Akhir</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?= $totalSeluruhAset; ?></td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
    <?php elseif ($filterByCoa == 'bahan') : ?>
        <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Buku Besar</h4>
                    <h4 class="text-center">
                        Periode
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <?php if ($filterByBulan == $i && $filterByTahun == 2021) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2021
                            <?php elseif ($filterByBulan == $i && $filterByTahun == 2022) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2022
                            <?php endif; ?>
                        <?php endfor; ?>
                    </h4>
                </div>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <h5>Bahan</h5>
                </div>
            </div>
            <div class="row">
                <div class="col mt-2">
                    <table class="table table-bordered" style="background-color:white;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Tanggal</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 25%" class="text-center">Keterangan</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 5%">Ref</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Kredit</th>
                                <th style="border: 1px solid #eaeaea;" colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td style="background-color: #eee">Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <?php $totalSeluruhBahan = 0; ?>
                            <tr>
                                <td>
                                    <?php foreach ($dataTransaksiBahanByFilter->getResult() as $row) : ?>
                                        <?= $row->tanggalPembayaran;
                                        break; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>Kas</td>
                                <td>-</td>
                                <td>
                                    <?php foreach ($dataTransaksiBahanByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianBahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <?php $totalSeluruhBahan += $row2->totalBahan;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <p><?= $totalSeluruhBahan; ?></p>
                                </td>
                                <td>-</td>
                                <td>
                                    <?= $totalSeluruhBahan; ?>
                                </td>
                                <td>Rp 0</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td style='background-color: #eee'>Saldo Akhir</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?= $totalSeluruhBahan; ?></td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
    <?php elseif ($filterByCoa == 'beban') : ?>
        <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Buku Besar</h4>
                    <h4 class="text-center">
                        Periode
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <?php if ($filterByBulan == $i && $filterByTahun == 2021) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2021
                            <?php elseif ($filterByBulan == $i && $filterByTahun == 2022) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2022
                            <?php endif; ?>
                        <?php endfor; ?>
                    </h4>
                </div>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <h5>Beban</h5>
                </div>
            </div>
            <div class="row">
                <div class="col mt-2">
                    <table class="table table-bordered" style="background-color:white;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Tanggal</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 25%" class="text-center">Keterangan</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 5%">Ref</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Kredit</th>
                                <th style="border: 1px solid #eaeaea;" colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td style="background-color: #eee">Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <?php $totalSeluruhBeban = 0; ?>
                            <tr>
                                <td>
                                    <?php foreach ($dataTransaksiBebanByFilter->getResult() as $row) : ?>
                                        <?= $row->tanggalPembayaran;
                                        break; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>Kas</td>
                                <td>-</td>
                                <td>
                                    <?php foreach ($dataTransaksiBebanByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalSeluruhBeban += $row2->totalBeban;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <p><?= $totalSeluruhBeban; ?></p>
                                </td>
                                <td>-</td>
                                <td>
                                    <?= $totalSeluruhBeban; ?>
                                </td>
                                <td>Rp 0</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td style='background-color: #eee'>Saldo Akhir</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?= $totalSeluruhBeban; ?></td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
    <?php elseif ($filterByCoa == 'gaji') : ?>
        <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Buku Besar</h4>
                    <h4 class="text-center">
                        Periode
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <?php if ($filterByBulan == $i && $filterByTahun == 2021) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2021
                            <?php elseif ($filterByBulan == $i && $filterByTahun == 2022) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2022
                            <?php endif; ?>
                        <?php endfor; ?>
                    </h4>
                </div>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <h5>Gaji</h5>
                </div>
            </div>
            <div class="row">
                <div class="col mt-2">
                    <table class="table table-bordered" style="background-color:white;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Tanggal</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 25%" class="text-center">Keterangan</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 5%">Ref</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Kredit</th>
                                <th style="border: 1px solid #eaeaea;" colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td style="background-color: #eee">Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <?php $totalSeluruhGaji = 0; ?>
                            <tr>
                                <td>
                                    <?php foreach ($upahGajiByFilter->getResult() as $row) : ?>
                                        <?= $row->tanggalPenggajian;
                                        break; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>Kas</td>
                                <td>-</td>
                                <td>
                                    <?php foreach ($upahGajiByFilter->getResult() as $row) : ?>
                                        <?php $totalSeluruhGaji += $row->upahGaji;  ?>
                                    <?php endforeach; ?>
                                    <p><?= $totalSeluruhGaji; ?></p>
                                </td>
                                <td>-</td>
                                <td>
                                    <?= $totalSeluruhGaji; ?>
                                </td>
                                <td>Rp 0</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td style='background-color: #eee'>Saldo Akhir</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?= $totalSeluruhGaji; ?></td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
    <?php elseif ($filterByCoa == 'lainnya') : ?>
        <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Buku Besar</h4>
                    <h4 class="text-center">
                        Periode
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <?php if ($filterByBulan == $i && $filterByTahun == 2021) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2021
                            <?php elseif ($filterByBulan == $i && $filterByTahun == 2022) : ?>
                                <?= $namaBulan[$i - 1]; ?> 2022
                            <?php endif; ?>
                        <?php endfor; ?>
                    </h4>
                </div>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <h5>Transaksi Lainnya</h5>
                </div>
            </div>
            <div class="row">
                <div class="col mt-2">
                    <table class="table table-bordered" style="background-color:white;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Tanggal</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 25%" class="text-center">Keterangan</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" style="width: 5%">Ref</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" rowspan="2" class="text-center">Kredit</th>
                                <th style="border: 1px solid #eaeaea;" colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                                <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td style="background-color: #eee">Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <?php $totalSeluruhTransaksi = 0; ?>
                            <tr>
                                <td>
                                    <?php foreach ($dataTransaksiLainnyaByFilter->getResult() as $row) : ?>
                                        <?= $row->tanggalPembayaran;
                                        break; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>Kas</td>
                                <td>-</td>
                                <td>
                                    <?php foreach ($dataTransaksiLainnyaByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianTransaksiLainnya->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalSeluruhTransaksi += $row2->totalTransaksi;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <p><?= $totalSeluruhTransaksi; ?></p>
                                </td>
                                <td>-</td>
                                <td>
                                    <?= $totalSeluruhTransaksi; ?>
                                </td>
                                <td>Rp 0</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td style='background-color: #eee'>Saldo Akhir</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?= $totalSeluruhTransaksi; ?></td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>