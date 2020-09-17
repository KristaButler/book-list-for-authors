<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Callbacks;

use Inc\Util\BaseController;

class AdminPrinter extends BaseController {
  public function printCheckbox($args) {
    $name = $args['label_for'];
		$classes = $args['class'];
    $option_name = $args['option_name'];
		$checkbox = get_option($option_name);

    $checked = isset($checkbox[$name]) ? $checkbox[$name] : false;

    echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="'. $option_name . '[' . $name . ']" value="1"' . ($checked ? ' checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

    return;
  }

  public function printRadio($args) {
    $name = $args['label_for'];
		$classes = $args['class'];
    $option_name = $args['option_name'];
    $options = $args['options'];
    $radio = get_option($option_name);

    echo '<div class="admin-field-container">';

    foreach ($options as $option) {
      $value = $option['value'];
      $radio_classes = $option['class'];
      $radio_title = $option['title'];

      echo '<div class="' . $classes . '"><input type="radio" id="' . $name . '_' . $value . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" class="' . $radio_classes . '"' . ($radio[$name] == $value ? ' checked' : '') . '><label>' . $radio_title . '</label></div>';
    }

    echo '</div>';

    return;
  }

  public function printChooseOne($args) {
    $name = $args['label_for'];
		$classes = $args['class'];
    $option_name = $args['option_name'];
    $options = $args['options'];
    $radio = get_option($option_name);

    echo '<div class="admin-field-container">';

    foreach ($options as $option) {
      $value = $option['value'];
      $img = $this->plugin_url . '' . $option['img'];
      $radio_title = $option['title'];

      echo '<div class="' . $classes . '"><label class="' . $name . '"><input type="radio" id="' . $name . '_' . $value . '" class="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '"' . ($radio[$name] == $value ? ' checked' : '') . '><img src="' . $img . '" alt="' . $radio_title . '" /></label></div>';
    }

    echo '</div>';

    return;
  }

  public function printBlankTextInput($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<div class="admin-field-container"><label><input type="text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" class="' . $classes . '"></label></div>';

    return;
  }

  public function printTextInputWithMeButton($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<div class="admin-field-container"><label><input type="text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" class="' . $classes . '"></label><input type="button" id="' . $name . '-me" class="blfa-button-me button button-secondary" value="Me"/></div>';

    return;
  }

  public function printTextInput($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<div class="admin-field-container"><label><input type="text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" class="' . $classes . '" value="' . get_option($option_name)[$name] . '"/></label></div>';

    return;
  }

  public function printBlankCheckbox($args) {
    $name = $args['label_for'];
		$classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="'. $option_name . '[' . $name . ']" value="1"><label for="' . $name . '"><div></div></label></div>';

    return;
  }

  public function printHiddenInput($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<input type="hidden" id="' . $name . '" name="' . $option_name . '[' . $name . ']" class="' . $classes . '" />';

    return;
  }

  public function printMediaUploader($args) {
    //Based On: https://mycyberuniverse.com/integration-wordpress-media-uploader-plugin-options-page.html
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];
    $default_img = $args['default_img'];
    $note = $args['note'];

    // Print HTML field with empty image for editing
    echo '<div class="upload' . $classes . '">
            <div>
              <img id="' . $name . '-img" class="blfa-media-img" src="' . $default_img . '"/>
            </div>
            <div>
              <input type="hidden" name="' . $option_name . '[' . $name . ']" id="' . $name . '" value=""/>
              <a href="#" id="' . $name . '-upload-link">Upload</a>
              <a href="#" id="' . $name . '-remove-link" style="display: none;">Remove</a>
            </div>
            <div>
              <i>' . $note . '</i>
            </div>
        </div>';
  }

  public function printDropdown($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    $list = get_option($args['list']);
    $title = $args['list_title'];

    echo '<select id="' . $name . '" name="' . $option_name . '[' . $name . ']' . '" class="' . $classes .'"><option value="" class="default-selection">-Choose One-</option>';

    foreach ($list as $id => $item) {
      echo "<option value='$id'>" . $item[$title] . "</option>";
    }

    echo "</select>";
  }

  public function printDateInput($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<input type="date" id="' . $name . '" name="' . $option_name . '[' . $name . ']' . '" class="datepicker ' . $classes .'" />';
  }

  public function printBlankTextArea($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];

    echo '<textarea rows="4" cols="50" id="' . $name . '" name="' . $option_name . '[' . $name . ']' . '" class="' . $classes . '"></textarea>';
  }
}
