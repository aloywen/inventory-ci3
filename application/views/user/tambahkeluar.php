<!-- <?php var_dump($bar); ?> -->

<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <div class="d-flex mb-5 align-items-center">
         
        <a href="<?= base_url('user/barang_keluar') ?>" class="btn btn-primary">< Kembali</a>
        <h1 class="h3 ml-3 mt-2 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-8">

                <?= $this->session->flashdata('message'); ?>
                <?= $this->session->flashdata('nomor'); ?>
                <?= $this->session->flashdata('namabarang'); ?>
                <?= $this->session->flashdata('stok'); ?>
                


            <div class="mt-3">
                <form action="<?= base_url('user/tambahKeluar'); ?>" method="post">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="nomor_transaksi" class="form-label">Nomor Transaksi</label>
                                <input type="text" name="nomor_transaksi" value="<?= set_value('nomor_transaksi'); ?>" class="form-control" id="nomor_transaksi" autocomplete="off">
                                <?= form_error('nomor_transaksi', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="datepicker" class="form-label">Tanggal Transaksi</label>
                                <input type="" name="tgl_keluar" id="datepicker" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                <?= form_error('tgl_keluar', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label">Pelanggan</label>
                                <input type="text" name="pelanggan" id="pelanggan" value="<?= set_value('pelanggan'); ?>" class="form-control" autocomplete="off">
                                <?= form_error('pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                        

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?= set_value('kode_barang'); ?>">
                                <?= form_error('kode_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input data-field-name="nama_barang" type="text" name="nama_barang" id="nama_barang" value="<?= set_value('nama_barang'); ?>" class="form-control js-example-basic-single autoitem" >
                                <?= form_error('nama_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" name="qty" class="form-control" id="qty" value="<?= set_value('qty'); ?>">
                                <?= form_error('qty', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

 
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3"></textarea>
                                <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kirim_by" class="form-label">Kirim Via</label>
                                <input data-field-name="kirim_by" type="text" name="kirim_by" id="kirim_by" value="<?= set_value('kirim_by'); ?>" class="form-control js-example-basic-single autojasa">
                                <?= form_error('kirim_by', '<small class="text-danger pl-3">', '</small>'); ?>
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
