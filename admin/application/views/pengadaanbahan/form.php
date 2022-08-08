<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pengadaan Bahan</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('pengadaanbahan')) ?>">Pengadaan Bahan</a></li>
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


                  <input type="hidden" name="idpengadaanbahan" id="idpengadaanbahan">

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Tanggal</label>
                    <div class="col-md-4">
                      <input type="date" name="tglpengadaanbahan" id="tglpengadaanbahan" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-4">
                      <input type="time" name="tglpengadaanbahan" id="tglpengadaanbahan2" class="form-control" value="">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Supplier</label>
                    <div class="col-md-10">
                      <select name="idsupplier" id="idsupplier" class="form-control select2">
                        <option value="">Pilih nama supplier...</option>
                        <?php
$rssupplier = $this->db->query("select * from supplier order by namasupplier");
if ($rssupplier->num_rows() > 0) {
    foreach ($rssupplier->result() as $row) {
        echo '
                                <option value="' . $row->idsupplier . '">' . $row->namasupplier . '</option>
                              ';
    }
}
?>
                      </select>
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
                          <h3 class="text-muted text-center">Detail Pengadaan Bahan</h3>
                          <hr>


                          <form action="<?php echo (site_url('pengadaanbahan/simpan')) ?>" method="post" id="form">
                            <div class="row">

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Nama Bahan</label>
                                    <select name="idbahan" id="idbahan" class="form-control select2">
                                      <option value="">---Pilih nama bahan---</option>
                                      <?php
$rsbahan = $this->db->query("select * from bahan order by namabahan ");
if ($rsbahan->num_rows() > 0) {
    foreach ($rsbahan->result() as $row) {
        echo '<option value="' . $row->idbahan . '">' . $row->namabahan . '</option>';
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

                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="">QTY</label>
                                  <input type="number" name="qty" id="qty" min="1" class="form-control" value="1">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Harga Satuan</label>
                                  <input type="text" name="hargasatuan" id="hargasatuan" class="form-control rupiah">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Sub Total</label>
                                  <input type="text" name="subtotal" id="subtotal" class="form-control rupiah" readonly="">
                                </div>
                              </div>

                              <div class="col-md-4">
                              </div>
                              <div class="col-md-4">
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
                                        <th style="">idpengadaanbahan</th>
                                        <th style="">idbahan</th>
                                        <th style="">Nama Bahan</th>
                                        <th style="text-align: center;">Bruto</th>
                                        <th style="text-align: center;">Netto</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: right;">Harga Satuan</th>
                                        <th style="text-align: right;">Sub Total</th>
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
                <a href="<?php echo (site_url('pengadaanbahan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>




<script type="text/javascript">

  var idpengadaanbahan = "<?php echo ($idpengadaanbahan) ?>";

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
                      "url": "<?php echo site_url('pengadaanbahan/datatablesourcedetail') ?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idpengadaanbahan": '<?php echo ($idpengadaanbahan) ?>'}
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
                                        .column( 8 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return parseFloat(untitik(a)) + parseFloat(untitik(b));
                                        }, 0 );

                                    // Total Halaman Terkait
                                    pageTotal = api
                                        .column( 8, { page: 'current'} )
                                        .data()
                                        .reduce( function (a, b) {
                                            return parseFloat(untitik(a)) + parseFloat(untitik(b));
                                        }, 0 );

                                    jlhkeseluruhan = total;
                                    // Update footer
                                    $( api.column( 8 ).footer() ).html(
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
            { "targets": [ 7 ], "className": 'dt-body-right'},
            { "targets": [ 8 ], "className": 'dt-body-right'},
            { "targets": [ 9 ], "orderable": false, "className": 'dt-body-center'},
            ],

        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpengadaanbahan != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Pengadaanbahan/get_edit_data") ?>',
              data        : {idpengadaanbahan: idpengadaanbahan},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $('#idpengadaanbahan').val(result.idpengadaanbahan);
            $('#tglpengadaanbahan').val(result.tglpengadaanbahan);
            $('#idsupplier').val(result.idsupplier).trigger('change');
            $('#keterangan').val(result.keterangan);
          });

          $('#lbljudul').html('Edit Data Pengeluaran');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Pengeluaran');
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
        idbahan: {
          validators:{
            notEmpty: {
                message: "nama bahan tidak boleh kosong"
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
        hargasatuan: {
          validators:{
            notEmpty: {
                message: "harga satuan tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);

    var idpengadaanbahan               = $('#idpengadaanbahan').val();
    var idbahan                      = $('#idbahan').val();
    var beratbruto                      = $('#beratbruto').val();
    var beratnetto                      = $('#beratnetto').val();
    var qty                      = $('#qty').val();
    var hargasatuan                      = $('#hargasatuan').val();
    var subtotal           = $('#subtotal').val();

    if ( subtotal=="" || subtotal=="0" ) {
      alert("subtotal tidak boleh kosong!!");
      return false;
    }

      var isicolomn = table.columns(2).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {
          if (isicolomn[i][j] === idbahan) {
              alert("nama bahan ini sudah ada!!");
              return false;
          }
        }
      };

        nomorrow = table.page.info().recordsTotal + 1;
        table.row.add( [
                            nomorrow,
                            idpengadaanbahan,
                            idbahan,
                            $("#idbahan").find(":selected").text(),
                            beratbruto,
                            beratnetto,
                            qty,
                            hargasatuan,
                            subtotal,
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#idbahan").val("").change();
        $("#beratbruto").val("");
        $("#beratnetto").val("");
        $("#qty").val("1");
        $("#hargasatuan").val("");
        $("#subtotal").val("");
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

  
  $('#qty').change(function() {
    hitungsubtotal();
  });

  $('#hargasatuan').change(function() {
    hitungsubtotal();
  });

  $('#simpan').click(function(){
    var idpengadaanbahan      = $("#idpengadaanbahan").val();
    var idsupplier            = $("#idsupplier").val();
    var tglpengadaanbahan       = $("#tglpengadaanbahan").val();
    var keterangan       = $("#keterangan").val();
    var totalpengadaan       = $("#totalpengadaan").val();


      if (tglpengadaanbahan=='') {
        alert("tgl pengadaan bahan tidak boleh kosong!!");
        return;
      }

      if (idsupplier=='') {
        alert("nama supplier tidak boleh kosong!!");
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
              "idpengadaanbahan"       : idpengadaanbahan,
              "idsupplier"       : idsupplier,
              "tglpengadaanbahan"       : tglpengadaanbahan,
              "keterangan"       : keterangan,
              "totalpengadaan"       : totalpengadaan,
              "isidatatable"    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST',
                url         : '<?php echo site_url("Pengadaanbahan/simpan") ?>',
                data        : formData,
                dataType    : 'json',
                encode      : true
            })
            .done(function(result){
                // console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo (site_url('pengadaanbahan')) ?>";

                }else{
                  // console.log(result.msg);
                  alert("Gagal simpan data!");
                }
            })
            .fail(function(){
                alert("Gagal script simpan data!");
            });

  })


  function hitungsubtotal()
  {
    var qty = $('#qty').val();
    var hargasatuan = untitik($('#hargasatuan').val());
    var subtotal;

    subtotal = parseFloat(qty) * parseFloat(hargasatuan);
    $('#subtotal').val(numberWithCommas(subtotal));

  }
</script>


</body>
</html>
