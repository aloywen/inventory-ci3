<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="<?= base_url('user/addKeluar') ?>" class="btn btn-primary mb-3">Tambah Transaksi</a>

            <table id="table" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Transaksi</th>
                        <th scope="col">Tanggal Keluar</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col"></th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $r['nomor_transaksi']; ?></td>
                        <td><?= date('d F Y', strtotime($r['tgl_keluar'])); ?></td>
                        <td><?= $r['nama_barang']; ?></td>
                        <td><?= $r['pelanggan']; ?></td>
                        <td>
                            <a href="<?= base_url('user/editK/').$r['nomor_transaksi'] ?>" class="badge badge-success" >Detail</a>
                            <?php
                            $url = base_url('user/hapusKeluar/').$r['uid'].'/'.$r['nomor_transaksi'].'/'.$r['kode_barang'];
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
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/tambahKeluar'); ?>" method="post">

                <?php
                    $nourut = substr($no_transaksi, 2, 6);
                    $m_record = $nourut + 1;
                ?>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomor_transaksi" class="form-label">Kode Barang</label>
                        <input type="text" name="nomor_transaksi" class="form-control" id="nomor_transaksi" value="KL<?= sprintf("%06s", $m_record) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tgl_keluar" class="form-control" id="exampleFormControlInput1" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" >
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
                        <input data-field-name="nama_barang" type="text" name="nama_barang" id="nama_barang" class="form-control js-example-basic-single autoitem" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">QTY</label>
                        <input type="number" name="qty" class="form-control" id="exampleFormControlInput1" >
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
                <h5 class="modal-title" id="newRoleModalLabel">Edit Barang Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/editKeluar/') . $r['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor_transaksi" class="form-label">Nomor Transaksi</label>
                        <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi" value="<?= $r['nomor_transaksi'] ?>" readonly>
                    </div> 
                    <div class="form-group">
                        <label for="temp" class="form-label">Kode Barang</label>
                        <input type="hidden" class="form-control" id="temp" name="temp" value="<?= $r['kode_barang'] ?>">
                        <input type="text" class="form-control" id="kode_b" name="kode_barang" value="<?= $r['kode_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input data-field-name="barang" type="text" class="form-control js-example-basic-single autoiteme" id="nama_barang" name="nama_barang" value="<?= $r['nama_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="hidden" class="form-control" id="tempQty" name="tempQty" value="<?= $r['qty'] ?>">
                        <input type="text" class="form-control" id="qty" name="qty" value="<?= $r['qty'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tgl_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar" value="<?= $r['tgl_keluar'] ?>">
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
