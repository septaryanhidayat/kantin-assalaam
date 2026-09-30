<?php $this->extend('admin/template'); ?>

<?php $this->section('css') ?>
<style>
  .otp-input-wrapper {
  width: 350px;
  text-align: left;
  display: inline-block;
}
.otp-input-wrapper input {
  padding: 0;
  width: 360px;
  font-size: 32px;
  font-weight: 600;
  color: #3e3e3e;
  background-color: transparent;
  border: 0;
  margin-left: 12px;
  letter-spacing: 48px;
  font-family: sans-serif !important;
}
.otp-input-wrapper input:focus {
  box-shadow: none;
  outline: none;
}
.otp-input-wrapper svg {
  position: relative;
  display: block;
  width: 350px;
  height: 2px;
}

</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18"><?= $title ?></h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Aplikasi Kantin</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Masukkan atau Scan ID/Kode Siswa</h5>
                    <form action="" method="post">
                        <input type="hidden" name="id_transaksi" value="<?= $transaksi_aktif->id ?>">
                        <input type="text" name="kode" class="form-control" placeholder="Masukkan ID/Kode siswa dan tekan Enter" autofocus>
                    </form><br />
                    <h5 class="mb-4">Masukkan PIN Transaksi</h5>
                    <form action="" method="post">
                        <div class="otp-input-wrapper">
                            <input type="hidden" name="id_transaksi" value="<?= $transaksi_aktif->id ?>">
                            <input type="password" maxlength="6" pattern="[0-9]*" autocomplete="off" name="pin" id="pin" autofocus>
                            <svg viewBox="0 0 240 1" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0" y1="0" x2="240" y2="0" stroke="#3e3e3e" stroke-width="2" stroke-dasharray="33,8" />
                            </svg>
                        </div>
                        <!--<input type="text" name="pin" id="pin" class="form-control" placeholder="Masukkan PIN siswa" autofocus>-->
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Detail Pembelian</h5>
                    <?php if (!empty($siswa)) : ?>
                    <div class="alert alert-warning" role="alert">
                        <table width="100%">
                            <tr>
                                <td>No. Transaksi</td>
                                <td align="right"><?= nomor_transaksi($transaksi_aktif->no_transaksi) ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td align="right"><?= $siswa->nama ?></td>
                            </tr>
                        </table>
                    </div>
                    <?php endif ?>
                    <hr>
                    <table width="100%">
                        <tr>
                            <th style="border-bottom: 1px dashed #ddd;">Produk</th>
                            <th style="border-bottom: 1px dashed #ddd;">Jml.</th>
                            <th style="border-bottom: 1px dashed #ddd;" class="text-end">Sub Total</th>
                        </tr>
                        <?php $total = 0 ?>
                        <?php foreach ($transaksi_detail as $detail) : ?>
                            <tr>
                                <td><?= $detail->barang ?></td>
                                <td width="50">x<?= $detail->jumlah ?></td>
                                <td align="right" width="70"><?= number_format($detail->jumlah * $detail->harga, 0, ',', '.') ?></td>
                            </tr>
                            <?php $total += ($detail->jumlah * $detail->harga) ?>
                        <?php endforeach ?>
                        <tr>
                            <td colspan="2" style="border-top: 1px dashed #ddd;">TOTAL</td>
                            <td align="right" style="border-top: 1px dashed #ddd;"><?= number_format($total, 0, ',', '.') ?></td>
                        </tr>
                        <?php if (!empty($siswa)) : ?>
                            <tr>
                                <td colspan="2">SALDO</td>
                                <td align="right" style="border-bottom: 1px dashed #ddd;"><?= number_format($siswa->saldo, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">SISA SALDO</td>
                                <td align="right"><?= number_format($siswa->saldo - $total, 0, ',', '.') ?></td>
                            </tr>
                        <?php endif ?>
                    </table>
                    <hr>
                    <?php if (!empty($siswa)) : ?>
                        <?php if ($siswa->saldo >= $total) : ?>
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('petugas/transaksi/bayar/' . session()->get('trx') . '/' . $transaksi_aktif->id) ?>" class="btn btn-success" style="display:none" id="bayar">BAYAR</a>
                            </div>
                        <?php else : ?>
                            <div class="d-grid gap-2">
                                <div class="alert alert-danger">SALDO TIDAK CUKUP</div>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('petugas/transaksi/aktif/' . $transaksi_aktif->id) ?>" class="btn btn-info mt-3">KEMBALI</a>
                        <a href="<?= base_url('petugas/transaksi/delete/' . $transaksi_aktif->id) ?>" onclick="return confirm('Yakin?')" class="btn btn-danger mt-2">HAPUS TRANSAKSI INI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script type="text/javascript">
  $(document).ready(function() {
  // cek no dokumen
  $('#pin').keyup(function(){
     if ($(this).val().length == 6){
        var pin = $(this).val()
      // Kirim data ke controller MyTable dengan AJAX
      $.ajax({
        url: "<?php echo base_url('petugas/transaksi/cek_pin') ?>",
        type: "POST",
        dataType: "JSON",
        data: {pin:pin},
        success: function(data) {
          if (data == false) {
            $('#bayar').hide();
            Swal.fire('PIN Salah!','Gagal');
            $('#pin').val();
          }else {
            $('#bayar').show();
          }  
        }
      });   
    }
    })
  });
</script>

<?php $this->endSection() ?>