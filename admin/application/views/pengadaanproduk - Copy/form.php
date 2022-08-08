<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pengadaan Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('pengadaanproduk')) ?>">Pengadaan Produk</a></li>
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


                  <input type="hidden" name="idpengadaanproduk" id="idpengadaanproduk">

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Tanggal</label>
                    <div class="col-md-4">
                      <input type="date" name="tglpengadaanproduk" id="tglpengadaanproduk" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Keterangan</label>
                    <div class="col-md-10">
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"></textarea>
                    </div>
                  </div>

                  <div class="form-group row required" style="display: none;">
                    <label for="" class="col-md-2 col-form-label">Total Pengadaan</label>
                    <div class="col-md-4">
                      <input type="text" name="totalpengadaan" id="totalpengadaan" class="form-control rupiah" readonly="">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                          <h3 class="text-muted text-center">Detail Pengadaan Produk</h3>
                          <hr>


                          <form action="<?php echo (site_url('pengadaanproduk/simpan')) ?>" method="post" id="form">
                            <div class="row">

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="">Nama Produk</label>
                                    <select name="idproduk" id="idproduk" class="form-control select2">
                                      <option value="">---Pilih nama produk---</option>
                                      <?php
$rsproduk = $this->db->query("select * from produk order by namaproduk ");
if ($rsproduk->num_rows() > 0) {
    foreach ($rsproduk->result() as $row) {
        echo '<option value="' . $row->idproduk . '">' . $row->namaproduk . '</option>';
    }
}

?>
                                    </select>
                                </div>
                              </div>


                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Berat Bruto</label>
                                  <input type="text" name="beratbruto" id="beratbruto" class="form-control berat">
                                </div>
                              </div>

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Berat Netto</label>
                                  <input type="text" name="beratnetto" id="beratnetto" class="form-control berat">
                                </div>
                              </div>

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Harga Beli</label>
                                  <input type="text" name="hargabeli" id="hargabeli" class="form-control rupiah">
                                </div>
                              </div>


                              <div class="col-md-2">
                                <button class="btn btn-primary btn-block mt-4" type="submit" id="tambahkan">Tambahkan</button>
                              </div>

                            </div>
                          </form>

                            <hr>

                          <div class="table-responsive">
                            <table id="table" class="display" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="">idpengadaanproduk</th>
                                        <th style="">idproduk</th>
                                        <th style="">Nama Produk</th>
                                        <th style="text-align: center;">Bruto</th>
                                        <th style="text-align: center;">Netto</th>
                                        <th style="text-align: right;">Harga Beli</th>
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
                <a href="<?php echo (site_url('pengadaanproduk')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>




<script type="text/javascript">

  var idpengadaanproduk = "<?php echo ($idpengadaanproduk) ?>";

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
                      "url": "<?php echo site_url('pengadaanproduk/datatablesourcedetail') ?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idpengadaanproduk": '<?php echo ($idpengadaanproduk) ?>'}
                  },
                "footerCallback": function ( row, data, start, end, display ) {
                                    var api = this.api(), data;

                                    // Hilangkan format number untuk menghitung sum
                                    var intVal = function ( i ) {
                                        return typeof i === 'string' ?
                                            i.replace(/[\$,.]/g, '')*1 :
                                            typeof i === 'number' ?
                                                i : 0;
                                    };

                                    // Total Semua Halaman
                                    total = api
                                        .column( 6 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return parseFloat(untitik(a)) + parseFloat(untitik(b));
                                        }, 0 );

                                    // Total Halaman Terkait
                                    pageTotal = api
                                        .column( 6, { page: 'current'} )
                                        .data()
                                        .reduce( function (a, b) {
                                            return parseFloat(untitik(a)) + parseFloat(untitik(b));
                                        }, 0 );

                                    jlhkeseluruhan = total;
                                    // Update footer
                                    $( api.column( 6 ).footer() ).html(
                                        'Rp. '+ numberWithCommas(total)
                                    );
                                    $('#total').val( numberWithCommas(total) );
                                    $('#totalpengadaan').val( numberWithCommas(total) );
                                },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 4 ], "className": 'dt-body-center'},
            { "targets": [ 5 ], "className": 'dt-body-center'},
            { "targets": [ 6 ], "className": 'dt-body-center'},
            { "targets": [ 7 ], "orderable": false, "className": 'dt-body-center'},
            ],

        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpengadaanproduk != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Pengadaanproduk/get_edit_data") ?>',
              data        : {idpengadaanproduk: idpengadaanproduk},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $('#idpengadaanproduk').val(result.idpengadaanproduk);
            $('#tglpengadaanproduk').val(result.tglpengadaanproduk);
            $('#keterangan').val(result.keterangan);
          });

          $('#lbljudul').html('Edit Data Pengadaan Produk');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Pengadaan Produk');
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
                message: "nama produk tidak boleh kosong"
            },
          }
        },
        beratbruto: {
          validators:{
            notEmpty: {
                message: "berat bruto tidak boleh kosong"
            },
          }
        },
        beratnetto: {
          validators:{
            notEmpty: {
                message: "berat netto tidak boleh kosong"
            },
          }
        },
        hargabeli: {
          validators:{
            notEmpty: {
                message: "harga beli tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);

    var idpengadaanproduk               = $('#idpengadaanproduk').val();
    var idproduk                      = $('#idproduk').val();
    var beratbruto                      = $('#beratbruto').val();
    var beratnetto                      = $('#beratnetto').val();
    var hargabeli                      = $('#hargabeli').val();

    if ( hargabeli=="" || hargabeli=="0" ) {
      alert("subtotal tidak boleh kosong!!");
      return false;
    }

      var isicolomn = table.columns(2).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {
          if (isicolomn[i][j] === idproduk) {
              alert("nama produk ini sudah ada!!");
              return false;
          }
        }
      };

        nomorrow = table.page.info().recordsTotal + 1;
        table.row.add( [
                            nomorrow,
                            idpengadaanproduk,
                            idproduk,
                            $("#idproduk").find(":selected").text(),
                            beratbruto,
                            beratnetto,
                            hargabeli,
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#idproduk").val("").change();
        $("#beratbruto").val("");
        $("#beratnetto").val("");
        $("#hargabeli").val("");
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
    var idpengadaanproduk      = $("#idpengadaanproduk").val();
    var tglpengadaanproduk       = $("#tglpengadaanproduk").val();
    var keterangan       = $("#keterangan").val();
    var totalpengadaan       = $("#totalpengadaan").val();


      if (tglpengadaanproduk=='') {
        alert("tgl pengadaan produk tidak boleh kosong!!");
        return;
      }

      if (keterangan=='') {
        alert("keterangan tidak boleh kosong!!");
        return;
      }

      if (totalpengadaan=='') {
        alert("total pengadaan tidak boleh kosong!!");
        return;
      }

    if ( ! table.data().count() ) {
          alert("Detail pengadaan belum ada!!");
          return;
      }

      var isidatatable = table.data().toArray();

      var formData = {
              "idpengadaanproduk"       : idpengadaanproduk,
              "tglpengadaanproduk"       : tglpengadaanproduk,
              "keterangan"       : keterangan,
              "totalpengadaan"       : totalpengadaan,
              "isidatatable"    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST',
                url         : '<?php echo site_url("Pengadaanproduk/simpan") ?>',
                data        : formData,
                dataType    : 'json',
                encode      : true
            })
            .done(function(result){
                // console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo (site_url('pengadaanproduk')) ?>";

                }else{
                  // console.log(result.msg);
                  alert("Gagal simpan data!");
                }
            })
            .fail(function(){
                alert("Gagal script simpan data!");
            });

  })

</script>


</body>
</html>
