<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Penerimaan Umum</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('penerimaanumum')) ?>">Penerimaan Umum</a></li>
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


                  <input type="hidden" name="idpenerimaanumum" id="idpenerimaanumum">

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Tanggal</label>
                    <div class="col-md-4">
                      <input type="date" name="tglpenerimaanumum" id="tglpenerimaanumum" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                  </div>
                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Keterangan</label>
                    <div class="col-md-10">
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"></textarea>
                    </div>
                  </div>
                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Total Penerimaan</label>
                    <div class="col-md-4">
                      <input type="text" name="totalpenerimaanumum" id="totalpenerimaanumum" class="form-control rupiah" readonly="">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                          <h3 class="text-muted text-center">Detail Penerimaan</h3>
                          <hr>


                          <form action="<?php echo (site_url('penerimaanumum/simpan')) ?>" method="post" id="form">
                            <div class="row">

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Nama Akun Penerimaan</label>
                                    <select name="kdakun4" id="kdakun4" class="form-control select2">
                                      <option value="">---Pilih akun penerimaan---</option>
                                      <?php
$rs = $this->db->query("select * from akun4 where left(kdakun4,1)='4' order by kdakun4");
foreach ($rs->result() as $row) {
    echo '<option value="' . $row->kdakun4 . '">' . $row->namaakun4 . '</option>';
}
?>
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="">Jumlah Penerimaan</label>
                                  <input type="text" name="jumlahpenerimaan" id="jumlahpenerimaan" class="form-control dollar">
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
                                        <th style="">idpenerimaanumum</th>
                                        <th style="">kdakun4</th>
                                        <th style="">Nama Akun</th>
                                        <th style="text-align: right;">Jumlah Penerimaan</th>
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
                <a href="<?php echo (site_url('penerimaanumum')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>




<script type="text/javascript">

  var idpenerimaanumum = "<?php echo ($idpenerimaanumum) ?>";

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
                      "url": "<?php echo site_url('penerimaanumum/datatablesourcedetail') ?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idpenerimaanumum": '<?php echo ($idpenerimaanumum) ?>'}
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
                                        .column( 4 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0 );

                                    // Total Halaman Terkait
                                    pageTotal = api
                                        .column( 4, { page: 'current'} )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0 );

                                    jlhkeseluruhan = total;
                                    // Update footer
                                    $( api.column( 4 ).footer() ).html(
                                         format_dollar(total,2)
                                    );
                                    $('#total').val( format_dollar(total) );
                                    $('#totalpenerimaanumum').val( format_dollar(total) );
                                },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 4 ], "className": 'dt-body-right'},
            { "targets": [ 5 ], "orderable": false, "className": 'dt-body-center'},
            ],

        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpenerimaanumum != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Penerimaanumum/get_edit_data") ?>',
              data        : {idpenerimaanumum: idpenerimaanumum},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $('#idpenerimaanumum').val(result.idpenerimaanumum);
            $('#tglpenerimaanumum').val(result.tglpenerimaanumum);
            $('#keterangan').val(result.keterangan);
            $('#totalpenerimaanumum').val(result.totalpenerimaanumum);
          });

          $('#lbljudul').html('Edit Data Penerimaan Umum');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Penerimaan Umum');
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
        kdakun4: {
          validators:{
            notEmpty: {
                message: "nama akun tidak boleh kosong"
            },
          }
        },
        jumlahpenerimaan: {
          validators:{
            notEmpty: {
                message: "jumlah penerimaan tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);

    var idpenerimaanumum               = $('#idpenerimaanumum').val();
    var kdakun4                      = $('#kdakun4').val();
    var jumlahpenerimaan           = $('#jumlahpenerimaan').val();

        if (kdakun4=="") {
          alert("kdakun4 tidak boleh kosong!!");
          return false;
        }

        if (jumlahpenerimaan=="") {
          alert("jumlahpenerimaan tidak boleh kosong!!");
          return false;
        }

      var isicolomn = table.columns(2).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {
          if (isicolomn[i][j] === kdakun4) {
              alert("kdakun4 sudah ada!!");
              return false;
          }
        }
      };

        nomorrow = table.page.info().recordsTotal + 1;
        table.row.add( [
                            nomorrow,
                            $("#idpenerimaanumum").val(),
                            $("#kdakun4").val(),
                            $("#kdakun4").find(":selected").text(),
                            $("#jumlahpenerimaan").val(),
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#kdakun4").val("").change();
        $("#jumlahpenerimaan").val("");
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
    var idpenerimaanumum       = $("#idpenerimaanumum").val();
    var tglpenerimaanumum       = $("#tglpenerimaanumum").val();
    var keterangan       = $("#keterangan").val();
    var totalpenerimaanumum       = $("#totalpenerimaanumum").val();


      if (tglpenerimaanumum=='') {
        alert("tglpenerimaanumum tidak boleh kosong!!");
        return;
      }

      if (keterangan=='') {
        alert("keterangan tidak boleh kosong!!");
        return;
      }

      if (totalpenerimaanumum=='') {
        alert("totalpenerimaanumum tidak boleh kosong!!");
        return;
      }

    if ( ! table.data().count() ) {
          alert("Detail Penerimaan belum ada!!");
          return;
      }

      var isidatatable = table.data().toArray();

      var formData = {
              "idpenerimaanumum"       : idpenerimaanumum,
              "tglpenerimaanumum"       : tglpenerimaanumum,
              "keterangan"       : keterangan,
              "totalpenerimaanumum"       : totalpenerimaanumum,
              "total"           : total,
              "isidatatable"    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST',
                url         : '<?php echo site_url("Penerimaanumum/simpan") ?>',
                data        : formData,
                dataType    : 'json',
                encode      : true
            })
            .done(function(result){
                console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo (site_url('penerimaanumum')) ?>";

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
