

<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <div class="d-flex mb-5 align-items-center">
        
        <a href="<?= base_url('user/barang_masuk') ?>" class="btn btn-warning">< Kembali</a>
        <h1 class="h3 ml-3 mt-2 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-8">

                <?= $this->session->flashdata('message'); ?>
                <?= $this->session->flashdata('nomor'); ?>
                <?= $this->session->flashdata('kode');?>
                <?= $this->session->flashdata('namabarang'); ?>
                


            <div class="mt-3">
                <form action="<?= base_url('user/tambahMasuk'); ?>" method="post">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_transaksi" class="form-label">Nomor Transaksi</label>
                                <input type="text" name="nomor_transaksi" class="form-control" id="nomor_transaksi" value="<?= set_value('nomor_transaksi'); ?>" autocomplete="off">
                                <?= form_error('nomor_transaksi', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="datepicker" class="form-label">Tanggal Transaksi</label>
                                    <input type="" name="tgl_transaksi" class="form-control" id="datepicker" value="<?php echo date('Y-m-d'); ?>">
                                    <?= form_error('tgl_transaksi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplier" class="form-label">Supplier</label>
                                <input data-field-name="supplier" value="<?= set_value('supplier'); ?>" type="text" name="supplier" class="form-control js-example-basic-single autosupplier" id="supplier" autocomplete="off">
                                <?= form_error('supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?= set_value('kode_barang'); ?>" autocomplete="off">
                                <?= form_error('kode_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                    

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="nama_barang" type="text" name="nama_barang" id="nama_barang" value="<?= set_value('nama_barang'); ?>" class="form-control js-example-basic-single autoitem" required autocomplete="off">
                        <?= form_error('nama_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" name="qty" value="<?= set_value('qty'); ?>" class="form-control" id="qty" autocomplete="off">
                                <?= form_error('qty', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">+ Tambah Transaksi</button>
                </form>
            </div>
        </div>
    </div>


<!-- /.container-fluid -->

</div>
