
    <footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
						<h2 class="footer-heading">Master Botanical</h2>
						<p>Visit and follow our social media for more information, and update information</p>
						<ul class="ftco-footer-social p-0">
              <li class="ftco-animate"><a href="<?php echo $rowsosialmedia->urltwitter ?>" data-toggle="tooltip" data-placement="top" title="Twitter" target="_blank"><span class="fa fa-twitter"></span></a></li>
              <li class="ftco-animate"><a href="<?php echo $rowsosialmedia->urlfacebook ?>" data-toggle="tooltip" data-placement="top" title="Facebook" target="_blank"><span class="fa fa-facebook"></span></a></li>
              <li class="ftco-animate"><a href="<?php echo $rowsosialmedia->urlinstagram ?>" data-toggle="tooltip" data-placement="top" title="Instagram" target="_blank"><span class="fa fa-instagram"></span></a></li>
              <li class="ftco-animate"><a href="<?php echo $rowsosialmedia->urlyoutube ?>" data-toggle="tooltip" data-placement="top" title="Youtube" target=
                "_blank"><span class="fa fa-youtube"></span></a></li>
              <li class="ftco-animate"><a href="<?php echo $rowsosialmedia->urllinkedin ?>" data-toggle="tooltip" data-placement="top" title="LinkedIn" target=
                "_blank"><span class="fa fa-linkedin"></span></a></li>
              <li class="ftco-animate"><a href="<?php echo $rowsosialmedia->urltiktok ?>" data-toggle="tooltip" data-placement="top" title="Tiktok" target=
                "_blank"><span class="fa fa-music"></span></a></li>
            </ul>
					</div>
					<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
						<h2 class="footer-heading">Latest News</h2>

            <?php  
              $rsnewsfooter = $this->db->query("select * from v_news where ispublish='Ya' order by tglinsert desc limit 2");
              if ( $rsnewsfooter->num_rows()>0 ) {
                foreach ($rsnewsfooter->result() as $row) {
                  if (!empty($row->gambarsampul)) {
                    $gambarsampul = base_url('uploads/news/'.$row->gambarsampul);
                  }else{
                    $gambarsampul = 'images/nofoto.png';
                  }
                  echo '
                    <div class="block-21 mb-4 d-flex">
                      <a class="img mr-4 rounded" style="background-image: url('.$gambarsampul.');"></a>
                      <div class="text">
                        <h3 class="heading"><a href="'.site_url('news/read/'.$row->judulnewsseo).'">'.$row->judulnews.'</a></h3>
                        <div class="meta">
                          <div><a href="#"><span class="icon-calendar"></span> '.date('M d, Y', strtotime($row->tglinsert)).'</a></div>
                          <div><a href="#"><span class="icon-person"></span> '.$row->namapengguna.'</a></div>                          
                        </div>
                      </div>
                    </div>
                  ';
                }
              }
            ?>
						

            
					</div>
					<div class="col-md-6 col-lg-3 pl-lg-5 mb-4 mb-md-0">
						<h2 class="footer-heading">Quick Links</h2>
						<ul class="list-unstyled">
              <li><a href="<?php echo site_url() ?>" class="py-2 d-block">Home</a></li>
              <li><a href="<?php echo site_url('shop') ?>" class="py-2 d-block">Shop</a></li>
              <li><a href="<?php echo site_url('chart') ?>" class="py-2 d-block">Cart</a></li>
              <li><a href="<?php echo site_url('news') ?>" class="py-2 d-block">News</a></li>
              
            </ul>
					</div>
					<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
						<h2 class="footer-heading">Have a Questions?</h2>
						<div class="block-23 mb-3">
              <ul>
                <!-- <li><span class="icon fa fa-map"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li> -->
                <li><a href="#"><span class="icon fa fa-whatsapp"></span><span class="text"><?php echo $rowsosialmedia->notelp ?></span></a></li>
                <li><a href="#"><span class="icon fa fa-whatsapp"></span><span class="text"><?php echo $rowsosialmedia->notelp2 ?></span></a></li>
                <li><a href="#"><span class="icon fa fa-whatsapp"></span><span class="text"><?php echo $rowsosialmedia->notelp3 ?></span></a></li>
                <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text"><?php echo $rowsosialmedia->email ?></span></a></li>
              </ul>
            </div>
					</div>
				</div>
				<div class="row mt-5">
          <div class="col-md-12 text-center">

            <p class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
			</div>
		</footer>

    
<?php  if (!empty($this->session->userdata('idkonsumen'))) { ?>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/62d36ec97b967b117999e40c/1g84uhhjv';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
<?php } ?>





  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/popper.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.easing.1.3.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.waypoints.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.stellar.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.animateNumber.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.timepicker.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/owl.carousel.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <!-- <script src="<?php echo base_url('assets/petsitting-master/') ?>js/google-map.js"></script> -->
  <script src="<?php echo base_url('assets/petsitting-master/') ?>js/main.js"></script>

     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

    
  <script src="<?php echo(base_url('assets/')) ?>sweetalert/sweetalert.min.js"></script>
  <script src="<?php echo(base_url('admin/assets/')) ?>bootstrap-validator/js/bootstrapValidator.js"></script>
  

  <script>
  
  $('.carousel').carousel({
    interval: 5000,
    pause: false
  })

  </script>

  <?php  
    $pesan = $this->session->flashdata("pesan");
      if (!empty($pesan)) {
        echo $pesan;
      }
  ?>