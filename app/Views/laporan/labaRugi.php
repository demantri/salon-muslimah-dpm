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
$totalLabaKotor = 0;
$totalSeluruhProduct = 0;
$totalSeluruhService = 0;
$totalSeluruhBahan = 0;
$totalSeluruhBeban = 0;
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
                        Filter Laporan Laba Rugi
                    </div>
                    <div class="card-body">
                        <form action="/laporan/labaRugi" method="post">
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
                            <!-- <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama CoA</label>
                                <div class="col-sm-4">
                                    <select class="custom-select mr-sm-2"  name="jenisBeban[]">
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
                    <h4 class="text-center">Laba Rugi</h4>
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
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th style="border-bottom: 1px solid #eaeaea;" colspan=4><b>Pendapatan</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-bottom: 1px solid #eaeaea;" style='width: 50%'></td>
                            <td style="border-bottom: 1px solid #eaeaea;" colspan=2><b>Laba Kotor</b></td>
                            <td style="border-bottom: 1px solid #eaeaea;" class="text-right" colspan=2>
                                <b>Rp
                                    <?php foreach ($totalHistoryPembayaranProductByFilter->getResult() as $row) : ?>
                                        <!-- <p>Rp $row->totalPembayaran ?></p> -->
                                        <?php $totalSeluruhProduct +=  $row->totalPembayaran; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($totalHistoryPembayaranServiceByFilter->getResult() as $row) : ?>
                                        <!-- <p>Rp $row->totalPembayaran ?></p> -->
                                        <?php $totalSeluruhService +=  $row->totalPembayaran; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($dataTransaksiBahanByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianBahan->getResult() as $row2) : ?>
                                            <?php if ($row2->idPeralatan == $row->idPeralatan) : ?>
                                                <?php $totalSeluruhBahan += $row2->totalBahan; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <!-- <p>Rp $totalSeluruhBahan; ?></p> -->
                                    
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #eaeaea;" colspan=3><b>Beban: </b></td>
                            <td style="border-bottom: 1px solid #eaeaea;" class='text-right'></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #eaeaea;" style='width: 50%'></td>
                            <td style="border-bottom: 1px solid #eaeaea;" colspan=2><b>Total Beban</b></td>
                            <td style="border-bottom: 1px solid #eaeaea;" class="text-right" colspan=2>
                                <b>
                                    <?php foreach ($dataTransaksiBebanByFilter->getResult() as $row) : ?>
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php $totalSeluruhBeban += $row2->totalBeban;  ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach ?>
                                    
                                </b>
                            </td>
                        </tr>

                        <tr>
                            <td style='width: 50%' style="background-color: #eee"></td>
                            <td colspan=2 style="background-color: #eee"><b>Laba Bersih </b></td>
                            <td colspan=2 style="background-color: #eee" class="text-right">
                                <b>
                                    
                                </b>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
            </div>
            <div class="row">
                <div class="col mt-2">
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