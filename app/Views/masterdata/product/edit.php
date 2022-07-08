<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masterdata Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="product/edit" method="post">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="id_product" class="col-sm-3 col-form-label">ID Product</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id_product_edit" name="id_product" placeholder="ID Product" readonly required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_product" class="col-sm-3 col-form-label">Nama Product</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_product_edit" name="nama_product" placeholder="Nama Product" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_satuan" class="col-sm-3 col-form-label">Harga Satuan</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="harga_satuan_edit" name="harga_satuan" placeholder="Harga Satuan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-3 col-form-label">Ketegori</label>
                        <div class="col-sm-9">
                            <select name="kategori" id="kategori_edit" class="form-control" required>
                                <?php foreach ($kategori as $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->keterangan ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stok_akhir" class="col-sm-3 col-form-label">Stok Akhir</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="stok_akhir_edit" name="stok_akhir" min="30" placeholder="Stok Akhir" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="min_stok" class="col-sm-3 col-form-label">Min. Stok</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="min_stok_edit" name="min_stok" min="5" placeholder="Min. Stok" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak aktif</option>
                            </select>
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