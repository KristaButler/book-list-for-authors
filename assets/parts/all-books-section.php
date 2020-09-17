<?php
function printCoverImages($prefix) {
  $img_path = plugin_dir_url( dirname( __FILE__, 1) );
?>
  <img class="<?php echo $prefix ?>-small-cover" src="<?php echo $img_path; ?>img/preview-small-cover.png" />
  <img class="<?php echo $prefix ?>-medium-cover" src="<?php echo $img_path; ?>img/preview-medium-cover.png" />
  <img class="<?php echo $prefix ?>-large-cover" src="<?php echo $img_path; ?>img/preview-large-cover.png" />
<?php
}

function printBlock ($prefix, $includeImages) {
  $img_path = plugin_dir_url( dirname( __FILE__, 1) );
?>

  <div class="<?php echo $prefix ?>-book-number-top">Book #</div>
  <div class="<?php echo $prefix ?>-book-title">My Books Title</div>
  <div class="<?php echo $prefix ?>-book-number">Book #</div>
<?php
  if ($includeImages) {
    printCoverImages($prefix);
  }
?>
  <div class="<?php echo $prefix ?>-author">Author Name</div>
  <p class="<?php echo $prefix ?>-description blfa-justify">
    Description vivamus suscipit tortor eget felis porttitor volutpat. Cras ultricies ligula sed magna dictum porta. Donec sollicitudin molestie malesuada. Pellentesque in ipsum id orci porta dapibus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Nulla quis lorem ut libero malesuada feugiat.
  </p>
  <div><img class="<?php echo $prefix ?>-buy-button" src="<?php echo $img_path; ?>img/preview-buy-button.png" /></div>
<?php
}
?>

<div id="all-books-preview-box" class="blfa-preview-box">
  <div class="preview-series-title">
    <b>My Series Title</b>
  </div>
  <div id="ab-grid">
    <table>
      <tr class="preview-block-row">
        <td>
          <?php printBlock('ab', true); ?>
        </td>
        <td>
          <?php printBlock('ab', true); ?>
        </td>
        <td>
          <?php printBlock('ab', true); ?>
        </td>
      </tr>
      <tr class="preview-block-row">
        <td>
          <?php printBlock('ab', true); ?>
        </td>
        <td>
          <?php printBlock('ab', true); ?>
        </td>
        <td>
          <?php printBlock('ab', true); ?>
        </td>
      </tr>
    </table>
    <div class="preview-series-title">
      <b>My Series Title</b>
    </div>
    <table>
      <tr class="preview-block-row">
        <td>
          <?php printBlock('ab', true); ?>
        </td>
        <td>
          <?php printBlock('ab', true); ?>
        </td>
        <td>
          <?php printBlock('ab', true); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="ab-list-c">
    <div class="preview-list-centered">
      <div class="preview-list-block">
        <?php printBlock('ab', true); ?>
      </div>
      <div class="preview-list-block">
        <?php printBlock('ab', true); ?>
      </div>
      <div class="preview-series-title">
        <b>My Other Series Title</b>
      </div>
      <div class="preview-list-block">
        <?php printBlock('ab', true); ?>
      </div>
    </div>
  </div>
  <div id="ab-list-l">
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
    </table>
    <div class="preview-series-title">
      <b>My Series Title</b>
    </div>
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="ab-list-r">
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
      </tr>
    </table>
    <div class="preview-series-title">
      <b>My Series Title</b>
    </div>
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
      </tr>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
      </tr>
    </table>
  </div>
  <div id="ab-list-a">
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
    </table>
    <div class="preview-series-title">
      <b>My Series Title</b>
    </div>
    <table>
      <tr>
        <td class="preview-cover-column">
          <?php printCoverImages('ab'); ?>
        </td>
        <td class="preview-text-column">
          <?php printBlock('ab', false); ?>
        </td>
      </tr>
    </table>
  </div>
</div>
