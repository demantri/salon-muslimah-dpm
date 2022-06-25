<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masterdata Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/user/dashboard/masterdata/product/save" method="post">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="id_product" class="col-sm-3 col-form-label">ID Product</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id_product" name="id_product" placeholder="ID Product" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_product" class="col-sm-3 col-form-label">Nama Product</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_product" name="nama_product" placeholder="Nama Product" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_satuan" class="col-sm-3 col-form-label">Harga Satuan</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="Harga Satuan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-3 col-form-label">Ketegori</label>
                        <div class="col-sm-9">
                            <select name="kategori" id="kategori" class="form-control">
                                <?php foreach ($kategori as $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->keterangan ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stok_akhir" class="col-sm-3 col-form-label">Stok Akhir</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="stok_akhir" name="stok_akhir" min="30" placeholder="Stok Akhir" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="min_stok" class="col-sm-3 col-form-label">Min. Stok</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="min_stok" name="min_stok" min="5" placeholder="Min. Stok" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>