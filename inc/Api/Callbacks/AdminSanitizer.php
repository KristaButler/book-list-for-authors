<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Callbacks;

use Inc\Util\BaseController;
use Inc\Util\DatabaseUtil;

class AdminSanitizer extends BaseController {
  public function sanitizeGeneralInputs($input) {
    $output = array();
    $output = $this->sanitizeGeneralCheckboxes($input);
    $output = array_merge($output, $this->sanitizeGeneralChooseOnes($input));
    $output['blfa_settings_author'] = sanitize_text_field($input['blfa_settings_author']);
    $output['blfa_settings_website'] = sanitize_text_field($input['blfa_settings_website']);
    return $output;
  }

  public function sanitizeSeriesInputs($input) {
    $output = get_option('blfa_plugin_series');
    $id = $input['blfa_series_id'];

    if(strpos($id, 'delete') > -1) {
      $id = substr($id, 6);
      $id = sanitize_textarea_field($id);
      unset($output[$id]);
    } else {
      //If we don't have an id, create one
      if (is_null($id) or empty($id) or !isset($id)) {
        $id = md5($input['blfa_series_title']);
      }

      //Make sure the checkbox value is set correctly and sanitize it
      $input['blfa_shared_series'] = $this->sanitizeCheckbox('blfa_shared_series', $input);

      //Sanitize other sanitizeBookInputs
      $id = sanitize_text_field($id);
      $input['blfa_series_id'] = $id;
      $input['blfa_series_title'] = sanitize_text_field($input['blfa_series_title']);

      $input['blfa_series_slug'] = $this->getSlug($input['blfa_series_title']);

      //Add/Update the value in the option array
      $output[$id] = $input;
    }

    return $output;
  }

  public function sanitizeRetailerInputs($input) {
    $output = get_option('blfa_plugin_retailers');
    $id = $input['blfa_retailer_id'];

    if(strpos($id, 'delete') > -1) {
      $id = substr($id, 6);

      if ($output[$id]['blfa_default_retailer']) {
          unset($output['default_retailer']);
      }

      unset($output[$id]);
    } else {
      //If we don't have an id, create one
      if (is_null($id) or empty($id) or !isset($id)) {
        $id = md5($input['blfa_retailer_name']);
      }

      //Make sure the checkbox value is set correctly and sanitize it
      $input['blfa_default_retailer'] = $this->sanitizeCheckbox('blfa_default_retailer', $input);

       //sanitize other inputs
       $id = sanitize_text_field($id);
       $input['blfa_retailer_name'] = sanitize_text_field($input['blfa_retailer_name']);
       $input['blfa_retailer_icon'] = (int) $input['blfa_retailer_icon'];
       $input['blfa_affiliate_tag'] = sanitize_text_field($input['blfa_affiliate_tag']);


       //Add/Update the value in the option array
       $output[$id] = $input;

       if($input['blfa_default_retailer']) {
        //find the current default and set it to false
        foreach ($output as $retailer) {
          $retailer_id = $retailer['blfa_retailer_id'];

          //Don't clear the flag on the retailer we are updating
          if($retailer_id != $id && $retailer['blfa_default_retailer']) {
            $retailer['blfa_default_retailer'] = false;
            $output[$retailer_id] = $retailer;
           }
         }
         //add/update the default retailer entry
         $output['default_retailer'] = $output[$id];
       }
    }

    return $output;
  }

  public function sanitizeBookInputs($input) {
    wp_verify_nonce( 'blfa_cu_book_nonce', 'blfa_cu_book' );
    $dbUtil = new DatabaseUtil();
    $id = $input['blfa_book_id'];

    $values = array();

    if(strpos($id, 'delete') > -1) {
      $id = (int) substr($id, 6);
      $dbUtil->deleteBook($id, 'blfa_cu_book');
    } else {
      //collect and sanitize inputs before inserting/updating
      $values['title'] = sanitize_text_field($input['blfa_book_title']);

      $values['subtitle'] = sanitize_text_field($input['blfa_book_subtitle']);
      $values['description'] = sanitize_textarea_field($input['blfa_book_desc']);

      if (!$input['blfa_book_order']) {
        $input['blfa_book_order'] = -1;
      }

      $values['book_order'] = intval($input['blfa_book_order']);
      $values['publication_date'] = preg_replace("([^0-9/])", "", $input['blfa_book_pubdate']);
      $values['author'] = sanitize_text_field($input['blfa_book_author']);
      $values['author_url'] = esc_url_raw($input['blfa_book_author_link']);
      $values['series'] = sanitize_text_field($input['blfa_book_series']);
      $values['cover'] = absint($input['blfa_book_cover']);
      $values['hide'] = $this->sanitizeCheckbox('blfa_book_hide', $input);
      $values['book_links'] = json_encode($this->sanitizeBookLinks($input['blfa_book_links']), JSON_UNESCAPED_UNICODE);

      //if an id was passed, update the database record
      if (isset($id) and !empty($id)) {
        $dbUtil->updateBook($id, $values);
      } else {
        //Otherwise insert a record (which generates the id)
        $dbUtil->addBook($values);
      }
    }

    return array(); //Return an empty array because we are saving the data in the database table instead of an option
  }

  public function sanitizeGeneralCheckboxes($input) {
    $output = array();

    foreach ($this->plugin_options['checkboxes'] as $key => $value) {
       $output[$key] = $this->sanitizeCheckbox($key, $input);
     }

    return $output;
  }

  public function sanitizeGeneralChooseOnes($input) {
    $output = array();

    foreach ($this->plugin_options['chooseones'] as $key => $options) {
      $output[$key] = $this->sanitizeChooseOne($options, $input[$key]);
    }

    return $output;
  }

  public function sanitizeCheckbox($key, $input) {
    return isset($input[$key]) ? $input[$key] : false;
  }

  public function sanitizeChooseOne($chooseone, $value) {
    $allowed_values = $chooseone['choices'];
    return in_array($value, $allowed_values) ? $value : '';
  }

  /* Loops through and sanitizes the input values of json array*/
  public function sanitizeBookLinks($input) {
    $output = array();
    $elements = explode(',', $input);

    foreach ($elements as $element) {
      $pieces = explode('|', $element);

      if (count($pieces) > 1) {
         $id = sanitize_text_field($pieces[0]);
         $link = esc_url_raw($pieces[1]);

         $output[$id] = $link;
      }
    }

    return $output;
  }
}
