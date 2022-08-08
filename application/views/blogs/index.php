
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
                        <h2>Blog</h2>
                        <div class="breadcrumb__option">
                            <a href="<?php echo site_url() ?>">Home</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Categories</h4>
                            <ul>
                                <li><a href="#">All</a></li>
                                <li><a href="#">Beauty (20)</a></li>
                                <li><a href="#">Food (5)</a></li>
                                <li><a href="#">Life Style (9)</a></li>
                                <li><a href="#">Travel (10)</a></li>
                            </ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Recent News</h4>
                            <div class="blog__sidebar__recent">
                                <a href="<?php echo site_url('blogs/detail/') ?>" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="<?php echo base_url('assets/ogani-master/') ?>img/blog/sidebar/sr-1.jpg" alt="">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>09 Kinds Of Vegetables<br /> Protect The Liver</h6>
                                        <span>MAR 05, 2019</span>
                                    </div>
                                </a>
                                <a href="<?php echo site_url('blogs/detail/') ?>" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="<?php echo base_url('assets/ogani-master/') ?>img/blog/sidebar/sr-2.jpg" alt="">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>Tips You To Balance<br /> Nutrition Meal Day</h6>
                                        <span>MAR 05, 2019</span>
                                    </div>
                                </a>
                                <a href="<?php echo site_url('blogs/detail/') ?>" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="<?php echo base_url('assets/ogani-master/') ?>img/blog/sidebar/sr-3.jpg" alt="">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>4 Principles Help You Lose <br />Weight With Vegetables</h6>
                                        <span>MAR 05, 2019</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Search By</h4>
                            <div class="blog__sidebar__item__tags">
                                <a href="#">Apple</a>
                                <a href="#">Beauty</a>
                                <a href="#">Vegetables</a>
                                <a href="#">Fruit</a>
                                <a href="#">Healthy Food</a>
                                <a href="#">Lifestyle</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        <?php
                            $rsblogs = $this->db->query("select * from v_blogs where ispublish='Ya' order by rand() limit 3 ");
                            if ($rsblogs->num_rows()>0) {
                                foreach ($rsblogs->result() as $row) {
                                    echo '

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="blog__item">
                                                <div class="blog__item__pic">
                                                    <img src="'.base_url('uploads/blogs/'.$row->gambarblogs).'" alt="" Style="height: 200px; width: 80%;">
                                                </div>
                                                <div class="blog__item__text">
                                                    <ul>
                                                        <li><i class="fa fa-calendar-o"></i> '.date('Y-M-d', strtotime($row->tglinsert)).'</li>
                                                        <li><i class="fa fa-comment-o"></i> 5</li>
                                                    </ul>
                                                    <h5><a href="'.site_url('blogs/detail/').'">'.$row->judulblogs.'</a></h5>
                                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                                        quaerat </p>
                                                    <a href="'.site_url('blogs/detail/').'" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                                </div>
                                            </div>
                                        </div>


                                    ';
                                }
                            }
                        ?>
                        <div class="col-lg-12">
                            <div class="product__pagination blog__pagination">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->


    <?php  
        $this->load->view('footer');
    ?>

</body>

</html>