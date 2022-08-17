  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo (base_url()) ?>" class="brand-link navbar-navy text-light text-sm">
      <img src="<?php echo (base_url('../images/logo-text.jpg')) ?>" alt="AdminLTE Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <!-- <span class="brand-text font-weight-light">BOTANICAL</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar text-sm">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $this->session->userdata('foto'); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('namapengguna'); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="<?php echo (site_url('dashboardmanagement')) ?>" class="nav-link <?php echo ($menu == 'dashboardmanagement') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard Management
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="<?php echo (site_url('dashboardvisitor')) ?>" class="nav-link <?php echo ($menu == 'dashboardvisitor') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard Visitor
              </p>
            </a>
          </li>



<?php
$menudropdown = array("slider", "pages", "tabinfo", "whychooseus", "faq", "happyclient", "bestseller", "sosialmedia", "news", "video", "gallery", "consultation");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-blog"></i>
              <p>
                Web Managemen
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">



                  <?php
$menudropdown = array("slider", "tabinfo", "whychooseus", "faq", "happyclient", "bestseller", "sosialmedia", "video", "gallery", "consultation");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

                  <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
                      <i class="nav-icon fas fa-bars"></i>
                      <p>
                        Home/ Halaman Utama
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                          <li class="nav-item">
                            <a href="<?php echo (site_url("slider")) ?>" class="nav-link <?php echo ($menu == 'slider') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Sliders</p>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="<?php echo (site_url("tabinfo")) ?>" class="nav-link <?php echo ($menu == 'tabinfo') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>3 Tab Info</p>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="<?php echo (site_url("whychooseus")) ?>" class="nav-link <?php echo ($menu == 'whychooseus') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Why Choose Us</p>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="<?php echo (site_url("faq")) ?>" class="nav-link <?php echo ($menu == 'faq') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>FAQ</p>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="<?php echo (site_url("happyclient")) ?>" class="nav-link <?php echo ($menu == 'happyclient') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Happy Client Review</p>
                            </a>
                          </li>


                          <li class="nav-item">
                            <a href="<?php echo (site_url("bestseller")) ?>" class="nav-link <?php echo ($menu == 'bestseller') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Best Seller</p>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="<?php echo (site_url("sosialmedia")) ?>" class="nav-link <?php echo ($menu == 'sosialmedia') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Sosial Media</p>
                            </a>
                          </li>


                          <li class="nav-item">
                            <a href="<?php echo (site_url("video")) ?>" class="nav-link <?php echo ($menu == 'video') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Setting Video</p>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="<?php echo (site_url("gallery")) ?>" class="nav-link <?php echo ($menu == 'gallery') ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Gallery</p>
                            </a>
                          </li>

                    </ul>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("pages")) ?>" class="nav-link <?php echo ($menu == 'pages') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pages/ Halaman</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("news")) ?>" class="nav-link <?php echo ($menu == 'news') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>News</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("consultation")) ?>" class="nav-link <?php echo ($menu == 'consultation') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Consultation</p>
                    </a>
                  </li>

                  <!-- <li class="nav-item">
                    <a href="<?php echo (site_url("sliders")) ?>" class="nav-link <?php echo ($menu == 'sliders') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Galery</p>
                    </a>
                  </li> -->

                  <!-- <li class="nav-item">
                    <a href="<?php echo (site_url("company")) ?>" class="nav-link <?php echo ($menu == 'company') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Informasi Usaha</p>
                    </a>
                  </li> -->



            </ul>
          </li>



          <?php
$menudropdown = array("pengguna", "karyawan", "jenis", "produk", "bahan", "produkbahan", "jasapengiriman", "konsumen", "supplier", "bank", "batchnumber");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="<?php echo (site_url("pengguna")) ?>" class="nav-link <?php echo ($menu == 'pengguna') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pengguna</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("karyawan")) ?>" class="nav-link <?php echo ($menu == 'karyawan') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Karyawan</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("jenis")) ?>" class="nav-link <?php echo ($menu == 'jenis') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jenis Produk</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("produk")) ?>" class="nav-link <?php echo ($menu == 'produk') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Produk</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("batchnumber")) ?>" class="nav-link <?php echo ($menu == 'batchnumber') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Batchnumber</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("bahan")) ?>" class="nav-link <?php echo ($menu == 'bahan') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Bahan</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("jasapengiriman")) ?>" class="nav-link <?php echo ($menu == 'jasapengiriman') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Jasa Pengiriman</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("bank")) ?>" class="nav-link <?php echo ($menu == 'bank') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Bank Transfer</p>
                    </a>
                  </li>

                  <!-- <li class="nav-item">
                    <a href="<?php echo (site_url("konsumen")) ?>" class="nav-link <?php echo ($menu == 'konsumen') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Konsumen</p>
                    </a>
                  </li> -->

                  <li class="nav-item">
                    <a href="<?php echo (site_url("supplier")) ?>" class="nav-link <?php echo ($menu == 'supplier') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Supplier</p>
                    </a>
                  </li>


            </ul>
          </li>




          <?php
$menudropdown = array("pengadaanbahan", "pengadaanproduk", "produksiproduk", "pemeriksaanlab", "packing", "penggilingan", "bahankeluar");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Produksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


                  <li class="nav-item">
                    <a href="<?php echo (site_url("pengadaanbahan")) ?>" class="nav-link <?php echo ($menu == 'pengadaanbahan') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pengadaan Bahan</p>
                    </a>
                  </li>


                  <?php
$menudropdown = array("bahankeluar", "penggilingan");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>
                  <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
                          <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                              Penggilingan
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">

                              <li class="nav-item">
                                <a href="<?php echo (site_url("bahankeluar")) ?>" class="nav-link <?php echo ($menu == 'bahankeluar') ? 'active' : '' ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Bahan Keluar</p>
                                </a>
                              </li>

                              <li class="nav-item">
                                <a href="<?php echo (site_url("penggilingan")) ?>" class="nav-link <?php echo ($menu == 'penggilingan') ? 'active' : '' ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Penggilingan</p>
                                </a>
                              </li>
                          </ul>
                  </li>



                  <li class="nav-item">
                    <a href="<?php echo (site_url("produksiproduk")) ?>" class="nav-link <?php echo ($menu == 'produksiproduk') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Produksi</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("pengadaanproduk")) ?>" class="nav-link <?php echo ($menu == 'pengadaanproduk') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pengadaan Produk</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("pemeriksaanlab")) ?>" class="nav-link <?php echo ($menu == 'pemeriksaanlab') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pemeriksaan Lab</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("packing")) ?>" class="nav-link <?php echo ($menu == 'packing') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Packing</p>
                    </a>
                  </li>



            </ul>
          </li>


          <?php
$menudropdown = array("penjualan", "penjualankonfirmasi", "penjualanpengiriman", "lappenjualan");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">



                  <li class="nav-item">
                    <a href="<?php echo (site_url("penjualan")) ?>" class="nav-link <?php echo ($menu == 'penjualan') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Penjualan</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("penjualankonfirmasi")) ?>" class="nav-link <?php echo ($menu == 'penjualankonfirmasi') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Konfirmasi Penjualan</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("penjualanpengiriman")) ?>" class="nav-link <?php echo ($menu == 'penjualanpengiriman') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pengiriman Penjualan</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="<?php echo (site_url("lappenjualan")) ?>" class="nav-link <?php echo ($menu == 'lappenjualan') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Laporan Penjualan</p>
                    </a>
                  </li>



            </ul>
          </li>





          <?php
$menudropdown = array("penerimaanumum", "pengeluaranumum", "lappenerimaanumum", "lappengeluaranumum");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Transaksi Umum
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">



                  <li class="nav-item">
                    <a href="<?php echo (site_url("penerimaanumum")) ?>" class="nav-link <?php echo ($menu == 'penerimaanumum') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Penerimaaan Umum</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("pengeluaranumum")) ?>" class="nav-link <?php echo ($menu == 'pengeluaranumum') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pengeluaran Umum</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lappenerimaanumum")) ?>" class="nav-link <?php echo ($menu == 'lappenerimaanumum') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Laporan Penerimaan Umum</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lappengeluaranumum")) ?>" class="nav-link <?php echo ($menu == 'lappengeluaranumum') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Laporan Pengeluaran Umum</p>
                    </a>
                  </li>





            </ul>
          </li>




          <?php
$menudropdown = array("jurnalpenyesuaian", "lapbukukasumum", "lapjurnalumum", "lapbukubesar", "laplabarugi", "lapperubahanmodal", "lapneraca");
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Akuntansi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


                  <li class="nav-item">
                    <a href="<?php echo (site_url("jurnalpenyesuaian")) ?>" class="nav-link <?php echo ($menu == 'jurnalpenyesuaian') ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jurnal Penyesuaian</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lapbukukasumum")) ?>" class="nav-link <?php echo ($menu == 'lapbukukasumum') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Lap. Buku Kas Umum</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lapjurnalumum")) ?>" class="nav-link <?php echo ($menu == 'lapjurnalumum') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Lap. Jurnal Umum</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lapbukubesar")) ?>" class="nav-link <?php echo ($menu == 'lapbukubesar') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Lap. Buku Besar</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("laplabarugi")) ?>" class="nav-link <?php echo ($menu == 'laplabarugi') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Lap. Laba Rugi</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lapperubahanmodal")) ?>" class="nav-link <?php echo ($menu == 'lapperubahanmodal') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Lap. Perubahan Modal</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo (site_url("lapneraca")) ?>" class="nav-link <?php echo ($menu == 'lapneraca') ? 'active' : '' ?>">
                      <i class="fas fa-print nav-icon"></i>
                      <p>Lap. Neraca</p>
                    </a>
                  </li>






            </ul>
          </li>


          <li class="nav-item">
            <a href="<?php echo (site_url('Login/keluar')) ?>" class="nav-link text-warning">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>




        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
