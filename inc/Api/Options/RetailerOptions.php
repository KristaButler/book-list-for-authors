<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Options;

use \Inc\Api\Options\Options;

/**
 *
 */
class RetailerOptions extends Options {
  protected function getSettings() {
    $args = array (
      array (
        'option_group' => 'blfa_plugin_retailers',
        'option_name' => 'blfa_plugin_retailers',
        'callback' => array($this->sanitizer, 'sanitizeRetailerInputs')
      )
    );

    return $args;
  }

  protected function getSections() {
    $args = array (
      array (
        'id' => 'blfa_retailers_section',
        'title' => 'Add New Retailer',
        'page' => 'blfa_plugin_retailers'
      )
    );

    return $args;
  }

  protected function getFields() {
    $args = array (
      array (
        'id' => 'blfa_retailer_id',
        'title' => 'ID',
        'callback' => array($this->printer, 'printHiddenInput'),
        'page' => 'blfa_plugin_retailers',
        'section' => 'blfa_retailers_section',
        'args' => array (
          'option_name' => 'blfa_plugin_retailers',
          'label_for' => 'blfa_retailer_id',
          'class' => 'ui-hidden-input',
        )
      ),
      array (
        'id' => 'blfa_retailer_name',
        'title' => 'Name',
        'callback' => array($this->printer, 'printBlankTextInput'),
        'page' => 'blfa_plugin_retailers',
        'section' => 'blfa_retailers_section',
        'args' => array (
          'option_name' => 'blfa_plugin_retailers',
          'label_for' => 'blfa_retailer_name',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_retailer_icon',
        'title' => 'Icon Image',
        'callback' => array($this->printer, 'printMediaUploader'),
        'page' => 'blfa_plugin_retailers',
        'section' => 'blfa_retailers_section',
        'args' => array (
          'option_name' => 'blfa_plugin_retailers',
          'label_for' => 'blfa_retailer_icon',
          'class' => 'ui-image-input',
          'default_img' => $this->plugin_url . 'assets/img/default-retailer-icon.png',
          'note' => '(Max Size: 150px X 150px)'
        )
      ),
      array (
        'id' => 'blfa_affiliate_tag',
        'title' => 'Affiliate Tag',
        'callback' => array($this->printer, 'printBlankTextInput'),
        'page' => 'blfa_plugin_retailers',
        'section' => 'blfa_retailers_section',
        'args' => array (
          'option_name' => 'blfa_plugin_retailers',
          'label_for' => 'blfa_affiliate_tag',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_default_retailer',
        'title' => 'Default',
        'callback' => array($this->printer, 'printHiddenInput'),
        'page' => 'blfa_plugin_retailers',
        'section' => 'blfa_retailers_section',
        'args' => array (
          'option_name' => 'blfa_plugin_retailers',
          'label_for' => 'blfa_default_retailer',
          'class' => 'ui-hidden-input'
        )
      )
    );

    return $args;
  }
}
