<?php
$judulCard = [
    'Total Product Terjual',
    'Total Penjualan'
];
$volumeCard = [
    '3 pcs',
    'Rp 60.000'
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
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('pesan2')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('pesan2'); ?>
        </div>
    <?php endif; ?>
    <section class="section" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
        <div class="row">
            <div class="col-md-10">
                <h4>Data Pengeluaran Beban</h4>
            </div>
            <!-- <div class="col-md-2">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div> -->
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn-info" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/data-beban"><i class="fas fa-plus"></i> Tambah Data</a>
            </div>
        </div>
        <div class="row">
            <div class="col mt-2">
                <table id="tabelmenu" class="table table-striped table-sm">
                    <!-- <thead>
                        <tr class="text-center" class="text-center">
                            <th class="table-bordered"><a class="text-dark" href="/user/dashboard/pencatatan-kas/pengeluaran/beban" style="text-decoration: none;" style="text-decoration: none;">Beban</a></th>
                            <th class="table-bordered" style="background-color: #eaeaea;"><a class="text-dark" href="#" style="text-decoration: none;">Pembayaran</a></th>
                            <th class="table-bordered"><a class="text-dark" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/history" style="text-decoration: none;">History</a></th>
                        </tr>
                    </thead> -->
                    <!-- <a class="btn btn-light mr-1 mb-2 text-dark" style="background-color: #eaeaea;" href="/user/dashboard/pencatatan-kas/pengeluaran/beban" style="text-decoration: none;">Beban</a>
                    <a class="btn btn-light mr-1 mb-2 text-dark" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/pembayaran" style="text-decoration: none;">Pembayaran</a>
                    <a class="btn btn-light mr-1 mb-2 text-dark" style="background-color: #eaeaea;" href="/user/dashboard/pencatatan-kas/pengeluaran/beban/history" style="text-decoration: none;">History</a> -->
                    <thead>
                        <tr class="text-center" style="background-color: #eaeaea; box-shadow: 2px 1px 3px 0px rgba(0,0,0,0.75);">
                            <th>ID Beban</th>
                            <th>Nama Beban</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataTransaksiBeban->getResult() as $row) : ?>
                            <tr class="text-center">
                                <td><?= $row->akun; ?></td>
                                <td>
                                    <?php foreach ($all_data->getResult() as $row2) : ?>
                                        <?php if ($row2->akun == $row->akun) : ?>
                                            <p><?= $row2->jenisBeban; ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?= $row->tanggalInputBeban; ?>
                                </td>
                                <td>
                                    <form action="/Pencatatan/updateStatusPembayaranBeban/<?= $row->id; ?>" method="post">
                                        <input type="hidden" name="keterangan" value="Beban">
                                        <input type="hidden" name="statusPembayaran" value="Sudah Membayar">
                                        <input type="hidden" id="akun" name="akun" value="<?= $row->akun; ?>">
                                        <input type="hidden" name="tanggalPembayaran" value="<?= date('Y-m-d'); ?>">
                                        <input type="hidden" id="totalBeban" name="totalBeban" value="
                                        <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?= $row2->totalBeban ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        ">
                                        <?php foreach ($statusPembayaranBeban->getResult() as $row2) : ?>
                                            <?php if ($row2->akun == $row->akun) : ?>
                                                <?php if ($row2->statusPembayaran == null) : ?>
                                                    <button type="submit" class="btn btn-outline-warning" id="<?= $row->akun; ?>" onclick="return confirm('Apakah anda yakin?')"><i class="fas fa-money-check-alt"></i></button>
                                                <?php else : ?>
                                                    <span class="badge badge-success">Sudah Bayar</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </form>
                                </td>
                                <td>
                                    <?php foreach ($totalPembelianBeban->getResult() as $row2) : ?>
                                        <?php if ($row2->akun == $row->akun) : ?>
                                            <p><?= $row2->totalBeban ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
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
<!-- Modal -->
<?php foreach ($all_data->getResult() as $row2) : ?>
    <div class="modal fade" id="exampleModal<?= $row2->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Harga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/Pencatatan/updateTotalBeban/<?= $row2->id; ?>" method="post">
                        <div class="form-group">
                            <label for="totalBeban">Harga <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="totalBeban" name="totalBeban" value="<?= $row2->totalBeban ?>">
                        </div>
                        <button class="btn btn-success col"><i class="fas fa-paper-plane"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>