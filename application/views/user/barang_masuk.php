<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>
        <?= $this->session->flashdata('nomor'); ?>

        <a href="<?= base_url('user/addMasuk') ?>" class="btn btn-primary mb-3">Tambah Transaksi</a>

            <table id="table" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Transaksi</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Qty</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $r['nomor_transaksi']; ?></td>
                        <td><?= date('d F Y', strtotime($r['tgl_transaksi'])); ?></td>
                        <td><?= $r['supplier']; ?></td>
                        <td><?= $r['nama_barang']; ?></td>
                        <td><?= $r['qty']; ?></td>
                        <td>
                        <?php
                        $url = base_url('user/editM/').$r['nomor_transaksi'];
                        if($user['role_id'] == 2){
                            echo "<a href='$url' class='badge badge-success' >Detail</a>";
                        }
                        ?>
                            <?php
                            $url = base_url('user/hapusMasuk/').$r['uid'].'/'. $r['nomor_transaksi'].'/'. $r['kode_barang'];
                            if($user['role_id'] == 2){
                                echo "<a href='$url' class='badge badge-danger' onclick=\"return confirm('yakin dihapus?')\">Hapus</a>";
                            }
                            
                            ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div> 
    </div>


<!-- /.container-fluid -->

</div>
 
<!-- Modal Tambah Barang-->
<div class="modal fade" id="newRoleModal" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="RoleModal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/tambahMasuk'); ?>" method="post">

                <div class="modal-body">
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_transaksi" class="form-label">Nomor Transaksi</label>
                                <input type="text" name="nomor_transaksi" class="form-control" id="nomor_transaksi" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="datepicker" class="form-label">Tanggal Transaksi</label>
                                    <input type="" name="tgl_transaksi" class="form-control" id="datepicker" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplier" class="form-label">Supplier</label>
                                <input data-field-name="supplier" type="text" name="supplier" class="form-control js-example-basic-single autosupplier" id="supplier" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" class="form-control" id="kode_barang" >
                            </div>
                        </div>
                    </div>
                    

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="nama_barang" type="text" name="nama_barang" id="nama_barang" class="form-control js-example-basic-single autoitem" required autocomplete="off">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" name="qty" class="form-control" id="qty" autocomplete="off">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div> 

 
<!-- Modal Edit -->

<!-- <?php foreach ($barang as $r) : ?>
<div class="modal fade" id="editRoleModal<?= $r['id'] ?>" tabindex="1" role="dialog" aria-labelledby="editnewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Edit Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/editMasuk/') . $r['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor_trans" class="form-label">Nomor Transaksi</label>
                        <input type="text" class="form-control" id="nomor_trans" name="nomor_transaksi" value="<?= $r['nomor_transaksi'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input data-field-name="supplier" type="text" class="form-control js-example-basic-single autosupplier" id="supplier" name="supplier" value="<?= $r['supplier'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="hidden" class="form-control" id="temp" name="temp" value="<?= $r['kode_barang'] ?>">
                        <input type="text" class="form-control" id="kode_bar" name="kode_barang" value="<?= $r['kode_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="barang" type="text" class="form-control js-example-basic-single autoitemedit" id="nama_barang" name="nama_barang" value="<?= $r['nama_barang'] ?>" data-id="<?= $r['nomor_transaksi'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty" value="<?= $r['qty'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" value="<?= $r['tgl_transaksi'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div> 
<?php endforeach ?> -->
