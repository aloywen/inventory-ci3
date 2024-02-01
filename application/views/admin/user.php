<style>
    .datepicker {
      z-index: 9999 !important; /* has to be larger than 1050 */
    }
</style>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah User</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Tanggal Masuk Kerja</th>
                        <th scope="col">Password</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($userr as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $r['name']; ?></td>
                        <td><?= $r['username']; ?></td>
                        <td><?= $r['role']; ?></td>
                        <td><?= date('d F Y', strtotime($r['tgl_masuk_kerja'])); ?></td>
                        <td><?= $r['password']; ?></td>
                        <td>
                            <a href="<?= base_url('admin/roleaccess/') . $r['role_id']; ?>" class="badge badge-warning">access</a>
                            <a href="<?= base_url('admin/editUs/') . $r['id']; ?>" class="badge badge-success">edit</a>
                            <a href="<?= base_url('admin/deleteUser/') . $r['id']; ?>" class="badge badge-danger" onclick="return confirm('yakin dihapus?')">delete</a>
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

<!-- Modal Tambah User-->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/addUser'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Karyawan</label>
                        <input type="text" name="nama" class="form-control" id="nama">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" name="username" class="form-control" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="datepicker" class="form-label">Tanggal Masuk Kerja</label>
                        <input type="" name="tgl_masuk_kerja" class="form-control dat" id="datepicker">
                    </div>
 
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Posisi</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <?php foreach ($rolee as $r) : ?>
                            <option value="<?= $r['uid'] ?>"><?= $r['role'] ?></option>
                            <?php endforeach; ?>
                        </select>
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
