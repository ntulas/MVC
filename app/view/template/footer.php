<footer>
  <div id="footer">
    <h1>FOOTER</h1>
    <p class="copy">
      © <?php echo date("Y"); ?>. <?php $this->info("company_name"); ?> ALL RIGHTS RESERVED
    </p>
    <p class="silver"><img src="public/images/scnt.png" alt="" class="company-logo" /><a href="https://silverconnectwebdesign.com/website-development" rel="external" target="_blank">Web Design</a> Done by <a href="https://silverconnectwebdesign.com" rel="external" target="_blank">Silver Connect Web Design</a></p>
  </div>
</footer>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo URL; ?>public/scripts/sendform.js" data-view="<?php echo $view; ?>" id="sendform"></script>
  <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>  -->
  <script type="text/javascript" src="<?php echo URL; ?>public/scripts/responsive-menu.js"></script>
  
  <?php if(in_array($view,["home","contact"])): ?>
    <script src='//www.google.com/recaptcha/api.js?onload=captchaCallBack&render=explicit' async defer></script>
    <script>
    var captchaCallBack = function() {
        $('.g-recaptcha').each(function(index, el) {
          grecaptcha.render(el, {'sitekey' : '<?php $this->info("site_key");?>'});
        });
      };
    </script>
  <?php endif; ?>


  <?php if ($view == "gallery"): ?>
    <script type="text/javascript" src="<?php echo URL; ?>public/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/scripts/jquery.pajinate.js"></script>
    <script>
     $('#gall1').pajinate({ num_page_links_to_display : 3, items_per_page : 10 });
     $('.fancy').fancybox({
      helpers: {
        title : {
          type : 'over'
        }
      }
     });
   </script>
  <?php endif; ?>

  <?php $this->checkSuspensionFooter(); ?>
</body>
</html>
