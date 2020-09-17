<?php
function printFeaturedBlock() {
  $img_path = plugin_dir_url( dirname( __FILE__, 1) );
?>
  <div class="sp-book-number-top">Book #</div>
  <div class="sp-book-title">My Books Title</div>
  <div class="sp-book-number">Book #</div>
  <img class="spf-medium-cover" src="<?php echo $img_path; ?>img/preview-medium-cover.png" />
  <img class="spf-large-cover" src="<?php echo $img_path; ?>img/preview-large-cover.png" />
  <img class="spf-exlarge-cover" src="<?php echo $img_path; ?>img/preview-exlarge-cover.png" />
  <div class="sp-author">Author Name</div>
  <p class="sp-description blfa-justify">
    Description vivamus suscipit tortor eget felis porttitor volutpat. Cras ultricies ligula sed magna dictum porta. Donec sollicitudin molestie malesuada. Pellentesque in ipsum id orci porta dapibus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Nulla quis lorem ut libero malesuada feugiat.
  </p>
  <div><img class="sp-buy-button" src="<?php echo $img_path; ?>img/preview-buy-button.png" /></div>
<?php
}
?>

<div id="series-page-preview-box" class="blfa-preview-box">
  <div id="sp-grid">
    <table>
      <tr class="preview-block-row">
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
      </tr>
      <tr class="preview-block-row">
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr class="preview-block-row">
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="sp-list-c">
    <div class="preview-list-centered">
      <div class="preview-list-block">
        <?php printBlock('sp', true); ?>
      </div>
      <div class="preview-list-block">
        <?php printBlock('sp', true); ?>
      </div>
      <div class="preview-list-block">
        <?php printBlock('sp', true); ?>
      </div>
    </div>
  </div>
  <div id="sp-list-l">
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="sp-list-r">
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="sp-list-a">
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('sp', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('sp'); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="sp-featured">
    <div class="preview-featured-book">
      <?php printFeaturedBlock(); ?>
    </div>
    <table>
      <tr class="preview-featured-row">
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
        <td>
          <?php printBlock('sp', true); ?>
        </td>
      </tr>
    </table>
  </div>
</div>
