<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card mb-3 col-lg-8">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Nama</p>
                        </div>
                        <div class="col-md-8">
                            <p class="card-text">: <?= $user['name']; ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p>Jabatan</p>
                        </div>
                        <div class="col-md-8">
                            <p class="card-text">: <?= $user['role']; ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p>Tanggal Masuk Kerja</p>
                        </div>
                        <div class="col-md-8">
                            <p class="card-text">:  <?= date('d F Y', strtotime($user['tgl_masuk_kerja'])); ?></p>
                        </div>
                    </div>

                    <a href="<?= base_url('user/edit')?>" class="badge badge-warning text-md p-2" >Ubah Profil</a>
                    <a href="<?= base_url('user/changepassword')?>" class="badge badge-success text-md p-2" >Ganti Password</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 