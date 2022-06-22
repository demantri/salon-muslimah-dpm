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
                        Filter Laporan Jurnal Umum
                    </div>
                    <div class="card-body">
                        <form action="/laporan/jurnalUmum" method="post">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" id="jenisBeban1" name="bulan">
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
                                    <select class="custom-select mr-sm-2" id="jenisBeban1" name="tahun">
                                        <option class="text-center" value="" disabled selected>Pilih Tahun</option>
                                        <option class="text-center">2021</option>
                                        <option class="text-center">2022</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama CoA</label>
                                <div class="col-sm-4">
                                    <select class="custom-select mr-sm-2" id="jenisBeban1" name="akun-coa">
                                        <option class="text-center" value="" disabled selected>Pilih CoA</option>
                                        <option class="text-center">Kas</option>
                                        <option class="text-center">Aset</option>
                                        <option class="text-center">Bahan</option>
                                        <option class="text-center">Beban</option>
                                        <option class="text-center">Gaji</option>
                                        <option class="text-center">Transaksi Lainnya</option>
                                    </select>
                                </div>
                            </div> -->
                            <button class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if ($filterByBulan !== null && $filterByTahun !== null) : ?>
        <section class="section" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
            <div class="row">
                <div class="col-md">
                    <h4 class="text-center">Salon Muslimah DPM</h4>
                    <h4 class="text-center">Jurnal Umum</h4>
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
                <div class="col mt-2">
                    <table id="tabelmenu" class="table table-bordered table-striped" style="background-color:white;">
                        <thead>
                            <tr class="text-center" style="background-color: #eaeaea; box-shadow: 2px 1px 3px 0px rgba(0,0,0,0.75);">
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <!-- <th>No Akun</th> -->
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataTransaksiAsetByFilter->getResult() as $row) : ?>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>
                                        <?php foreach ($all_data_aset->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->namaAset; ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>
                                        <?php foreach ($totalPembelianAset->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalAset ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>-</td>
                                </tr>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>
                                        Kas
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianAset->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalAset ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($dataTransaksiBebanByFilter->getResult() as $row) : ?>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>
                                        <?php foreach ($all_data->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->jenisBeban; ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalBeban ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>-</td>
                                </tr>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>
                                        Kas
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalBeban ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <?php foreach ($dataTransaksiBahanByFilter->getResult() as $row) : ?>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>
                                        <?php foreach ($all_data_bahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <p>Perlengkapan</p>
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>
                                        <?php foreach ($totalPembelianBahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <p><?= $row2->totalBahan ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>-</td>
                                </tr>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPembayaran; ?></td>
                                    <td>
                                        Kas
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianBahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <p><?= $row2->totalBahan ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <?php foreach ($dataTransaksiLainnyaByFilter->getResult() as $row) : ?>
                                <tr class="text-center">
                                    <td>
                                        <?= $row->tanggalPembayaran; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($all_data_lainnya->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->jenisTransaksi; ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>
                                        <?php foreach ($totalPembelianTransaksiLainnya->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalTransaksi ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>-</td>
                                </tr>
                                <tr class="text-center">
                                    <td>
                                        <?= $row->tanggalPembayaran; ?>
                                    </td>
                                    <td>
                                        Kas
                                    </td>
                                    <!-- <td>121</td> -->
                                    <td>-</td>
                                    <td>
                                        <?php foreach ($totalPembelianTransaksiLainnya->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <p><?= $row2->totalTransaksi ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($upahGajiByFilter->getResult() as $row) : ?>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPenggajian; ?></td>
                                    <td>Beban Gaji</td>
                                    <!-- <td>121</td> -->
                                    <td><?= $row->upahGaji; ?></td>
                                    <td>-</td>
                                </tr>
                                <tr class="text-center">
                                    <td><?= $row->tanggalPenggajian; ?></td>
                                    <td>Kas</td>
                                    <!-- <td>121</td> -->
                                    <td>-</td>
                                    <td><?= $row->upahGaji; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- <tr class="text-center">
                                <td>2 Desember 2021</td>
                                <td>Kas</td>
                                <td>121</td>
                                <td>-</td>
                                <td>250000</td>
                            </tr> -->
                        </tbody>
                        <thead>
                            <tr class="text-center" style="background-color: #eaeaea; box-shadow: 2px 1px 3px 0px rgba(0,0,0,0.75);">
                                <th></th>
                                <th></th>
                                <th>
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
                                </th>
                                <th><?= $totalGaji; ?></th>
                                <!-- <th>50000</th> -->
                            </tr>
                        </thead>
                    </table>
                    <!-- <script>
                    $(document).ready(function() {
                        $('#tabelmenu').DataTable();
                    });
                </script> -->
                </div>
            </div>
        </section>
        <!-- p elseif(): ?> -->
    <?php endif; ?>
</div>