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
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <section class="section" style="background-color: white; padding: 2rem; box-shadow: 1px 2px 3px 1px rgba(0,0,0,0.75); border-radius: 15px;">
        <div class="row">
            <div class="col-lg-10">
                <h4>Transaksi Pembelian Bahan</h4>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-info" href="<?= base_url('user/transaksi/pembelian/form')?>"><i class="fas fa-plus"></i> Tambah Data</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tablemenu">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">ID Transaksi</th>
                                <th class="text-center">Tgl. Transaksi</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Total Transaksi</th>
                                <th class="text-center">Kembalian</th>
                                <th class="text-center">Jumlah Bayar</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        foreach ($pmb as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->id_transaksi ?></td>
                                <td><?= $value->tgl_transaksi ?></td>
                                <td><?= ucwords($value->supplier) ?></td>
                                <td class="text-right"><?= $value->subtotal ?></td>
                                <td class="text-right"><?= $value->kembalian ?></td>
                                <td class="text-right"><?= $value->jumlah_bayar ?></td>
                                <td class="text-center"><?= ($value->status == 'selesai') ? '<span class="badge badge-success">'.ucwords($value->status).'</span>' : '<span class="badge badge-warning">'.ucwords($value->status).'</span>'?></td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-secondary">Detail</button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
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
<script>
    $(document).ready(function() {
        $("#tablemenu").DataTable();
    });

    $(document).on("click", ".edit", function () {
        var id = $(this).data('id');
        var keterangan = $(this).data('keterangan');
        $(".modal-body #id").val( id );
        $(".modal-body #keterangan").val( keterangan );
    });
</script>