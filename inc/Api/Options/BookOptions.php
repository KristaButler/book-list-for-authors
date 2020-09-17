<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Options;

use \Inc\Api\Options\Options;

/**
 *
 */
class BookOptions extends Options {
  protected function getSettings() {
    $args = array (
      array (
        'option_group' => 'blfa_plugin_book',
        'option_name' => 'blfa_plugin_book',
        'callback' => array($this->sanitizer, 'sanitizeBookInputs')
      )
    );

    return $args;
  }

  protected function getSections() {
    $args = array (
      array (
        'id' => 'blfa_booklist_section',
        'title' => '',
        'page' => 'blfa_plugin_book'
      )
    );

    return $args;
  }

  protected function getFields() {
    $args = array (
      array (
        'id' => 'blfa_book_id',
        'title' => 'id',
        'callback' => array($this->printer, 'printHiddenInput'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_id',
          'class' => 'ui-hidden-input',
        )
      ),
      array (
        'id' => 'blfa_book_title',
        'title' => 'Title',
        'callback' => array($this->printer, 'printBlankTextInput'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_title',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_book_subtitle',
        'title' => 'Subtitle',
        'callback' => array($this->printer, 'printBlankTextInput'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_subtitle',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_book_series',
        'title' => 'Series',
        'callback' => array($this->printer, 'printDropdown'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_series',
          'class' => 'ui-select',
          'list' => 'blfa_plugin_series',
          'list_title' => 'blfa_series_title'
        )
      ),
      array (
        'id' => 'blfa_book_order',
        'title' => 'Order Number',
        'callback' => array($this->printer, 'printBlankTextInput'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_order',
          'class' => 'ui-numeric-input'
        )
      ),
      array (
        'id' => 'blfa_book_author',
        'title' => 'Author',
        'callback' => array($this->printer, 'printTextInputWithMeButton'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_author',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_book_author_link',
        'title' => 'Author Link',
        'callback' => array($this->printer, 'printTextInputWithMeButton'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_author_link',
          'class' => 'ui-url-input'
        )
      ),
      array (
        'id' => 'blfa_book_pubdate',
        'title' => 'Publication Date',
        'callback' => array($this->printer, 'printDateInput'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_pubdate',
          'class' => 'ui-date-input'
        )
      ),
      array (
        'id' => 'blfa_book_cover',
        'title' => 'Cover Image',
        'callback' => array($this->printer, 'printMediaUploader'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_cover',
          'class' => 'ui-image-input',
          'default_img' => $this->plugin_url . 'assets/img/no-cover-img.png',
          'note' => '(For best results, cover image size should be 333px X 500px.)'
        )
      ),
      array (
        'id' => 'blfa_book_desc',
        'title' => 'Description',
        'callback' => array($this->printer, 'printBlankTextArea'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_desc',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_book_hide',
        'title' => 'Hide?',
        'callback' => array($this->printer, 'printBlankCheckbox'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array (
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_hide',
          'class' => 'ui-toggle'
        )
      ),
      array (
        'id' => 'blfa_book_links',
        'title' => 'Retailer Links',
        'callback' => array($this->printer, 'printHiddenInput'),
        'page' => 'blfa_plugin_book',
        'section' => 'blfa_booklist_section',
        'args' => array(
          'option_name' => 'blfa_plugin_book',
          'label_for' => 'blfa_book_links',
          'class' => 'ui-hidden-input'
        )
      )
    );

    return $args;
  }
}
