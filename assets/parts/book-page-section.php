<?php
function printXlargeCover() {
  $img_path = plugin_dir_url( dirname( __FILE__, 1) );
?>
<img class="bp-exlarge-cover" src="<?php echo $img_path; ?>img/preview-exlarge-cover.png" />
<?php
}

function printBuyButtons() {
  $img_path = plugin_dir_url( dirname( __FILE__, 1) );
?>
<img class="bp-buy-button" src="<?php echo $img_path; ?>img/preview-buy-button.png" />
<img class="bp-buy-button" src="<?php echo $img_path; ?>img/preview-buy-button.png" />
<?php
}
?>

<div id="book-page-preview-box" class="blfa-preview-box">
  <div class="bp-title">
    My Book Title
  </div>
  <div class="bp-images">
    <div class="bp-cover">
      <?php printCoverImages('bp'); ?>
      <?php printXlargeCover(); ?>
    </div>
    <div class="bp-buy-buttons bp-below-cover">
      <?php printBuyButtons(); ?>
    </div>
  </div>
  <div class="bp-text">
    <div class="bp-headings">
      <div class="bp-book-number-top">
        Book #
      </div>
      <div class="bp-series-title">
        My Series Title
      </div>
      <div class="bp-book-number">
        Book #
      </div>
      <div class="bp-author">
        Author Name
      </div>
    </div>
    <p class="bp-description bp-justify">
      Description vivamus suscipit tortor eget felis porttitor volutpat. Cras ultricies ligula sed magna dictum porta. Donec sollicitudin molestie malesuada. Pellentesque in ipsum id orci porta dapibus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Nulla quis lorem ut libero malesuada feugiat.
    </p>
    <div class="bp-buy-buttons bp-below-desc">
      <?php printBuyButtons(); ?>
    </div>
  </div>
</div>
<div class="clear-fix"></div>
