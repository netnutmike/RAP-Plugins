<?php /* Arclite/digitalnature */ ?>

 <!-- footer -->
 <div id="footer">

  <!-- page block -->
  <div class="block-content">

    <?php include(TEMPLATEPATH . '/footer-widgets.php'); ?>

    <?php if(get_option('arclite_footer')<>'') { ?>
    <div class="add-content">
      <?php print get_option('arclite_footer'); ?>
    </div>
     <?php } ?>

    <div class="copyright">
     <p>
     <!-- please do not remove this. respect the authors :) -->
     
     </p>
     <p>
     <a class="rss" href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)','arclite'); ?></a> <?php _e('and','arclite');?> <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)','arclite'); ?></a> <a href="javascript:void(0);" class="toplink">TOP</a>
     <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
     </p>
    </div>

  </div>
  <!-- /page block -->

 </div>
 <!-- /footer -->

</div>
<!-- /page -->
<?php wp_footer(); ?>
</body>
</html>