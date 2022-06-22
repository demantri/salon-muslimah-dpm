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
                        Filter Laporan Neraca
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" id="jenisBeban1" name="jenisBeban[]">
                                        <option class="text-center" value="" disabled selected>Pilih Bulan</option>
                                        <option class="text-center">Januari</option>
                                        <option class="text-center">Februari</option>
                                        <option class="text-center">Maret</option>
                                        <option class="text-center">April</option>
                                        <option class="text-center">Mei</option>
                                        <option class="text-center">Juni</option>
                                        <option class="text-center">Juli</option>
                                        <option class="text-center">Agustus</option>
                                        <option class="text-center">September</option>
                                        <option class="text-center">Oktober</option>
                                        <option class="text-center">November</option>
                                        <option class="text-center">Desember</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" id="jenisBeban1" name="jenisBeban[]">
                                        <option class="text-center" value="" disabled selected>Pilih Tahun</option>
                                        <option class="text-center">2021</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama CoA</label>
                                <div class="col-sm-4">
                                    <select class="custom-select mr-sm-2" id="jenisBeban1" name="jenisBeban[]">
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
    <section class="section" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
        <div class="row">
            <div class="col-md">
                <h4 class="text-center">Salon Muslimah DPM</h4>
                <h4 class="text-center">Neraca</h4>
            </div>
            <table class="table table-bordered" style="background-color:white;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #eaeaea;" colspan="3" class="text-center">Aktiva</th>
                        <th style="border: 1px solid #eaeaea;" colspan="3" class="text-center">Pasiva</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #eaeaea;" class="text-center">Keterangan</th>
                        <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                        <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                        <th style="border: 1px solid #eaeaea;" class="text-center">Keterangan</th>
                        <th style="border: 1px solid #eaeaea;" class="text-center">Kredit</th>
                        <th style="border: 1px solid #eaeaea;" class="text-center">Debit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #eaeaea; background-color: #eaeaea;">Aktiva Lancar</td>
                        <td colspan="2"></td>
                        <!-- <td>-</td> -->
                        <td style="border: 1px solid #eaeaea; background-color: #eaeaea;">Utang</td>
                        <td colspan="2"></td>
                        <!-- <td>-</td> -->
                    </tr>
                  
                    <tr>
                        <td style="border: 1px solid #eaeaea; background-color: #eaeaea;">Aktiva Tetap</td>
                        <td colspan="2"></td>
                        <!-- <td></td> -->
                        <td style="border: 1px solid #eaeaea; background-color: #eaeaea;">Modal</td>
                        <td colspan="2"></td>
                        <!-- <td>-</td> -->
                    </tr>
                   
                    <thead>
                       
                    </thead>
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
</div>