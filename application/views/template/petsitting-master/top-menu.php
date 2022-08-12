	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	    	<a class="navbar-brand" href="<?php echo site_url() ?>"><img src="<?php echo site_url('images/logo.jpg') ?>" alt="" style="max-height: 60px;"></span> MASTER BOTANICAL</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	        	<li class="nav-item <?php echo ($menu == 'homepetsitting') ? 'active' : '' ?>"><a href="<?php echo site_url() ?>" class="nav-link">Home</a></li>
	        	<!-- <li class="nav-item"><a href="<?php echo site_url('page/aboutus') ?>" class="nav-link">About</a></li> -->
	        	<li class="nav-item <?php echo ($menu == 'shop') ? 'active' : '' ?>"><a href="<?php echo site_url('shop') ?>" class="nav-link">Shop</a></li>	        	
	        	<li class="nav-item <?php echo ($menu == 'chart') ? 'active' : '' ?>"><a href="<?php echo site_url('chart') ?>" class="nav-link">Cart</a></li>
	          	<li class="nav-item <?php echo ($menu == 'news') ? 'active' : '' ?>"><a href="<?php echo site_url('news') ?>" class="nav-link">News</a></li>
	          	<?php  
	          		if (!empty($this->session->userdata('idkonsumen'))) {
	          			echo '
	          				<li class="nav-item dropdown">
						        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						          My Account
						        </a>
						        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
						          <a class="dropdown-item" href="'.site_url('myaccount').'">My Account Information</a>
						          <a class="dropdown-item" href="'.site_url('myaccount/orderhistory').'">Order History</a>
						          <a class="dropdown-item" href="'.site_url('myaccount/changepassword').'">Change Password</a>
						          <div class="dropdown-divider"></div>
						          <a class="dropdown-item" href="'.site_url('login/keluar').'">Logout</a>
						        </div>
						      </li>
	          			';
	          		}else{
	          			echo '
	          				<li class="nav-item"><a href="'.site_url('login').'" class="nav-link">Login</a></li>
	          			';
	          		}
	          	?>

	          	
	        </ul>
	      </div>
	    </div>
	  </nav>