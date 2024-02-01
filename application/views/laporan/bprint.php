<html>
    <head>
        <style>
        body {font-family: sans-serif;
            font-size: 10pt;
        }
        p {	margin: 0pt; }
        table.items {
            border: 0.1mm solid #000000;
        }
        td { vertical-align: top; }
        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        table thead td { background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
        }
        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        .items td.totals {
            text-align: center;
            border: 0.1mm solid #000000;
        }
        .items td.cost {
            text-align: "." center;
        }
        </style>
    </head>
    <body>
    
    <htmlpageheader name="myheader">
        <table width="100%">
            <tr>
                <td width="50%" style="color:#0000BB; ">
                <span style="font-weight: bold; font-size: 17pt;">INVENTORY GUDANG PT. Nomina Teknograsi Indodata</span>
                <br />
                <br />
                <h3>Laporan <?= $lap ?></h3>
                <br />
                <h4>Periode <?= $tgl_dari ?> s/d <?= $tgl_sampai ?></h4>
                <br />
                </td>
                
            </tr>
        </table>
    </htmlpageheader>
    <htmlpagefooter name="myfooter">
    <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
    Page {PAGENO} of {nb}
    </div>
    </htmlpagefooter>
    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    
    <br />
    <br />
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top:80px " cellpadding="8">
            <thead>
                <tr>
                <td width="20%">No. Transaksi</td>
                <td width="20%">Tanggal</td>
                <td width="35%">Nama Item</td>
                <td width="25%">Nama Supplier</td>
                <td width="15%">Jumlah</td>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($data as $r) : ?>
                    <tr>
                        <td align="center"><?= $r['nomor_transaksi'];?></td>
                        <td align="center"><?= date('d F Y', strtotime($r['tgl_transaksi'])) ?></td>
                        <td><?= $r['nama_barang']; ?></td>
                        <td><?= $r['supplier']; ?></td>
                        <td class="cost"><?= $r['qty']; ?></td>
                        </tr>
                    <tr>
                <?php endforeach; ?>

                <tr>
                <td class="blanktotal" colspan="3" rowspan="4"></td>
                <td class="totals">Total :</td>
                <td class="totals cost"><?= $total['qty']; ?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>