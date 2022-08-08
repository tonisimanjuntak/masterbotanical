<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Bahan Keluar</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('bahankeluar')) ?>">Bahan Keluar</a></li>
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


                  <input type="hidden" name="idbahankeluar" id="idbahankeluar">

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Tanggal</label>
                    <div class="col-md-3">
                      <input type="date" name="tglbahankeluar2" id="tglbahankeluar" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-2">
                      <input type="time" name="tglbahankeluar2" id="tglbahankeluar2" class="form-control" value="<?php echo date('H:i:s') ?>">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Nomor Kendaraan</label>
                    <div class="col-md-2">
                      <input type="text" name="nomorkendaraan" id="nomorkendaraan" class="form-control" placeholder="KB0000ABC">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Keterangan</label>
                    <div class="col-md-10">
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"></textarea>
                    </div>
                  </div>

                  
                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Dikirim Oleh</label>
                    <div class="col-md-10">
                      <input type="text" name="dikirimoleh" id="dikirimoleh" class="form-control" placeholder="Dikirim oleh">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Diperiksa Oleh</label>
                    <div class="col-md-10">
                      <input type="text" name="diperiksaoleh" id="diperiksaoleh" class="form-control" placeholder="Diperiksa oleh">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Diterima Oleh</label>
                    <div class="col-md-10">
                      <input type="text" name="diterimaoleh" id="diterimaoleh" class="form-control" placeholder="Diterima oleh">
                    </div>
                  </div>


                  <div class="form-group row required" style="display: none;">
                    <label for="" class="col-md-2 col-form-label">TOtal Berat Bahan</label>
                    <div class="col-md-10">
                      <input type="text" name="totalberatbahan" id="totalberatbahan" class="form-control">
                    </div>
                  </div>



                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                          <h3 class="text-muted text-center">Detail Bahan Keluar</h3>
                          <hr>


                          <form action="<?php echo (site_url('bahankeluar/simpan')) ?>" method="post" id="form">
                            <div class="row">

                              <div class="col-md-8">
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
                                  <label for="">Berat Bahan (KG)</label>
                                  <input type="text" name="beratbahankeluar" id="beratbahankeluar" class="form-control berat">
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
                                        <th style="">idbahankeluar</th>
                                        <th style="">idbahan</th>
                                        <th style="">Nama Bahan</th>
                                        <th style="text-align: right;">Berat Bahan (KG)</th>
                                        <th style="width: 5%; text-align: center;">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
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
                <a href="<?php echo (site_url('bahankeluar')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>




<script type="text/javascript">

  var idbahankeluar = "<?php echo ($idbahankeluar) ?>";

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
                      "url": "<?php echo site_url('bahankeluar/datatablesourcedetail') ?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idbahankeluar": '<?php echo ($idbahankeluar) ?>'}
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
                                        .column( 4 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return parseFloat(untitik(a)) + parseFloat(untitik(b));
                                        }, 0 );

                                    // Total Halaman Terkait
                                    pageTotal = api
                                        .column( 4, { page: 'current'} )
                                        .data()
                                        .reduce( function (a, b) {
                                            return parseFloat(untitik(a)) + parseFloat(untitik(b));
                                        }, 0 );

                                    jlhkeseluruhan = total;
                                    // Update footer
                                    $( api.column( 4 ).footer() ).html(
                                        numberWithCommas(total) + ' (KG)'
                                    );
                                    $('#total').val( numberWithCommas(total) );
                                    $('#totalberatbahan').val( numberWithCommas(total) );
                                },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 4 ], "className": 'dt-body-right'},
            { "targets": [ 5 ], "orderable": false, "className": 'dt-body-center'},
            ],

        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idbahankeluar != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("bahankeluar/get_edit_data") ?>',
              data        : {idbahankeluar: idbahankeluar},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $('#idbahankeluar').val(result.idbahankeluar);
            $('#tglbahankeluar').val(result.tglbahankeluar);
            $('#nomorkendaraan').val(result.nomorkendaraan);
            $('#keterangan').val(result.keterangan);
            $('#dikirimoleh').val(result.dikirimoleh);
            $('#diperiksaoleh').val(result.diperiksaoleh);
            $('#diterimaoleh').val(result.diterimaoleh);
          });

          $('#lbljudul').html('Edit Bahan Keluar');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Bahan Keluar');
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
        beratbahankeluar: {
          validators:{
            notEmpty: {
                message: "berat bahan tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);

    var idbahankeluar               = $('#idbahankeluar').val();
    var idbahan                      = $('#idbahan').val();
    var beratbahankeluar                      = $('#beratbahankeluar').val();

    if ( beratbahankeluar=="" || beratbahankeluar=="0" ) {
      alert("berat bahan tidak boleh kosong!!");
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
                            idbahankeluar,
                            idbahan,
                            $("#idbahan").find(":selected").text(),
                            beratbahankeluar,
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#idbahan").val("").change();
        $("#beratbahankeluar").val("");
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
    var idbahankeluar      = $("#idbahankeluar").val();
    var tglbahankeluar       = $("#tglbahankeluar").val();
    var tglbahankeluar2       = $("#tglbahankeluar2").val();
    var nomorkendaraan       = $("#nomorkendaraan").val();
    var keterangan       = $("#keterangan").val();
    var dikirimoleh       = $("#dikirimoleh").val();
    var diperiksaoleh       = $("#diperiksaoleh").val();
    var diterimaoleh       = $("#diterimaoleh").val();

    var totalberatbahan       = $("#totalberatbahan").val();

      if (tglbahankeluar=='') {
        alert("tgl Bahan Keluar tidak boleh kosong!!");
        return;
      }

      if (tglbahankeluar2=='') {
        alert("Jam Bahan Keluar tidak boleh kosong!!");
        return;
      }

      if (totalberatbahan=='') {
        alert("total pengadaan tidak boleh kosong!!");
        return;
      }

    if ( ! table.data().count() ) {
          alert("Detail pengadaan belum ada!!");
          return;
      }

      var isidatatable = table.data().toArray();

      var formData = {
              "idbahankeluar"       : idbahankeluar,
              "tglbahankeluar"       : tglbahankeluar,
              "tglbahankeluar2"       : tglbahankeluar2,
              "nomorkendaraan"       : nomorkendaraan,
              "keterangan"       : keterangan,
              "dikirimoleh"       : dikirimoleh,
              "diperiksaoleh"       : diperiksaoleh,
              "diterimaoleh"       : diterimaoleh,
              "totalberatbahan"       : totalberatbahan,
              "isidatatable"    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST',
                url         : '<?php echo site_url("bahankeluar/simpan") ?>',
                data        : formData,
                dataType    : 'json',
                encode      : true
            })
            .done(function(result){
                // console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo (site_url('bahankeluar')) ?>";

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
