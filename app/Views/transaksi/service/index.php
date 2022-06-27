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
                <h4>Transaksi Service</h4>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-info" href="<?= base_url('user/transaksi/service/form')?>"><i class="fas fa-plus"></i> Tambah Data</a>
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
                                <th class="text-center">Nama Pelanggan</th>
                                <th class="text-center">Jenis Pesan</th>
                                <th class="text-center">Jenis Pelayanan</th>
                                <th class="text-center">Diskon</th>
                                <th class="text-center">Total Transaksi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($tb_serivce as $item) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->id_transaksi ?></td>
                                <td><?= $item->tgl_transaksi ?></td>
                                <td><?= $item->nama_pelanggan ?></td>
                                <td><?= $item->jenis_pesan ?></td>
                                <td><?= $item->jenis_pelayanan ?></td>
                                <td><?= $item->diskon ?></td>
                                <td><?= $item->subtotal ?></td>
                                <td class="text-center">
                                    <?php
                                    if ($item->status == 'belum bayar') {
                                        # code...
                                        echo '<button type="button" class="btn btn-primary btn-sm bayar" data-toggle="modal" data-target="#bayar" data-id="'.$item->id_transaksi.'" data-total-bayar="'.$item->subtotal.'">Bayar</button>';
                                    } else {
                                        # code...
                                        echo '<button type="button" class="btn btn-success btn-sm"> Sudah Bayar</button>';
                                    }
                                    
                                    ?>
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
<?= $this->include('transaksi/service/bayar'); ?>
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
        $("#kembalian").val(0);
        $("#jumlah_bayar").on("keyup", function() {
            var jumlah_bayar = $(this).val();
            console.log(jumlah_bayar)
            var total = $("#total_transaksi").val();
            var kembalian = jumlah_bayar - total;

            let info = `<i>jumlah bayar harus sama atau lebih dari total transaksi.</i>`;
            $("#info").html(info);
            
            if (jumlah_bayar) {
                if (kembalian >= 0) {
                    $("#kembalian").val(kembalian);
                    $("#btn-simpan").prop("disabled", false);
                    $("#info").hide();
                } else {
                    $("#kembalian").val(kembalian);
                    $("#btn-simpan").prop("disabled", true);
                    $("#info").show();
                }
            } else {
                $("#btn-simpan").prop("disabled", true);
                $("#info").show();
            }
        });
    });

    $(document).on("click", ".bayar", function () {
        var id = $(this).data('id');
        var total_transaksi = $(this).data('total-bayar');
        $(".modal-body #id_transaksi").val(id);
        $(".modal-body #total_transaksi").val(total_transaksi);
    });
</script>