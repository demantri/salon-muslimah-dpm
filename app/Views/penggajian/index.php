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
                <h4>Transaksi Penggajian</h4>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#add"> Tambah Data</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tablemenu">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">ID Penggajian</th>
                                <th class="text-center">Tgl. Penggajian</th>
                                <th class="text-center">Nama Pegawai</th>
                                <th class="text-center">Gaji Pokok</th>
                                <th class="text-center">Bonus Service</th>
                                <th class="text-center">Total Service</th>
                                <th class="text-center">Gaji Bersih</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->include('penggajian/add') ?>
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

        $("#pegawai").on("change", function() {
            var value = $(this).val();
            if (value) {
                $.ajax({
                    url: "<?= base_url('Penggajian/detailPegawai')?>",
                    method: "post",
                    data: {
                        kode : value
                    },
                    success:function(response) {
                        $(".div_detail").css("display", "block");

                        var obj = JSON.parse(response);
                        var bonus_service = parseInt(10/100) * obj.total_transaksi_per_pegawai
                        console.log(obj);

                        $("#gapok").val(obj.gapok);
                        $("#jml_service").val(obj.jumlah_service);
                        $("#bonus_service").val(obj.total_transaksi_per_pegawai);
                        $("#gaji_bersih").val(obj.gapok);
                    }
                })
            } else {
                $(".div_detail").css("display", "none");
            }
        });
    });
</script>