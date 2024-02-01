<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <!-- <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah Barang</a> -->
        <?php
                if($user['role_id'] == 2){
                    echo "<a href='' class='btn btn-primary mb-3' data-toggle=\"modal\" data-target=\"#newRoleModal\">Tambah Barang</a>";
                }
        ?>
        

            <table id="table" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col" class="col-md-4">Nama Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $r['kode_barang']; ?></td>
                        <td class="col-md-4"><?= $r['nama_barang']; ?></td>
                        <td><?= $r['stok']; ?></td>
                        <td>
                        <?php
                            $id = $r['id'];
                                if($user['role_id'] == 2){
                                    echo "<a href='' class='badge badge-success' data-toggle=\"modal\" data-target=\"#editRoleModal$id\">Edit</a>";
                                }
                        ?>
                            
                            <?php
                            $url = base_url('user/hapusProduct/').$r['id'];
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
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/addProduct'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="" autocomplete="off">
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

<?php foreach ($barang as $r) : ?>
<div class="modal fade" id="editRoleModal<?= $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editnewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
           </div>
            <form action="<?= base_url('user/editProduct/') . $r['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $r['kode_barang'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $r['nama_barang'] ?>" autocomplete="off">
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
<?php endforeach ?>