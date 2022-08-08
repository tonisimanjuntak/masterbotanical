<!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All Product</span>
                        </div>
                        <ul>
                            <?php  
                                $rsproduk = $this->db->query("select * from v_produk order by idjenis, namaproduk");
                                if ($rsproduk->num_rows()>0) {
                                    foreach ($rsproduk->result() as $row) {
                                        echo '
                                            <li><a href="'.site_url('shop/detail/'.$this->encrypt->encode($row->idproduk)).'">'.$row->namaproduk.'</a></li>
                                        ';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do yo u need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5><?php echo $rowcompany->notelp ?></h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero__item set-bg" data-setbg="<?php echo base_url('images/slide2.jpg') ?>">
                        <div class="hero__text">
                            <span>LEAF FRESH</span>
                            <h2>LEAF <br />100% Organic</h2>
                            <p style="color: black;">Delivery Available</p>
                            <a href="<?php echo site_url('shop') ?>" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->