<!-- <div class="container-fluid mb-5"> -->

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="<?= base_url('user/barang_keluar') ?>" class="btn btn-primary mb-3">Kembali</a>

            <form action="<?= base_url('user/editKeluar/') . $barang['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor_trans" class="form-label">Nomor Transaksi</label>
                        <input type="text" class="form-control" id="nomor_trans" name="nomor_transaksi" value="<?= $barang['nomor_transaksi'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kode_b" class="form-label">Kode Barang</label>
                        <input type="hidden" class="form-control" id="temp" name="temp" value="<?= $barang['kode_barang'] ?>">
                        <input type="text" class="form-control" id="kode_b" name="kode_barang" value="<?= $barang['kode_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="barang" type="text" class="form-control js-example-basic-single autoiteme" id="nama_barang" name="nama_barang" value="<?= $barang['nama_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="barang" type="text" class="form-control js-example-basic-single autoiteme" id="nama_barang" name="nama_barang" value="<?= $barang['nama_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tempQty" class="form-label">Qty</label>
                        <input type="hidden" class="form-control" id="tempQty" name="tempQty" value="<?= $barang['qty'] ?>">
                        <input type="text" class="form-control" id="qty" name="qty" value="<?= $barang['qty'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tgl_keluar" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar" value="<?= $barang['tgl_keluar'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>

        </div>
    </div> -->


<!-- /.container-fluid -->

<!-- </div> -->




<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <div class="d-flex mb-5 align-items-center">
        
        <a href="<?= base_url('user/barang_keluar') ?>" class="btn btn-primary">< Kembali</a>
        <h1 class="h3 ml-3 mt-2 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

                <?= $this->session->flashdata('message'); ?>
                <?= $this->session->flashdata('nomor'); ?>
                <?= $this->session->flashdata('namabarang'); ?>
                <?= $this->session->flashdata('stok'); ?>


            <div class="mt-3">
                <form action="<?= base_url('user/editKeluar/') . $barang['uid']; ?>" method="post">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="nomor_transaksi" class="form-label">Nomor Transaksi</label>
                                <input type="hidden" name="tempno" class="form-control" id="tempno" value="<?= $barang['nomor_transaksi'] ?>">
                                <input type="text" name="nomor_transaksi" class="form-control" id="nomor_transaksi" value="<?= $barang['nomor_transaksi'] ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="datepicker" class="form-label">Tanggal Transaksi</label>
                                <input type="" name="tgl_keluar" class="form-control" id="datepicker" value="<?= $barang['tgl_keluar'] ?>">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label">Pelanggan</label>
                                <input type="text" name="pelanggan" id="pelanggan" value="<?= $barang['pelanggan'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                        

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
                                <input type="hidden" name="tempKode_barang" class="form-control" id="tempKode_barang" value="<?= $barang['kode_barang'] ?>" >
                                <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?= $barang['kode_barang'] ?>" >
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
                                <input data-field-name="nama_barang" type="text" name="nama_barang" id="nama_barang" class="form-control js-example-basic-single autoitem" value="<?= htmlentities($barang['nama_barang']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="hidden" name="tempQty" class="form-control" value="<?= $barang['qty'] ?>" id="tempQty" >
                                <input type="number" name="qty" class="form-control" value="<?= $barang['qty'] ?>" id="qty" >
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" cols="30"  rows="3"><?= $barang['alamat'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <!-- <?php $selected = $barang['kirim_by']; 
                                
                                ?> -->
                            <label for="kirim_by" class="form-label">Kirim Via</label>
                            <input data-field-name="kirim_by" type="text" name="kirim_by" id="kirim_by" value="<?= $barang['kirim_by'] ?>" class="form-control js-example-basic-single autojasa">
                            </div>
                        </div>
                    </div>

                        

                        <button type="submit" class="btn btn-success">Edit Transaksi</button>
                </form>
            </div>
        </div>
    </div>


<!-- /.container-fluid -->

</div>

