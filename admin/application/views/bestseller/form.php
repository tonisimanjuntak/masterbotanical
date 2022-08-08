<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Best Seller Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active" id="lblactive">Best Seller Produk</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('bestseller/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-body">

                  <div class="col-md-12">
                    <?php
$pesan = $this->session->flashdata("pesan");
if (!empty($pesan)) {
    echo $pesan;
}
?>
                  </div>

                  <div class="row">

                    <!-- ***************************  Tab info 1*********************************************  -->

                    <?php  
                      if ($rsbestseller->num_rows()>0) {
                        foreach ($rsbestseller->result() as $rowbestseller) { 
                          if (!empty($rowbestseller->gambarproduk)) {
                              $gambarproduk = base_url('../uploads/produk/'.$rowbestseller->gambarproduk);
                          }else{
                              $gambarproduk = base_url('../images/nofoto.png');
                          }

                          $checked ='';
                          if (!empty($rowbestseller->idprodukbestseller)) {
                            $checked ='checked="checked"';
                          }
                      ?>
                         


                          <div class="col-3">
                            <div class="card">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="isbestseller[]" id="<?php echo 'checkbox'.$rowbestseller->idproduk ?>" value="<?php echo $rowbestseller->idproduk ?>" <?php echo $checked ?>>
                                      <label class="form-check-label" for="<?php echo 'checkbox'.$rowbestseller->idproduk ?>">Best Seller</label>
                                    </div>
                                  </div>
                                  <div class="col-md-12 p-1 text-center">
                                    <img src="<?php echo $gambarproduk ?>" alt="" style="width: 80%; height: 100px;">                                    
                                  </div>
                                  <div class="col-12 text-center">
                                    <strong><?php echo $rowbestseller->namaproduk ?></strong>
                                  </div>
                                  <div class="col-12 text-center">
                                    <?php echo $rowbestseller->namajenis ?>
                                  </div>
                                  <div class="col-12 text-center">
                                    <strong>Harga Mulai Dari $<?php echo $rowbestseller->lowestprice ?></strong>
                                  </div>
                                </div>



                              </div>
                            </div>
                          </div>

                    <?php    }
                      }
                    ?>






                  </div>

                  

                  

              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
      </form>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->


<?php $this->load->view("template/footer")?>



<script type="text/javascript">

  // console.log(fontAwesomeIcon);

  $(document).ready(function() {

    $('.select2').select2();


    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        tab1icon: {
          validators:{
            notEmpty: {
                message: "gambar icon tidak boleh kosong"
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    //$("#jumlah").mask("000,000,000,000", {reverse: true});
  }); //end (document).ready


</script>

</body>
</html>
