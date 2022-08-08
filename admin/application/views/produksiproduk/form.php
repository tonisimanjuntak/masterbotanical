<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Produksi Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('produksiproduk')) ?>">Produksi Produk</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
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


                  <input type="hidden" name="idproduksi" id="idproduksi">

                  <div class="row">

                    <div class="col-12">



                      <section class="container py-4">
                          <div class="row">
                              <div class="col-md-12">
                                  <ul id="tabs" class="nav nav-tabs">
                                      <li class="nav-item"><a href="" data-target="#pageinformasiproduksi" data-toggle="tab" class="nav-link small text-uppercase active">Informasi Produksi</a></li>
                                      <li class="nav-item"><a href="" data-target="#pagekaryawan" data-toggle="tab" class="nav-link small text-uppercase">Data Karyawan Yang Bekerja</a></li>
                                      <li class="nav-item"><a href="" data-target="#pagedetailbahan" data-toggle="tab" class="nav-link small text-uppercase">Detail Bahan Yang Digunakan</a></li>
                                  </ul>
                                  <br>
                                  <div id="tabsContent" class="tab-content">


                                      <!-- ===============================================================================  -->
                                      <!--                                      PAGE 1                                      -->
                                      <!-- ===============================================================================  -->
                                      <div id="pageinformasiproduksi" class="tab-pane fade active show">

                                        <div class="row">

                                          <div class="col-12 pl-3 pr-3">

                                              <div class="form-group row required">
                                                <label for="" class="col-md-4 col-form-label">Tanggal</label>
                                                <div class="col-md-6">
                                                  <input type="date" name="tglproduksi" id="tglproduksi" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                                </div>
                                              </div>

                                              <div class="form-group row required">
                                                <label for="" class="col-md-4 col-form-label">Cara Produksi</label>
                                                <div class="col-md-6">
                                                  <select name="caraproduksi" id="caraproduksi" class="form-control">
                                                    <option value="">Pilih cara produksi...</option>
                                                    <option value="Microwave">Microwave</option>
                                                    <option value="Gamma">Gamma</option>
                                                  </select>
                                                </div>
                                              </div>


                                              <div class="form-group row required">
                                                <label for="" class="col-md-4 col-form-label">Keterangan</label>
                                                <div class="col-md-8">
                                                  <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Masukkan keterangan"></textarea>
                                                </div>
                                              </div>


                                              <div class="form-group row required">
                                                <label for="" class="col-md-4 col-form-label">Hasil Produksi</label>
                                                <div class="col-md-8">
                                                  <select name="idproduk" id="idproduk" class="form-control select2">
                                                    <option value="">Pilih nama produk...</option>
                                                    <?php
$rsproduk = $this->db->query("select * from produk order by namaproduk");
if ($rsproduk->num_rows() > 0) {
    foreach ($rsproduk->result() as $row) {
        echo '
                                                            <option value="' . $row->idproduk . '">' . $row->namaproduk . '</option>
                                                          ';
    }
}
?>
                                                  </select>
                                                </div>
                                              </div>

                                              <div class="form-group row required">
                                                <label for="" class="col-md-4 col-form-label">Berat Bruto</label>
                                                <div class="col-md-4">
                                                  <input type="text" name="beratbruto" id="beratbruto" class="form-control berat">
                                                </div>
                                              </div>

                                              <div class="form-group row required">
                                                <label for="" class="col-md-4 col-form-label">Berat Netto</label>
                                                <div class="col-md-4">
                                                  <input type="text" name="beratnetto" id="beratnetto" class="form-control berat">
                                                </div>
                                              </div>


                                          </div> <!-- col-12 -->


                                        </div> <!-- row -->



                                      </div>




                                      <!-- ===============================================================================  -->
                                      <!--                                      PAGE 2                                      -->
                                      <!-- ===============================================================================  -->
                                      <div id="pagekaryawan" class="tab-pane fade">

                                          <h3 class="text-muted text-center">Detail Karyawan Yang Mengerjakan Produksi</h3>
                                          <hr>


                                          <form action="<?php echo (site_url('produksiproduk/karyawan')) ?>" method="post" id="formkaryawan">
                                            <div class="row">

                                              <div class="col-md-4">
                                                <div class="form-group row">
                                                  <label for="" class="col-md-12">Nama Karyawan</label>

                                                  <div class="col-md-12">

                                                    <select name="idkaryawan" id="idkaryawan" class="form-control">
                                                      <option value="">---Pilih nama karyawan---</option>
                                                      <?php
$rskaryawan = $this->db->query("select * from karyawan order by namakaryawan");
if ($rskaryawan->num_rows() > 0) {
    foreach ($rskaryawan->result() as $row) {
        echo '<option value="' . $row->idkaryawan . '">' . $row->namakaryawan . '</option>';
    }
}

?>
                                                    </select>

                                                  </div>
                                                </div>
                                              </div>



                                              <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="">Jabatan</label>
                                                  <select name="jabatan" id="jabatan" class="form-control">
                                                    <option value="">Pilih jabatan...</option>
                                                    <option value="Mandor">Mandor</option>
                                                    <option value="Karyawan">Karyawan</option>
                                                  </select>
                                                </div>
                                              </div>

                                              <div class="col-md-2 mt-1">
                                                <button class="btn btn-primary btn-block mt-4" type="submit" id="tambahkankaryawan">Tambahkan</button>
                                              </div>


                                            </div>
                                          </form>

                                            <hr>

                                          <div class="table-responsive">
                                            <table id="tablekaryawan" class="display" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%; text-align: center;">No</th>
                                                        <th style="">idproduksi</th>
                                                        <th style="">idkaryawan</th>
                                                        <th style="">Nama Karyawan</th>
                                                        <th style="">Jabatan</th>
                                                        <th style="width: 5%; text-align: center;">Hapus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                          </div>

                                      </div>






                                      <!-- ===============================================================================  -->
                                      <!--                                      PAGE 3                                      -->
                                      <!-- ===============================================================================  -->
                                      <div id="pagedetailbahan" class="tab-pane fade">


                                          <h3 class="text-muted text-center">Detail Penggunaan Bahan</h3>
                                          <hr>


                                          <form action="<?php echo (site_url('produksiproduk/simpan')) ?>" method="post" id="form">
                                            <div class="row">

                                              <div class="col-md-4">
                                                <div class="form-group row">
                                                  <label for="" class="col-md-12">Nama Bahan</label>

                                                  <div class="col-md-12">

                                                    <select name="idbahan" id="idbahan" class="form-control">
                                                      <option value="">---Pilih nama bahan---</option>
                                                      <?php
$rsbahan = $this->db->query("select idbahan, namabahan, beratnetto*qty as beratnettosisa from v_pengadaanbahandetail
                  group by idbahan, namabahan");
if ($rsbahan->num_rows() > 0) {
    foreach ($rsbahan->result() as $row) {
        echo '<option value="' . $row->idbahan . '">' . $row->namabahan . '</option>';
    }
}

?>
                                                    </select>

                                                  </div>
                                                </div>
                                              </div>



                                              <div class="col-md-2">
                                                <div class="form-group">
                                                  <label for="">Berat Netto</label>
                                                  <input type="text" name="beratnettobahan" id="beratnettobahan" class="form-control berat">
                                                </div>
                                              </div>


                                              <div class="col-md-2 mt-1">
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
                                                        <th style="">idproduksi</th>
                                                        <th style="">idbahan</th>
                                                        <th style="">Nama Bahan</th>
                                                        <th style="text-align: center;">Berat Netto</th>
                                                        <th style="width: 5%; text-align: center;">Hapus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                          </div>



                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section>


                    </div>





                  </div>




              </div> <!-- ./card-body -->

              <div class="card-footer">
                <button class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('produksiproduk')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>




<script type="text/javascript">

  var idproduksi = "<?php echo ($idproduksi) ?>";

  $(document).ready(function() {

    // $('.select2').select2();

    $('.select2_1').addClass('form-control');
        $('.select2_1').select2();

    table = $('#table').DataTable({
        "select": true,
            "processing": true,
            "ordering": false,
            "bPaginate": false,
            "searching": false,
            "bInfo" : false,
             "ajax"  : {
                      "url": "<?php echo site_url('produksiproduk/datatablesourcedetail') ?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idproduksi": '<?php echo ($idproduksi) ?>'}
                  },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 4 ], "className": 'dt-body-center'},
            { "targets": [ 5 ], "orderable": false, "className": 'dt-body-center'},
            ],

        });


    tablekaryawan = $('#tablekaryawan').DataTable({
        "select": true,
            "processing": true,
            "ordering": false,
            "bPaginate": false,
            "searching": false,
            "bInfo" : false,
             "ajax"  : {
                      "url": "<?php echo site_url('produksiproduk/datatablesourcedetailkaryawan') ?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"idproduksi": '<?php echo ($idproduksi) ?>'}
                  },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 5 ], "orderable": false, "className": 'dt-body-center'},
            ],

        });





    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idproduksi != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("produksiproduk/get_edit_data") ?>',
              data        : {idproduksi: idproduksi},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $('#idproduksi').val(result.idproduksi);
            $('#tglproduksi').val(result.tglproduksi);
            $('#idproduk').val(result.idproduk).trigger('change');
            $('#keterangan').val(result.keterangan);
            $('#caraproduksi').val(result.caraproduksi);
            $('#beratbruto').val(result.beratbruto);
            $('#beratnetto').val(result.beratnetto);
          })
          .fail(function() {
            console.log("error");
          });


          $('#lbljudul').html('Edit Data Produksi');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Produksi');
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
        beratnetto: {
          validators:{
            notEmpty: {
                message: "berat netto tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);

    var idproduksi               = $('#idproduksi').val();
    var idbahan                      = $('#idbahan').val();
    var beratnettobahan                      = $('#beratnettobahan').val();

    console.log("Berat Netto = " + $('#beratnettobahan').val());

      var isicolomn = table.columns(2).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {
          if (isicolomn[i][j] === idbahan) {
              alert("nama bahan ini sudah ada!!");
              return false;
          }
        }
      };

      if (beratnettobahan=="") {
        alert("beratnettobahan tidak boleh kosong!!");
        return false;
      }

        nomorrow = table.page.info().recordsTotal + 1;
        table.row.add( [
                            nomorrow,
                            idproduksi,
                            idbahan,
                            $("#idbahan").find(":selected").text(),
                            $('#beratnettobahan').val(),
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#idbahan").val("").change();
        $("#beratnettobahan").val("");
    });
  //------------------------------------------------------------------------>



  //----------------------------------------------------------------- > validasi
    $('#formkaryawan').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        idkaryawan: {
          validators:{
            notEmpty: {
                message: "nama karyawan tidak boleh kosong"
            },
          }
        },
        jabatan: {
          validators:{
            notEmpty: {
                message: "jabatan tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      $('#tambahkan').attr('disabled', false);

    var idproduksi               = $('#idproduksi').val();
    var idkaryawan                      = $('#idkaryawan').val();
    var jabatan                      = $('#jabatan').val();


      var isicolomn = tablekaryawan.columns(2).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {
          if (isicolomn[i][j] === idkaryawan) {
              alert("nama karyawan sudah ada!!");
              return false;
          }
        }
      };

      if (jabatan=="") {
        alert("jabatan tidak boleh kosong!!");
        return false;
      }

        nomorrow = tablekaryawan.page.info().recordsTotal + 1;
        tablekaryawan.row.add( [
                            nomorrow,
                            idproduksi,
                            idkaryawan,
                            $("#idkaryawan").find(":selected").text(),
                            $('#jabatan').val(),
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $("#idkaryawan").val("").change();
        $("#jabatan").val("");
    });
  //------------------------------------------------------------------------>



    $('#table tbody').on( 'click', 'span', function () {
        table
            .row( $(this).parents('tr') )
            .remove()
            .draw();
    });

    $('#tablekaryawan tbody').on( 'click', 'span', function () {
        tablekaryawan
            .row( $(this).parents('tr') )
            .remove()
            .draw();
    });


    $("form").attr('autocomplete', 'off');
    // $('#tglterima').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    // $('#hargabelisatuan').mask('000,000,000,000', {reverse: true, placeholder:"000,000,000,000"});
  }); //end (document).ready


  $('#simpan').click(function(){
    var idproduksi      = $("#idproduksi").val();
    var idproduk            = $("#idproduk").val();
    var tglproduksi       = $("#tglproduksi").val();
    var caraproduksi       = $("#caraproduksi").val();
    var keterangan       = $("#keterangan").val();
    var beratbruto       = $("#beratbruto").val();
    var beratnetto       = $("#beratnetto").val();




      if (tglproduksi=='') {
        alert("tgl pengadaan bahan tidak boleh kosong!!");
        return;
      }

      if (caraproduksi=='') {
        alert("cara produksi bahan tidak boleh kosong!!");
        return;
      }

      if (idproduk=='') {
        alert("nama produk tidak boleh kosong!!");
        return;
      }

      if (beratbruto=='') {
        alert("berat bruto tidak boleh kosong!!");
        return;
      }

      if (idproduk=='') {
        alert("berat netto tidak boleh kosong!!");
        return;
      }

      if (keterangan=='') {
        alert("keterangan tidak boleh kosong!!");
        return;
      }


    if ( ! table.data().count() ) {
          alert("Detail bahan yang digunakan belum ada!!");
          return;
      }

    if ( ! tablekaryawan.data().count() ) {
          alert("Nama karyawan yang mengerjakan produksi belum ada!!");
          return;
      }

      var isidatatable = table.data().toArray();
      var isidatatablekaryawan = tablekaryawan.data().toArray();

      var formData = {
              "idproduksi"       : idproduksi,
              "idproduk"       : idproduk,
              "tglproduksi"       : tglproduksi,
              "caraproduksi"       : caraproduksi,
              "keterangan"       : keterangan,
              "beratbruto"       : beratbruto,
              "beratnetto"       : beratnetto,
              "isidatatable"    : isidatatable,
              "isidatatablekaryawan"    : isidatatablekaryawan
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST',
                url         : '<?php echo site_url("produksiproduk/simpan") ?>',
                data        : formData,
                dataType    : 'json',
                encode      : true
            })
            .done(function(result){
                console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo (site_url('produksiproduk')) ?>";

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
