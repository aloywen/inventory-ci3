<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

                <?= $this->session->flashdata('message'); ?>
                <?= $this->session->flashdata('nomor'); ?>
                <?= $this->session->flashdata('kode');?>
                <?= $this->session->flashdata('namabarang'); ?>

        <!-- <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah Barang</a> -->

            <form action="<?= base_url('user/editMasuk/') . $barang['uid']; ?>" method="post">
                <!-- <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor_trans" class="form-label">Nomor Transaksi</label>
                        <input type="hidden" class="form-control" id="tempno" name="tempno" value="<?= $barang['nomor_transaksi'] ?>">
                        <input type="text" class="form-control" id="nomor_trans" name="nomor_transaksi" value="<?= $barang['nomor_transaksi'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input data-field-name="supplier" type="text" class="form-control js-example-basic-single autosupplier" id="supplier" name="supplier" value="<?= $barang['supplier'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="hidden" class="form-control" id="temp" name="temp" value="<?= $barang['kode_barang'] ?>">
                        <input type="text" class="form-control" id="kode_bar" name="kode_barang" value="<?= $barang['kode_barang'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="barang" type="text" class="form-control js-example-basic-single autoitemedit" id="nama_barang" name="nama_barang" value="<?= $barang['nama_barang'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="tempQty" class="form-label">Qty</label>
                        <input type="hidden" class="form-control" id="tempQty" name="tempQty" value="<?= $barang['qty'] ?>">
                        <input type="text" class="form-control" id="qty" name="qty" value="<?= $barang['qty'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="datepicker" class="form-label">Tanggal Transaksi</label>
                        <input type="" class="form-control" id="datepicker" name="tgl_transaksi" value="<?= $barang['tgl_transaksi'] ?>" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div> -->

                <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                            <label for="nomor_trans" class="form-label">Nomor Transaksi</label>
                            <input type="hidden" class="form-control" id="tempno" name="tempno" value="<?= $barang['nomor_transaksi'] ?>">
                            <input type="text" class="form-control" id="nomor_trans" name="nomor_transaksi" value="<?= $barang['nomor_transaksi'] ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="datepicker" class="form-label">Tanggal Transaksi</label>
                                <input type="" class="form-control" id="datepicker" name="tgl_transaksi" value="<?= $barang['tgl_transaksi'] ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplier" class="form-label">Supplier</label>
                                <input data-field-name="supplier" type="text" class="form-control js-example-basic-single autosupplier" id="supplier" name="supplier" value="<?= $barang['supplier'] ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="hidden" class="form-control" id="temp" name="temp" value="<?= $barang['kode_barang'] ?>">
                                <input type="text" class="form-control" id="kode_bar" name="kode_barang" value="<?= $barang['kode_barang'] ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="barang" type="text" class="form-control js-example-basic-single autoitemedit" id="nama_barang" name="nama_barang" value="<?= htmlentities($barang['nama_barang']) ?>" autocomplete="off">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tempQty" class="form-label">Qty</label>
                                <input type="hidden" class="form-control" id="tempQty" name="tempQty" value="<?= $barang['qty'] ?>">
                                <input type="text" class="form-control" id="qty" name="qty" value="<?= $barang['qty'] ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Edit</button>
            </form>

        </div>
    </div>


<!-- /.container-fluid -->

</div>
