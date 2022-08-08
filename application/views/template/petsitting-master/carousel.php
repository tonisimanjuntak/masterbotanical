<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php 
      $rsslider = $this->db->query("select * from utilslider order by idslider desc");
      if ($rsslider->num_rows()>0) {
        $i = 0;
        foreach ($rsslider->result() as $row) {
          $i++;
          if ($i==1) {
            $active = 'active';
          }else{
            $active = '';
          }

          if (!empty($row->gambarslider)) {
            $gambarslider = base_url('uploads/slider/'.$row->gambarslider);
          }else{
            $gambarslider = base_url('images/nofoto.png');
          }
    ?>


        <div class="carousel-item <?php echo $active ?>">
          <img class="d-block w-100" src="<?php echo $gambarslider ?>" alt="First slide">
          <div class="carousel-caption d-none d-md-block bg-success mb-4">
            <h5><?php echo $row->judul ?></h5>
            <p><?php echo $row->catatan ?></p>
          </div>
        </div>


    <?php
        }
      }
    ?>
    
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>