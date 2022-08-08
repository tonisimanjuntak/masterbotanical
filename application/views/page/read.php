<?php  
    $this->load->view('header');
?>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php  
        $this->load->view('topmenu');
        $this->load->view('topbar');
        $this->load->view('hero_normal');
    ?>

    

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="<?php echo base_url('assets/ogani-master/') ?>img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php echo $rowpages->judulpages ?></h2>
                        <div class="breadcrumb__option">
                            <a href="<?php echo site_url() ?>">Home</a>
                            <a href="<?php echo site_url('shop') ?>">Page</a>
                            <span><?php echo $rowpages->judulpages ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->


    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p><?php echo $rowpages->isipages ?></p>
                </div>
                

            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    
    <?php  
        $this->load->view('footer');
    ?>

</body>

</html>