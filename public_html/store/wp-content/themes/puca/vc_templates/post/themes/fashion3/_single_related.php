<?php 
  $thumbsize = isset($thumbsize) ? $thumbsize : 'medium';
?>  
<div class="entry-content media">

  <?php
  if ( has_post_thumbnail() ) {
      ?>
        <div class="media-left">
          <figure class="entry-thumb">
              <a href="<?php the_permalink(); ?>"  class="entry-image">
                <?php 

                    $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    echo wp_get_attachment_image($thumbnail_id, $thumbsize);
                ?>
              </a>  
          </figure>
        </div>
      <?php
  }
  ?>
  <div class="media-body">
    <?php
        if (get_the_title()) {
        ?>
            <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        <?php
    } 
    ?>
    <div class="entry-content-inner clearfix">
        <div class="entry-meta">
            <div class="meta-info">
                <span class="entry-date"><?php echo puca_time_link(); ?></span>
                <span class="entry-view">
                  <?php echo puca_get_post_views(get_the_ID(), esc_html__(' views','puca')); ?>
                </span>  
            </div>
        </div>
    </div>
  </div>
</div>      
