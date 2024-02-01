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

            <div class="row">
                <div class="col-md-8">
                    <form action="<?= base_url('admin/editUser/') . $userr['id']; ?>" method="post">
                        <div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Karyawan</label>
                                <input type="text" name="name" class="form-control" id="name" value="<?= $userr['name']; ?>">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="username" name="username" class="form-control" id="username" value="<?= $userr['username']; ?>">
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-3">
                                        <?php $selected = $userr['role_id']; 
                                        
                                        ?>
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    
                                        <select name="jabatan" id="jabatan" class="form-control">
        
        
                                            <?php foreach ($rolee as $ro) : ?>
                                                <?php $data = $ro['uid'];?>
                                                <?php $role = $ro['role'];?>
                                                <?php if($selected === $data ) {
                                                    echo "<option value='$data' selected> $role </option>";
                                                } else {
                                                    echo "<option value='$data'> $role </option>";
                                                }
                                                
                                                ?>
        
        
        
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                            <div class="mb-3">
                                <label for="datepicker" class="form-label">Tanggal Masuk Kerja</label>
                                <input type="" name="tgl_masuk_kerja" class="form-control" id="datepicker" value="<?= $userr['tgl_masuk_kerja']; ?>" >
                                <?= form_error('tgl_masuk_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" class="form-control" id="password" value="<?= $userr['password']; ?>">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Edit Profil</button>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>


<!-- /.container-fluid -->

</div>



<!-- Modal Edit -->

