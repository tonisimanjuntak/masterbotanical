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
        $this->load->view('hero');
    ?>

    


    

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <?php  
                        $rsjenis = $this->db->query("select * from jenis where statusaktif='Aktif' order by idjenis");
                        if ($rsjenis->num_rows()>0) {
                            foreach ($rsjenis->result() as $row) {
                                if (!empty($row->gambarjenis)) {
                                    $gambarjenis = base_url('uploads/jenis/'.$row->gambarjenis);
                                }else{
                                    $gambarjenis = base_url('images/uploadimages.jpg');
                                }

                                echo '
                                    <div class="col-lg-3">
                                        <div class="categories__item set-bg" data-setbg="'.$gambarjenis.'">
                                            <h5><a href="'.site_url('shop/category/'.$this->encrypt->encode('idjenis')).'">'.$row->namajenis.'</a></h5>
                                        </div>
                                    </div>
                                ';
                            }
                        }
                    ?>

                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->


    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <?php  
                                $rsjenis = $this->db->query("select * from jenis where statusaktif='Aktif' order by namajenis");
                                if ($rsjenis->num_rows()>0) {
                                    foreach ($rsjenis->result() as $row) {
                                        echo '
                                            <li data-filter=".'.$row->idjenis.'">'.$row->namajenis.'</li>
                                        ';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row featured__filter">
                <?php
                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 8 ");
                    if ($rsproduk->num_rows()>0) {
                        foreach ($rsproduk->result() as $row) {
                            echo '
                                <div class="col-lg-3 col-md-4 col-sm-6 mix '.$row->idjenis.' fresh-meat">
                                    <div class="featured__item">
                                        <div class="featured__item__pic set-bg" data-setbg="'.base_url('uploads/produk/'.$row->gambarproduk).'">
                                            <ul class="featured__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="featured__item__text">
                                            <h6><a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'">'.$row->namaproduk.'</a></h6>
                                            <h5>$30.00</h5>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    }
                ?>

                
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="<?php echo base_url('assets/ogani-master/') ?>img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="<?php echo base_url('assets/ogani-master/') ?>img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Latest Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">

                                <?php
                                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 3 ");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '
                                                
                                                <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="" style="width: 140px; height:110px;">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>'.$row->namaproduk.'</h6>
                                                        <span>$ '.$row->lowestprice.'</span>
                                                    </div>
                                                </a>

                                            ';
                                        }
                                    }
                                ?>

                            </div>
                            <div class="latest-prdouct__slider__item">

                                <?php
                                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 3 ");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '
                                                
                                                <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="" style="width: 140px; height:110px;">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>'.$row->namaproduk.'</h6>
                                                        <span>$ '.$row->lowestprice.'</span>
                                                    </div>
                                                </a>

                                            ';
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Best Seller Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">

                                <?php
                                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 3 ");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '

                                                <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="" style="width: 140px; height:110px;">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>'.$row->namaproduk.'</h6>
                                                        <span>$ '.$row->lowestprice.'</span>
                                                    </div>
                                                </a>
                                            ';
                                        }
                                    }
                                ?>
                                

                            </div>
                            <div class="latest-prdouct__slider__item">

                                <?php
                                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 3 ");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '

                                                <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="" style="width: 140px; height:110px;">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>'.$row->namaproduk.'</h6>
                                                        <span>$ '.$row->lowestprice.'</span>
                                                    </div>
                                                </a>
                                            ';
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Comment Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">

                                <?php
                                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 3 ");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '

                                                <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="" style="width: 140px; height:110px;">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>'.$row->namaproduk.'</h6>
                                                        <span>$ '.$row->lowestprice.'</span>
                                                    </div>
                                                </a>
                                            ';
                                        }
                                    }
                                ?>

                            </div>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $rsproduk = $this->db->query("select * from v_produk where statusaktif='Aktif' order by rand() limit 3 ");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '

                                                <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="" style="width: 140px; height:110px;">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>'.$row->namaproduk.'</h6>
                                                        <span>$ '.$row->lowestprice.'</span>
                                                    </div>
                                                </a>
                                            ';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                

                <?php
                    $rsblogs = $this->db->query("select * from v_blogs where ispublish='Ya' order by rand() limit 3 ");
                    if ($rsblogs->num_rows()>0) {
                        foreach ($rsblogs->result() as $row) {
                            echo '

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="blog__item">
                                        <div class="blog__item__pic">
                                            <img src="'.base_url('uploads/blogs/'.$row->gambarblogs).'" alt="" style="height: 200px; width: 80%">
                                        </div>
                                        <div class="blog__item__text">
                                            <ul>
                                                <li><i class="fa fa-calendar-o"></i> '.date('Y-M-d', strtotime($row->tglinsert)).'</li>
                                                <li><i class="fa fa-comment-o"></i> 5</li>
                                            </ul>
                                            <h5><a href="#">'.$row->judulblogs.'</a></h5>
                                        </div>
                                    </div>
                                </div>

                            ';
                        }
                    }
                ?>

            </div>
        </div>
    </section>
    <!-- Blog Section End -->


    
    <?php  
        $this->load->view('footer');
    ?>


</body>

</html>