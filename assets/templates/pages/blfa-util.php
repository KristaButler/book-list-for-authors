<?php
/**
 * Utility functions for the BLFA plugin
 *
 * @link https://www.pluviotech.com
 * @package BookListForAuthors
 */

function decodeArray($str) {
  $a_array = array();
  $str = str_replace(array('{', '}'), array('', ''), $str);
  $array = explode(',', $str);

  foreach ($array as $row) {
    $row = str_replace(array('"', ':\/\/'), array('', '||'), $row);
    $row_array = explode(':', $row);

    $a_array[$row_array[0]] = str_replace(array('||', '\/'), array("://", "/"), $row_array[1]);
  }

  return $a_array;
}

function getCoverContainerLocation($layout, $list_layout) {
  $on_top = false;

  if ($layout == 'list' && $list_layout != 'centered') {
    $on_top = true;
  }

  return $on_top;
}

function getCoverSize($setting) {
   $cover_size = 'blfa-cover-medium';

   if ($setting) {
     $cover_size = 'blfa-cover-' . $setting;
   }

   return $cover_size;
}

/*Source: https://forums.phpfreaks.com/topic/126006-replacing-with-tags-from-nl2br-function/ */
function nl2p( $str ) {
  $str = str_replace('\r\n', '\n', $str );
  $str = str_replace('\n\n', '\n', $str );

  return "<p>" . str_replace( '\n', "</p><p>", $str ) . "</p>";
}

function getDefaultRetailerLink($book, $retailers) {
  $default_retailer = $retailers['default_retailer'];
  $retailer_id = $default_retailer['blfa_retailer_id'];
  $links = decodeArray($book->book_links);

  return $links[$retailer_id];
}

function getRetailerLinkInternalHTML($retailer) {
  $rlHtml = $retailer['blfa_retailer_name']; //default to the retailer name as a text link
  $icon = $retailer['blfa_retailer_icon'];

  //If we have an icon image, use it instead of defaulot
  if ($icon && $icon > 0 && $icon != '' && $icon != null) {
    $rlHtml = wp_get_attachment_image($icon, 'blfa-retailer-icon');
  }

  return $rlHtml;
}

function getRetailerButton($book, $retailers) {
  $links = decodeArray($book->book_links);
  $retailer = $retailers['default_retailer'];
  $link = $links[$retailer['blfa_retailer_id']];

  return '<a class="blfa-retailer-button" href="' . $link . $retailer['blfa_affiliate_tag'] . '" target="_blank">' . getRetailerLinkInternalHTML($retailer)  . '</a>';
}

function removeFromArray($array, $remove_key) {
  $output = array();

  foreach ($array as $value) {
    if ($remove_key != $value->id) {
      array_push($output, $value);
    }
  }

  return $output;
}
