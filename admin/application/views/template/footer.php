
  </div> <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer text-sm">
    <strong>Copyright &copy; 2020.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo (base_url()) ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo (base_url()) ?>assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo (base_url()) ?>assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo (base_url()) ?>assets/adminlte/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo (base_url()) ?>assets/adminlte/dist/js/demo.js"></script>



<!-- datatables -->
  <script src="<?php echo (base_url()) ?>assets/datatables2/js/jquery.dataTables.min.js"></script>


  <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootbox/bootbox.js"></script>


  <!-- jquery-confirm  -->
  <script src="<?php echo (base_url("assets/")) ?>jquery-confirm/js/jquery-confirm.min.js"></script>

  <!-- jquery-mask -->
  <script type="text/javascript" src="<?php echo base_url("assets/") ?>jquery_mask/jquery.mask.js"></script>

  <!-- Bootstrap validator -->
  <script src="<?php echo (base_url("assets/")) ?>bootstrap-validator/js/bootstrapValidator.js"></script>

  <!-- jquery-ui -->
  <script src="<?php echo (base_url("assets/")) ?>jquery-ui/jquery-ui-2.js"></script>

  <!-- select2 -->
  <script src="<?php echo (base_url()) ?>assets/select2/js/select2.min.js"></script>

  <!-- CK Editor -->
  <!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
  <script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>

<!-- -------------------------------------------------------------------------------------------PAGE SCRIPTS / buang aja -->
<!-- <script src="<?php echo (base_url()) ?>assets/adminlte/dist/js/pages/dashboard2.js"></script> -->



<script>
        $('.select2').addClass('form-control');
        $('.select2').select2();



        $('.select2_2').addClass('form-control');
        $('.select2_2').select2();

        $('.select2_3').addClass('form-control');
        $('.select2_3').select2();

        $('.select2_4').addClass('form-control');
        $('.select2_4').select2();

        $('.select2_5').addClass('form-control');
        $('.select2_5').select2();

        $('.select2_6').addClass('form-control');
        $('.select2_6').select2();

        $('.select2_7').addClass('form-control');
        $('.select2_7').select2();

        $('.select2_8').addClass('form-control');
        $('.select2_8').select2();
</script>


<script>
    const numberWithCommas = (x) => {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    const untitik = (i) => {
        return typeof i === "string" ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === "number" ?
                                i : 0;
    }

    function format_dollar(valueString)
    {      
      var amount=parseFloat(valueString).toFixed(2);
      var formattedString= amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return formattedString;
    }

    $(".tanggal").mask("00-00-0000", {placeholder:"dd-mm-yyyy"});
    $(".rupiah").mask("000,000,000,000", {reverse: true, placeholder:"000,000,000,000"});
    $('.rupiah').addClass('text-right');
    $(".berat").mask("000,000.00", {reverse: true, placeholder:"000,000.00"});
    $('.berat').addClass('text-right');
    $(".dollar").mask("000,000,000.00", {reverse: true, placeholder:"000,000,000.00"});
    $('.dollar').addClass('text-right');
</script>


<script>

</script>
