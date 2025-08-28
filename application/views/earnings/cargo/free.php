<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="withdraw-money-container">
                    <h2 class="title">
                        Normal Kargo Ayarları
                    </h2>
                    <?php echo form_open('withdraw-money-post'); ?>


                    <div class="form-group">
                        <label>Durum</label>
                        <select name="status" class="form-control" id="">
                            <option value="0">Devredışı</option>
                            <option value="1">Aktif</option>

                        </select>
                    </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light w-100">
                            <i class="bx bx-check-double label-icon"></i>
                            Kaydet
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- Wrapper End-->

<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    $(document).ready(function() {
        $('#para-birimleri').DataTable();
    });
    $(document).ready(function() {
        $('#teslimat-suresi').DataTable();
    });
    $(document).ready(function() {
        $('#kargo').DataTable();
    });
</script>