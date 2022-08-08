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
                        <h2>Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Category</h4>
                            <ul>
                                <?php  
                                    $rsjenis = $this->db->query("select * from jenis order by idjenis");
                                    if ($rsjenis->num_rows()>0) {
                                        foreach ($rsjenis->result() as $row) {
                                            echo '
                                                <li><a href="#">'.$row->namajenis.'</a></li>                                                
                                            ';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>

                        
                        
                    
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Latest Products</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <div class="latest-prdouct__slider__item">

                                        <?php  
                                            $rsproduk = $this->db->query("select * from v_produk order by idproduk desc limit 3");
                                            if ($rsproduk->num_rows()>0) {
                                                foreach ($rsproduk->result() as $row) {
                                                    echo '
                                                        <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                            <div class="latest-product__item__pic">
                                                                <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="">
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
                                            $rsproduk = $this->db->query("select * from v_produk order by rand() limit 3");
                                            if ($rsproduk->num_rows()>0) {
                                                foreach ($rsproduk->result() as $row) {
                                                    echo '
                                                        <a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'" class="latest-product__item">
                                                            <div class="latest-product__item__pic">
                                                                <img src="'.base_url('uploads/produk/'.$row->gambarproduk).'" alt="">
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
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Sale Off</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">

                                <?php  
                                    $rsproduk = $this->db->query("select * from v_produk order by idjenis, namaproduk");
                                    if ($rsproduk->num_rows()>0) {
                                        foreach ($rsproduk->result() as $row) {
                                            echo '
                                    
                                                <div class="col-lg-4">
                                                    <div class="product__discount__item">
                                                        <div class="product__discount__item__pic set-bg"
                                                            data-setbg="'.base_url('uploads/produk/'.$row->gambarproduk).'">
                                                            <div class="product__discount__percent">-20%</div>
                                                            <ul class="product__item__pic__hover">
                                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="product__discount__item__text">
                                                            <span>'.$row->namajenis.'</span>
                                                            <h5><a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'">'.$row->namaproduk.'</a></h5>
                                                            <div class="product__item__price">$ '.$row->lowestprice.' <span>$ '.$row->highestprice.'</span></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            ';
                                        }
                                    }

                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>16</span> Products found</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <?php  
                            $rsproduk = $this->db->query("select * from v_produk order by idjenis, namaproduk");
                            if ($rsproduk->num_rows()>0) {
                                foreach ($rsproduk->result() as $row) {
                                    echo '
                            
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <div class="product__item__pic set-bg" data-setbg="'.base_url('uploads/produk/'.$row->gambarproduk).'">
                                                    <ul class="product__item__pic__hover">
                                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="product__item__text">
                                                    <h6><a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'">'.$row->namaproduk.'</a></h6>
                                                    <h5>$ '.$row->lowestprice.'</h5>
                                                </div>
                                            </div>
                                        </div>

                                    ';
                                }
                            }

                        ?>

                        
                        
                    </div>
                    <div class="product__pagination">
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <?php  
        $this->load->view('footer');
    ?>

</body>

</html>