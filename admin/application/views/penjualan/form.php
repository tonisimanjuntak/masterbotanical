<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Penjualan</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('Penjualan')) ?>">Penjualan</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-header">
                <h5 class="card-title" id="lbljudul"></h5>
              </div>
              <div class="card-body">

                  <div class="col-md-12">
                    <?php 
                      $pesan = $this->session->flashdata("pesan");
                      if (!empty($pesan)) {
                        echo $pesan;
                      }
                    ?>
                  </div> 


                  <input type="hidden" name="idpenjualan" id="idpenjualan">
                  <div class="row">

                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          
                          <h5>Informasi Penjualan</h5><hr>
                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Tgl Penjualan</label>
                            <div class="col-md-6">
                              <input type="date" name="tglpenjualan" id="tglpenjualan" class="form-control" value="<?php echo date('Y-m-d') ?>">
                            </div>
                          </div>
                          
                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Keterangan</label>
                            <div class="col-md-8">
                              <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="keterangan"></textarea>
                            </div>
                          </div>
                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Metode Pembayaran</label>
                            <div class="col-md-8">
                              <select name="metodepembayaran" id="metodepembayaran" class="form-control">
                                <option value="">Pilih metode pembayaran...</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Virtual Account">Virtual Account</option>
                              </select>
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          
                          <h5 class="mb-3">Informasi Konsumen & Pengiriman</h5><hr>
                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Nama Konsumen</label>
                            <div class="col-md-8">
                              <select name="idkonsumen" id="idkonsumen" class="form-control select2">
                                <option value="">Pilih nama konsumen...</option>
                                <?php  
                                  $rskonsumen = $this->db->query("select * from konsumen order by namakonsumen");
                                  if ($rskonsumen->num_rows()>0) {
                                    foreach ($rskonsumen->result() as $row) {
                                      echo '
                                        <option value="'.$row->idkonsumen.'">'.$row->idkonsumen.' '.$row->namakonsumen.'</option>
                                      ';
                                    }
                                  }
                                ?>
                              </select>
                            </div>
                          </div>


                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Jasa Pengiriman</label>
                            <div class="col-md-8">
                              <select name="idjasapengiriman" id="idjasapengiriman" class="form-control select2">
                                <option value="">Pilih jasa pengiriman...</option>
                                <?php  
                                  $rsjasapengiriman = $this->db->query("select * from jasapengiriman where statusaktif='Aktif' order by namajasapengiriman");
                                  if ($rsjasapengiriman->num_rows()>0) {
                                    foreach ($rsjasapengiriman->result() as $row) {
                                      echo '
                                        <option value="'.$row->idjasapengiriman.'">'.$row->idjasapengiriman.' '.$row->namajasapengiriman.'</option>
                                      ';
                                    }
                                  }
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Negara</label>
                            <div class="col-md-8">
                              <input type="text" name="negara" id="negara" class="form-control" placeholder="Indonesia">
                            </div>
                          </div>

                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Provinsi</label>
                            <div class="col-md-8">
                              <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="Kalimantan Barat">
                            </div>
                          </div>

                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Kota</label>
                            <div class="col-md-8">
                              <input type="text" name="kota" id="kota" class="form-control" placeholder="Pontianak">
                            </div>
                          </div>

                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Desa</label>
                            <div class="col-md-8">
                              <input type="text" name="desa" id="desa" class="form-control" placeholder="Tanjung Hilir">
                            </div>
                          </div>

                          <div class="form-group row required">
                            <label for="" class="col-md-4 col-form-label">Alamat</label>
                            <div class="col-md-8">
                              <textarea name="alamatpengiriman" id="alamatpengiriman" class="form-control" rows="2" placeholder="Jl. Patimura No.11 RTRW 02/03 Blok B12"></textarea>
                            </div>
                          </div>



                        </div>
                      </div>
                    </div>



                  </div>

                  


                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                          <h5 class="mb-3">Detail Penjualan</h5>
                          <hr>

                          
                          <form action="<?php echo(site_url('Penjualan/simpan')) ?>" method="post" id="form">                      
                            <div class="row">

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="">Produk</label>
                                    <select name="idproduk" id="idproduk" class="form-control">
                                      <option value="">Pilih produk...</option>
                                      <?php
                                        $rs = $this->db->query("select * from v_produk order by namaproduk2");
                                        foreach ($rs->result() as $row) {
                                          echo '<option value="'.$row->idproduk.'">'.$row->namaproduk2.'</option>';
                                        }
                                      ?>  
                                    </select>
                                </div>
                              </div>

                              

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Berat (KG)</label>
                                  <input type="text" name="beratproduk" id="beratproduk" class="form-control berat">
                                </div>
                              </div>

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Harga Produk / KG (<?php echo $this->session->userdata('matauang'); ?>)</label>
                                  <input type="text" name="hargaproduk" id="hargaproduk" class="form-control rupiah">
                                </div>
                              </div>

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Subtotal (<?php echo $this->session->userdata('matauang'); ?>)</label>
                                  <input type="text" name="subtotal" id="subtotal" class="form-control rupiah" disabled="">
                                </div>
                              </div>


                              

                              <div class="col-md-3" style="display: none;">
                                <div class="form-group">
                                  <label for="">Paket Harga</label>
                                  <select name="idprodukharga" id="idprodukharga" class="form-control">
                                    <option value="">Pilih paket harga produk...</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-2" style="display: none;">
                                <div class="form-group">
                                  <label for="">QTY</label>
                                  <input type="number" name="qty" id="qty" min="1" max="999" class="form-control" value="1">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <button class="btn btn-primary mt-4" type="submit" id="tambahkan">Tambahkan</button>
                              </div>

                            </div>
                          </form>

                            <hr>

                          <div class="table-responsive">
                            <table id="table" class="display" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="">idprodukharga</th>
                                        <th style="">idproduk</th>
                                        <th style="">Nama Produk</th>
                                        <th style="">Berat</th>
                                        <th style="">Harga</th>
                                        <th style="">Qty</th>
                                        <th style="">Sub Total</th>
                                        <th style="width: 5%; text-align: center;">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th style="text-align: right; font-weight: bold; font-size: 20px;">TOTAL: </th>
                                  <th style="text-align: right; font-weight: bold; font-size: 20px" colspan="2"></th>
                                </tfoot>   
                            </table>
                          </div>

                      </div>
                    </div>
                    <input type="hidden" id="total">
                  </div>
                  

              </div> <!-- ./card-body -->

              <div class="card-footer">
                <button class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('Penjualan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->

      

<?php $this->load->view("template/footer") ?>




<script type="text/javascript">
  
  var idpenjualan = "<?php echo($idpenjualan) ?>";

  $(document).ready(function() {

    $('.select2').select2();
    

    table = $('#table').DataTable({ 
        "select": true,
            "processing": true, 
            "ordering": false,
            "bPaginate": false,      
            "searching": false,  
            "bInfo" : false, 
             "ajax"  : {
                      "url": "<?php echo site_url('Penjualan/datatablesourcedetail')?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idpenjualan": '<?php echo($idpenjualan) ?>'}
                  },
                "footerCallback": function ( row, data, start, end, display ) {
                                    var api = this.api(), data;
                         
                                    // Hilangkan format number untuk menghitung sum
                                    var intVal = function ( i ) {
                                        return typeof i === 'string' ?
                                            i.replace(/[\$,]/g, '')*1 :
                                            typeof i === 'number' ?
                                                i : 0;
                                    };
                         
                                    // Total Semua Halaman
                                    total = api
                                        .column( 7 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0 );
                         
                                    // Total Halaman Terkait
                                    pageTotal = api
                                        .column( 7, { page: 'current'} )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0 );
                                    
                                    jlhkeseluruhan = total;
                                    // Update footer
                                    $( api.column( 7 ).footer() ).html(
                                        '<?php echo $this->session->userdata('matauang'); ?> '+ numberWithCommas(total)                                        
                                    );
                                    $('#total').val( numberWithCommas(total) );
                                },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 6 ], "orderable": false, "className": 'dt-body-center'},
            ],
     
        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpenjualan != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Penjualan/get_edit_data") ?>', 
              data        : {idpenjualan: idpenjualan}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            console.log(result);
            $('#idpenjualan').val(result.idpenjualan);
            $('#tglpenjualan').val(result.tglpenjualan);
            $('#idkonsumen').val(result.idkonsumen).trigger('change');
            $('#idjasapengiriman').val(result.idjasapengiriman).trigger('change');
            $('#negara').val(result.negara);
            $('#propinsi').val(result.propinsi);
            $('#kota').val(result.kota);
            $('#desa').val(result.desa);
            $('#alamatpengiriman').val(result.alamatpengiriman);
            $('#metodepembayaran').val(result.metodepembayaran);
            $('#keterangan').val(result.keterangan);
          }); 
          
          $('#lbljudul').html('Edit Data Penjualan');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Penjualan');
          $('#lblactive').html('Tambah');
    }     

    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        idproduk: {
          validators:{
            notEmpty: {
                message: "idproduk tidak boleh kosong"
            },
          }
        },
        idprodukharga: {
          validators:{
            notEmpty: {
                message: "paket harga tidak boleh kosong"
            },
          }
        },
        qty: {
          validators:{
            notEmpty: {
                message: "qty tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);
      
    var idproduk           = $('#idproduk').val();
    var idprodukharga           = $('#idprodukharga').val();
    var beratproduk           = $('#beratproduk').val();
    var hargaproduk           = $('#hargaproduk').val();
    // var qty           = $('#qty').val();
    var qty           = 1;


        if (beratproduk=="" || beratproduk=="0") {
          alert("berat produk tidak boleh kosong!!");
          return false;
        }

        if (hargaproduk=="" || hargaproduk=="0") {
          alert("harga produk tidak boleh kosong!!");
          return false;
        }
      
      var isicolomn = table.columns(1).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {            
          if (isicolomn[i][j] === idproduk) {
              alert("Produk ini sudah ada!!");
              return false;
          }
        }
      };

        var subtotal = parseFloat(beratproduk) * parseFloat(hargaproduk) * parseFloat(qty);

        nomorrow = table.page.info().recordsTotal + 1;
        table.row.add( [
                            nomorrow,
                            $("#idprodukharga").val(),
                            $("#idproduk").val(),
                            $( "#idproduk option:selected" ).text(),
                            beratproduk,
                            hargaproduk,
                            qty,
                            subtotal,
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#idproduk").val("");
        $("#idprodukharga").val("");
        $("#qty").val("1");
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN

    $('#table tbody').on( 'click', 'span', function () {
        table
            .row( $(this).parents('tr') )
            .remove()
            .draw();
    });


    $("form").attr('autocomplete', 'off');
    // $('#tglterima').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    // $('#hargabelisatuan').mask('000,000,000,000', {reverse: true, placeholder:"000,000,000,000"});
  }); //end (document).ready
  

  
  $('#simpan').click(function(){
    var idpenjualan       = $("#idpenjualan").val();
    var tglpenjualan       = $("#tglpenjualan").val();
    var idkonsumen       = $("#idkonsumen").val();
    var keterangan       = $("#keterangan").val();
    var metodepembayaran       = $("#metodepembayaran").val();
    var totalpenjualan       = $("#total").val();

    var negara       = $("#negara").val();
    var propinsi       = $("#propinsi").val();
    var kota       = $("#kota").val();
    var desa       = $("#desa").val();
    var alamatpengiriman       = $("#alamatpengiriman").val();
    var idjasapengiriman       = $("#idjasapengiriman").val();
    

      if (tglpenjualan=='') {
        alert("tglpenjualan tidak boleh kosong!!");
        return; 
      }

      if (idkonsumen=='') {
        alert("idkonsumen tidak boleh kosong!!");
        return; 
      }
    
      if (metodepembayaran=='') {
        alert("metodepembayaran tidak boleh kosong!!");
        return; 
      }
    
      if (totalpenjualan=='') {
        alert("totalpenjualan tidak boleh kosong!!");
        return; 
      }
    

      if (negara=='') {
        alert("negara tidak boleh kosong!!");
        return; 
      }

      if (propinsi=='') {
        alert("propinsi tidak boleh kosong!!");
        return; 
      }

      if (kota=='') {
        alert("kota tidak boleh kosong!!");
        return; 
      }

      if (desa=='') {
        alert("desa tidak boleh kosong!!");
        return; 
      }

      if (alamatpengiriman=='') {
        alert("alamatpengiriman tidak boleh kosong!!");
        return; 
      }


    if ( ! table.data().count() ) {
          alert("Detail Penjualan belum ada!!");
          return;
      }

      var isidatatable = table.data().toArray();

      var formData = {
              "idpenjualan"       : idpenjualan,
              "tglpenjualan"       : tglpenjualan,
              "idkonsumen"       : idkonsumen,
              "keterangan"       : keterangan,
              "metodepembayaran"       : metodepembayaran,
              "totalpenjualan"       : totalpenjualan,
              "negara"       : negara,
              "propinsi"       : propinsi,
              "kota"       : kota,
              "desa"       : desa,
              "alamatpengiriman"       : alamatpengiriman,
              "idjasapengiriman"       : idjasapengiriman,
              "isidatatable"    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST', 
                url         : '<?php echo site_url("Penjualan/simpan") ?>', 
                data        : formData, 
                dataType    : 'json', 
                encode      : true
            })
            .done(function(result){
                console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo(site_url('Penjualan')) ?>";
                    
                }else{
                  // console.log(result.msg);
                  alert("Gagal simpan data!");
                }
            })
            .fail(function(){
                alert("Gagal script simpan data!");
            });

  })



  $('#idproduk').change(function() {
    var idproduk = $(this).val();

    $("#hargaproduk").val();
    $("#beratproduk").val();

    $("#idprodukharga").empty();
    $("#idprodukharga").append( new Option('Pilih paket harga produk...', '') );

    if (idproduk!='') {
          
          $.ajax({
            url: '<?php echo(site_url('Penjualan/get_produkharga')) ?>',
            type: 'GET',
            dataType: 'json',
            data: {'idproduk': idproduk},
          })
          .done(function(rsprodukharga) {
            if (rsprodukharga.length>0 ) {

              $.each(rsprodukharga, function(index, val) {
                 $("#idprodukharga").append( new Option(rsprodukharga[index]['berat']+' Kg (<?php echo $this->session->userdata('matauang'); ?> '+rsprodukharga[index]['harga']+')', rsprodukharga[index]['idprodukharga']) );
              });
            }
            console.log("success");
          })
          .fail(function() {
            console.log("error get produk harga");
          });

        }    
    
  });


  $('#idprodukharga').change(function() {
    var idprodukharga = $(this).val();

    $("#hargaproduk").val();
    $("#beratproduk").val();


    if (idprodukharga!='') {
          
          $.ajax({
            url: '<?php echo(site_url('Penjualan/get_rinciharga')) ?>',
            type: 'GET',
            dataType: 'json',
            data: {'idprodukharga': idprodukharga},
          })
          .done(function(rsprodukharga) {

            $("#hargaproduk").val(rsprodukharga['harga']);
            $("#beratproduk").val(rsprodukharga['berat']);
          })
          .fail(function() {
            console.log("error get rincian harga");
          });

        }    
    
  });


  $('#idkonsumen').change(function() {
    var idkonsumen = $(this).val();

    $("#negara").val();
    $("#propinsi").val();
    $("#kota").val();
    $("#desa").val();
    $("#alamatpengiriman").val();


    if (idkonsumen!='') {
          
          $.ajax({
            url: '<?php echo(site_url('Penjualan/get_alamatpengiriman')) ?>',
            type: 'GET',
            dataType: 'json',
            data: {'idkonsumen': idkonsumen},
          })
          .done(function(rowkonsumen) {

            $("#negara").val(rowkonsumen['negara']);
            $("#propinsi").val(rowkonsumen['propinsi']);
            $("#kota").val(rowkonsumen['kota']);
            $("#desa").val(rowkonsumen['desa']);
            $("#alamatpengiriman").val(rowkonsumen['alamatpengiriman']);

          })
          .fail(function() {
            console.log("error get alamat pengiriman");
          });

        }    
    
  });

  $('#beratproduk').change(function() {
    hitungSubTotal();
  });

  $('#hargaproduk').change(function() {
    hitungSubTotal();
  });

  function hitungSubTotal()
  {
    var beratproduk = $('#beratproduk').val();
    var hargaproduk = $('#hargaproduk').val();
    var qty         = 1;

    if (beratproduk!='' && beratproduk!='0' && hargaproduk!='' && hargaproduk!='0') {
      $('#subtotal').val( parseFloat(beratproduk) * parseFloat(hargaproduk) * parseFloat(qty) );
    }else{
      $('#subtotal').val('0');
    }


  }


</script>


</body>
</html>
