<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <h5 class="mt-4">Tentukan Filter Laporan :</h5>

            <form action="<?= base_url('user/print'); ?>" method="post" target="_blank">

                <div class="row mt-3">
                    <div class="col-md-3 d-flex flex-column"> 
                        <label for="datepicker">Periode</label>
                        <input type="" class="form-control" name="tgl_dari" id="datpicker" autocomplete="off"> 
                    </div>
                    <div class="col-md-3 d-flex flex-column"> 
                        <label for="datepicker">s/d</label>
                        <input type="" class="form-control" name="tgl_sampai" id="datepicker"  autocomplete="off"> 
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lap">Pilih Laporan</label>
                            <select name="lap" class="form-control" id="lap">
                                <option value="Barang Masuk">Barang Masuk</option>
                                <option value="Barang Keluar">Barang Keluar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Proses</button>
            </from>
        </div>
    </div>


<!-- /.container-fluid -->

</div>
