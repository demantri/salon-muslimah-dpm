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
                    <div class="card-body">
                        <form action="<?= base_url('laporan/arus_kas')?>" method="post">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" name="bulan">
                                        <option class="text-center" value="" disabled selected>Pilih Bulan</option>
                                        <option class="text-center" value="01">Januari</option>
                                        <option class="text-center" value="02">Februari</option>
                                        <option class="text-center" value="03">Maret</option>
                                        <option class="text-center" value="04">April</option>
                                        <option class="text-center" value="05">Mei</option>
                                        <option class="text-center" value="06">Juni</option>
                                        <option class="text-center" value="07">Juli</option>
                                        <option class="text-center" value="08">Agustus</option>
                                        <option class="text-center" value="09">September</option>
                                        <option class="text-center" value="10">Oktober</option>
                                        <option class="text-center" value="11">November</option>
                                        <option class="text-center" value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="custom-select mr-sm-2" name="tahun" required>
                                        <option class="text-center" value="">Pilih Tahun</option>
                                        <?php for ($i=2020; $i <= 2025 ; $i++) { 
                                            echo '<option class="text-center" value="'.$i.'">'.$i.'</option>';
                                        }?>
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
    <section class="section mt-3" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
        <div class="row">
            <div class="col-md">
                <h4 class="text-center">Salon Muslimah DPM</h4>
                <h4 class="text-center">Buku Besar</h4>
                <h4 class="text-center">
                    Periode
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col mt-2">
                <table class="table table-bordered" style="background-color:white;">
                    <?php 
                    $total_beban = 0;
                    ?>
                    <tr>
                        <th>Pendapatan</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Pendapatan Jasa</td>
                        <td></td>
                        <td><?= $pendapatan_jasa ?></td>
                    </tr>
                    <tr>
                        <th>Beban Usaha</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($beban as $key => $value) {
                        $total_beban += $value->total;
                        echo    '<tr>
                                    <td>'.$value->namaAkun.'</td>
                                    <td>'.number_format($value->total).'</td>
                                    <td></td>
                                </tr>';
                    }?>
                    <tr>
                        <th>Total Beban Operasional</th>
                        <th></th>
                        <th>(<?= number_format($total_beban) ?>)</th>
                    </tr>
                    <tr>
                        <th>Laba Bersih</th>
                        <th></th>
                        <th><?= number_format($pendapatan_jasa-$total_beban) ?></th>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>