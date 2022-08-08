<?php  
    $this->load->view('template/header');
    $this->load->view('template/topmenu');
    // $this->load->view('template/ui-theme-settings');
    $this->load->view('template/sidemenu');
?>        


<div class="app-main__outer">
    <div class="app-main__inner">

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="text-info" id="icon-header">
                        </i>
                    </div>
                    <div id="page-title">Tambah Data Jurnal Penyesuaian</div>
                </div>
                <div class="page-title-actions">
                    <a href="<?php echo(site_url('jurnalpenyesuaian')) ?>" class="btn-wide btn btn-gradient-warning btn-pill btn-shadow btn-sm"><i class="fa fa-chevron-left mr-2"></i>Kembali</a>
                </div>    
            </div>
        </div> <!-- app-page-title -->


        <div class="tabs-animation">

            
            <form action="<?php echo(site_url('Jurnalpenyesuaian/simpan')) ?>" id="form" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card bg-light">
                      <div class="card-body p-2">
                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="">Id Jurnal</label>
                              <input type="text" id="idjurnal" name="idjurnal" class="form-control form-control-sm" placeholder="Id Jurnal (Otomatis)" readonly="">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group required">
                              <label for="">Tgl Jurnal</label>
                              <input type="text" id="tgljurnal" name="tgljurnal" class="form-control form-control-sm" value="<?php echo(date('d-m-Y')) ?>">
                            </div>
                          </div>
                          <div class="col-md-1"></div>
                          <div class="col-md-7">
                            <div class="row">
                              <label for="" class="col-md-3 text-right">Deskripsi</label>
                              <div class="col-md-9">
                                <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" rows="2" autofocus=""></textarea>
                                
                              </div>
                              
                            </div>
                          </div>                                  
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-12 mt-3">
                    <div class="table-responsive">
                        <table id="table" class="display" style="width:100%;">
                          <thead class="text-light" style="background-color:#055F93;">
                              <tr class="th-jurnal">
                                  <th style="text-align: center;">Akun</th>
                                  <th style="text-align: center; width: 20%;">Debet (Rp.)</th>
                                  <th style="text-align: center; width: 20%;">Kredit (Rp.)</th>
                                  <th style="text-align: center; width: 5%;">#</th>                        
                              </tr>
                          </thead>
                          <tbody>
                              
                              
                          </tbody>
                          </table>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12"><hr></div>
                      <div class="col-md-4">
                          <span class="btn btn-sm btn-success" id="addrow"><i class="fa fa-plus"></i> Tambah Baris (F2)</span>
                      </div>
                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="input-group input-group-sm">
                              <div class="input-group-prepend" style="font-weight: bold;">
                                <span class="input-group-text text-light" style="background-color:#055F93;">Total Debet (Rp.)</span>
                              </div>
                              <input type="text" class="form-control text-right font-weight-bold" name="totaldebet" readonly="" id="totaldebet">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="input-group input-group-sm">
                              <div class="input-group-prepend" style="font-weight: bold;">
                                <span class="input-group-text text-light" style="background-color:#055F93;">Total Kredit (Rp.)</span>
                              </div>
                              <input type="text" class="form-control text-right font-weight-bold" name="totalkredit" readonly="" id="totalkredit">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 text-right d-block p-3 mt-4">
                      
                            <a href="<?php echo(site_url('jurnalpenyesuaian')) ?>" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-gradient-warning btn-lg"><i class="fa fa-chevron-left mr-2"></i>Kembali</a>
                            <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-gradient-info btn-lg">
                                <span class="mr-1">Simpan</span>
                                <span class="mr-2 opacity-7">
                                    <i class="fa fa-save"></i>
                                </span>
                            </button>

                  </div>


                </div>
              </form>    

            
            
        </div>
    </div> <!-- app-main__inner -->


    <?php 
        $this->load->view('template/footer'); 
    ?>

</div> <!-- app-main__outer -->


<?php 
    // $this->load->view('template/right-top-drawer'); 
    $this->load->view('template/footer-script');
?> 



<script type="text/javascript">

var idjurnal = "<?php echo($idjurnal) ?>";
  
  $(document).ready(function() {
    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idjurnal != "" ) { 
          //console.log(idjurnal);
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Jurnalpenyesuaian/get_edit_data") ?>', 
              data        : {idjurnal: idjurnal}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            // console.log(result);

            $('#idjurnal').val(result.idjurnal);
            $('#deskripsi').val(result.deskripsi);
            $('#tgljurnal').val(result.tgljurnal);
            $('#file_lama2').val(result.filelampiran);
            if (result.filelampiran!='' && result.filelampiran!= null) {
              $('#lblfilelama').html('File terlampir : '+result.filelampiran);
            }


            var counter=1;
            $.each(result.RsDataDetail, function(key, value){

              tambahrow();
              // $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
              $('#kdakun4'+counter).val(value['kdakun4']);
              $('#namaakun4'+counter).val(value['namaakun4']);
              $('#debet'+counter).val(numberWithCommas(value['debet']));
              $('#kredit'+counter).val(numberWithCommas(value['kredit']));
              counter += 1;
            })
            hitungtotal();
          }); // end ajax.done
          $('#page-title').html('Edit Data Jurnal Penyesuaian');
          $('#icon-header').addClass('fa fa-edit')
    }else{
          $('#icon-header').addClass('fa fa-plus-circle')
          $('#page-title').html('Tambah Data Jurnal Penyesuaian');
          tambahrow();
          tambahrow();
    } 


    $('#addrow').click(function(){
      tambahrow();
    })

    $("form").attr('autocomplete', 'off');
  }); //end (document).ready

  $('#form').submit(function(e) {


        if ($('#table tbody tr').length=0) {
            swal("Required!", "Tabel jurnal tidak boleh kosong!", "info")
            e.preventDefault();
            $('#simpan').prop('readonly', false);
            $('#simpan').prop('disabled', false);
            return false; 
        }

      if ($('#totaldebet').val()=='') {
            swal("Required!", "Total debet tidak boleh kosong!", "info")
            e.preventDefault();
            return false;
        }

        if ($('#totalkredit').val()=='') {
            swal("Required!", "Total kredit tidak boleh kosong!", "info")
            e.preventDefault();
            return false;
        }

        

        if ( $('#totaldebet').val() != $('#totalkredit').val()) {
            swal("Required!", "Total debet dan Total kredit harus sama!", "info")
            e.preventDefault();
            return false;
        }

  });

  function tambahrow()
  {
    var counter = $('#table tbody tr').length + 1;
    var addrow = '<tr>';
        addrow += '<td><input type="text" name="namaakun4[]" id="namaakun4'+counter+'" class="form-control form-control-sm akunautocomplate" value=""><input type="hidden" name="kdakun4[]" id="kdakun4'+counter+'"></td>';
        addrow += '<td><input type="text" name="debet[]" id="debet'+counter+'" class="form-control form-control-sm text-right" onchange="hitungtotal()"></td>';
        addrow += '<td><input type="text" name="kredit[]" id="kredit'+counter+'" class="form-control form-control-sm text-right" onchange="hitungtotal()"></td>';
        addrow += '<td style="text-align: center;"><a href="" id="removerow"><i class="fa fa-trash"></i></a></td>';
        addrow += '</tr>';


    $('#table tbody').append(addrow);
    $( "#namaakun4"+counter ).autocomplete({
      minLength: 0,
      source: function( request, response ){
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Jurnalpenyesuaian/akun4_autocomplate'); ?>",
            dataType: "json",
            data:{term: request.term},
            success: function(data){
              response( data );
            }
          });
      },
      focus: function( event, ui ) {
        $('#table tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(1) input#kdakun4'+counter).val(ui.item.kdakun4);
        $('#table tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(1) input#namaakun4'+counter).val(ui.item.namaakun4);
        return false;
      },
      select: function( event, ui ) {
        var kdakun4 = ui.item.kdakun4;

        for (var i = 1; i < $('#table tbody tr').length+1; i++) {
          if ($('#kdakun4'+i).val()!='' && kdakun4==$('#kdakun4'+i).val() && i!=counter) {
                alert('Maaf, Akun ini sudah ada');
                $('#kdakun4'+counter).val('')
                $('#namaakun4'+counter).val('')
                return false;   
          }
        };

        $('#table tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(1) input#kdakun4'+counter).val(ui.item.kdakun4);
        $('#table tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(1) input#namaakun4'+counter).val(ui.item.namaakun4);

        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div><b>"+item.kdakun4 +" "+ item.namaakun4 + "</b></div>" )
        .appendTo( ul );
    };

    $('#debet'+counter).mask('000,000,000,000', {reverse: true});
    $('#kredit'+counter).mask('000,000,000,000', {reverse: true});

    if (counter>2) {
      $('#table tbody tr').each(function(){
        $(this).find('td:nth-child(1) input#namaakun4'+counter).focus();
      });
    }
    
  }

  $(document).on('click', '#removerow', function(e){
    e.preventDefault();
    $(this).parent().parent().remove();

    // Nomor Urut
    // var Nomor = 1;
    // $('#table tbody tr').each(function(){
    //   $(this).find('td:nth-child(1)').html(Nomor);
    //   Nomor++;
    // });

    hitungtotal();
  });



  function hitungtotal()
  {
    var totaldebet = 0;
    var totalkredit = 0;
    for (var i = 1; i < $('#table tbody tr').length+1; i++) {
      var debet = untitik($('#debet'+i).val());
      var kredit = untitik($('#kredit'+i).val());

      if (debet=='') {
        debet=0;
      }else{
        debet = parseInt(debet);
      }
      if (kredit=='') {
        kredit=0;
      }else{
        kredit = parseInt(kredit);
      }

      totaldebet += debet;
      totalkredit += kredit;
    };

      $('#totaldebet').val(numberWithCommas(totaldebet));
      $('#totalkredit').val(numberWithCommas(totalkredit));
  }


  $(document).on('keydown', 'body', function(e){
    var charCode = ( e.which ) ? e.which : event.keyCode;
    // console.log(charCode);

    if(charCode == 113) //F2
    {
      tambahrow();
      return false;
    }

  });

  $('#tgljurnal').mask('00-00-0000', {placeholder:"__-__-____"});

</script>



<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"
  integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk="
  crossorigin="anonymous"></script>

<script>

</body>
</html>
