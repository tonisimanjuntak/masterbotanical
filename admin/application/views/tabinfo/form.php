<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">3 Tab Info</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active" id="lblactive">3 Tab Info</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('tabinfo/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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
                    <div class="col-4">
                      <div class="card">
                        <div class="card-body">
                              

                              <h1>Tab Info 1</h1><hr>
                              <div class="form-group">
                                <label for="">Icon</label>
                                <select name="tab1icon" id="tab1icon" class="form-control select2">
                                  <option value="">Pilih icon...</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Judul</label>
                                <input type="text" name="tab1judul" id="tab1judul" class="form-control" placeholder="Judul" value="<?php echo $rowtabinfo->tab1judul ?>">
                              </div>


                              <div class="form-group">
                                <label for="">Deskripsi <span class="text-info text-sm"> (max 255 Karakter)</span></label>
                                <textarea name="tab1deskripsi" id="tab1deskripsi" class="form-control" rows="5" placeholder="Deskripsi" maxlength="255"><?php echo $rowtabinfo->tab1deskripsi ?></textarea>
                              </div>


                              <div class="form-group">
                                <label for="">Page Link <span class="text-info text-sm"> (Optional)</span></label>
                                <select name="tab1idpage" id="tab1idpage" class="form-control select2">
                                  <option value="">Tidak ada link---</option>
                                  <?php  
                                    $rspage = $this->db->query("select * from pages where ispublish='Ya' order by judulpage");
                                    if ($rspage->num_rows()>0) {
                                      
                                      foreach ($rspage->result() as $row) {
                                        $selected = '';
                                        if ($row->idpage==$rowtabinfo->tab1idpage) {
                                          $selected = 'selected="selected"';
                                        }

                                        echo '
                                            <option value="'.$row->idpage.'" '.$selected.'>'.$row->judulpage.'</option>
                                        ';
                                      }

                                    }
                                  ?>
                                </select>
                              </div>


                        </div>
                      </div>
                    </div>


                    <!-- ***************************  Tab info 2*********************************************  -->
                    <div class="col-4">
                      <div class="card">
                        <div class="card-body">
                              

                              <h1>Tab Info 2</h1><hr>
                              <div class="form-group">
                                <label for="">Icon</label>
                                <select name="tab2icon" id="tab2icon" class="form-control select2">
                                  <option value="">Pilih icon...</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Judul</label>
                                <input type="text" name="tab2judul" id="tab2judul" class="form-control" placeholder="Judul" value="<?php echo $rowtabinfo->tab2judul ?>">
                              </div>


                              <div class="form-group">
                                <label for="">Deskripsi <span class="text-info text-sm"> (max 255 Karakter)</span></label>
                                <textarea name="tab2deskripsi" id="tab2deskripsi" class="form-control" rows="5" placeholder="Deskripsi" maxlength="255"><?php echo $rowtabinfo->tab2deskripsi ?></textarea>
                              </div>


                              <div class="form-group">
                                <label for="">Page Link <span class="text-info text-sm"> (Optional)</span></label>
                                <select name="tab2idpage" id="tab2idpage" class="form-control select2">
                                  <option value="">Tidak ada link---</option>
                                  <?php  
                                    $rspage = $this->db->query("select * from pages where ispublish='Ya' order by judulpage");
                                    if ($rspage->num_rows()>0) {
                                      
                                      foreach ($rspage->result() as $row) {
                                        $selected = '';
                                        if ($row->idpage==$rowtabinfo->tab2idpage) {
                                          $selected = 'selected="selected"';
                                        }

                                        echo '
                                            <option value="'.$row->idpage.'" '.$selected.'>'.$row->judulpage.'</option>
                                        ';
                                      }

                                    }
                                  ?>
                                </select>
                              </div>


                        </div>
                      </div>
                    </div>

                    <!-- ***************************  Tab info 3*********************************************  -->
                    <div class="col-4">
                      <div class="card">
                        <div class="card-body">
                              

                              <h1>Tab Info 3</h1><hr>
                              <div class="form-group">
                                <label for="">Icon</label>
                                <select name="tab3icon" id="tab3icon" class="form-control select2">
                                  <option value="">Pilih icon...</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Judul</label>
                                <input type="text" name="tab3judul" id="tab3judul" class="form-control" placeholder="Judul" value="<?php echo $rowtabinfo->tab3judul ?>">
                              </div>


                              <div class="form-group">
                                <label for="">Deskripsi <span class="text-info text-sm"> (max 255 Karakter)</span></label>
                                <textarea name="tab3deskripsi" id="tab3deskripsi" class="form-control" rows="5" placeholder="Deskripsi" maxlength="255"><?php echo $rowtabinfo->tab3deskripsi ?></textarea>
                              </div>


                              <div class="form-group">
                                <label for="">Page Link <span class="text-info text-sm"> (Optional)</span></label>
                                <select name="tab3idpage" id="tab3idpage" class="form-control select2">
                                  <option value="">Tidak ada link---</option>
                                  <?php  
                                    $rspage = $this->db->query("select * from pages where ispublish='Ya' order by judulpage");
                                    if ($rspage->num_rows()>0) {
                                      
                                      foreach ($rspage->result() as $row) {
                                        $selected = '';
                                        if ($row->idpage==$rowtabinfo->tab3idpage) {
                                          $selected = 'selected="selected"';
                                        }

                                        echo '
                                            <option value="'.$row->idpage.'" '.$selected.'>'.$row->judulpage.'</option>
                                        ';
                                      }

                                    }
                                  ?>
                                </select>
                              </div>


                        </div>
                      </div>
                    </div>





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

<script src="<?php echo base_url(); ?>assets/font-awesome-v5-listing-all.js"></script>


<script type="text/javascript">

  // console.log(fontAwesomeIcon);

  $(document).ready(function() {

    $('.select2').select2({
      templateResult: formatState,
      templateSelection: formatState
    });

    $.each(fontAwesomeIcon['icons'], function(index, val) {
       // console.log(val);
       $('#tab1icon')
          .append($('<option>', { value : val })
          .text(val)
          .attr('data-image', val));

        var tab1icon = "<?php echo $rowtabinfo->tab1icon ?>";
        if (tab1icon==val) {
          console.log(val);
          $('#tab1icon').val(val).trigger('change');
        }


      $('#tab2icon')
          .append($('<option>', { value : val })
          .text(val)
          .attr('data-image', val));

        var tab2icon = "<?php echo $rowtabinfo->tab2icon ?>";
        if (tab2icon==val) {
          console.log(val);
          $('#tab2icon').val(val).trigger('change');
        }

      $('#tab3icon')
          .append($('<option>', { value : val })
          .text(val)
          .attr('data-image', val));

        var tab3icon = "<?php echo $rowtabinfo->tab3icon ?>";
        if (tab3icon==val) {
          console.log(val);
          $('#tab3icon').val(val).trigger('change');
        }


    });

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
        tab1judul: {
          validators:{
            notEmpty: {
                message: "judul tidak boleh kosong"
            },
          }
        },
        tab1deskripsi: {
          validators:{
            notEmpty: {
                message: "deskripsi tidak boleh kosong"
            },
          }
        },
        tab2icon: {
          validators:{
            notEmpty: {
                message: "gambar icon tidak boleh kosong"
            },
          }
        },
        tab2judul: {
          validators:{
            notEmpty: {
                message: "judul tidak boleh kosong"
            },
          }
        },
        tab2deskripsi: {
          validators:{
            notEmpty: {
                message: "deskripsi tidak boleh kosong"
            },
          }
        },
        tab3icon: {
          validators:{
            notEmpty: {
                message: "gambar icon tidak boleh kosong"
            },
          }
        },
        tab3judul: {
          validators:{
            notEmpty: {
                message: "judul tidak boleh kosong"
            },
          }
        },
        tab3deskripsi: {
          validators:{
            notEmpty: {
                message: "deskripsi tidak boleh kosong"
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


  function formatState (opt) {
      if (!opt.id) {
          return opt.text;
      } 

      var optimage = $(opt.element).attr('data-image'); 
      // console.log(optimage)
      if(!optimage){
         return opt.text;
      } else {                    
          var $opt = $(
             '<span><i class="'+optimage+'"></i> '+opt.text+'</span>'
          );
          return $opt;
      }
  };
</script>

</body>
</html>
