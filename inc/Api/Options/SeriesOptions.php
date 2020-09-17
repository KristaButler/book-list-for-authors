<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Options;

use \Inc\Api\Options\Options;

/**
 *
 */
class SeriesOptions extends Options {
  protected function getSettings() {
    $args = array (
      array (
        'option_group' => 'blfa_plugin_series',
        'option_name' => 'blfa_plugin_series',
        'callback' => array($this->sanitizer, 'sanitizeSeriesInputs')
      )
    );

    return $args;
  }

  protected function getSections() {
    $args = array (
      array (
        'id' => 'blfa_series_section',
        'title' => 'Add New Series',
        'page' => 'blfa_plugin_series'
      )
    );

    return $args;
  }

  protected function getFields() {
    $args = array (
      array (
        'id' => 'blfa_series_id',
        'title' => 'id',
        'callback' => array($this->printer, 'printHiddenInput'),
        'page' => 'blfa_plugin_series',
        'section' => 'blfa_series_section',
        'args' => array (
          'option_name' => 'blfa_plugin_series',
          'label_for' => 'blfa_series_id',
          'class' => 'ui-hidden-input',
        )
      ),
      array (
        'id' => 'blfa_series_title',
        'title' => 'Title',
        'callback' => array($this->printer, 'printBlankTextInput'),
        'page' => 'blfa_plugin_series',
        'section' => 'blfa_series_section',
        'args' => array (
          'option_name' => 'blfa_plugin_series',
          'label_for' => 'blfa_series_title',
          'class' => 'ui-text-input'
        )
      ),
      array (
        'id' => 'blfa_shared_series',
        'title' => 'Shared?',
        'callback' => array($this->printer, 'printBlankCheckbox'),
        'page' => 'blfa_plugin_series',
        'section' => 'blfa_series_section',
        'args' => array (
          'option_name' => 'blfa_plugin_series',
          'label_for' => 'blfa_shared_series',
          'class' => 'ui-toggle'
        )
      ),
      array (
        'id' => 'blfa_series_slug',
        'title' => 'Series Slug',
        'callback' => array($this->printer, 'printHiddenInput'),
        'page' => 'blfa_plugin_series',
        'section' => 'blfa_series_section',
        'args' => array (
          'option_name' => 'blfa_plugin_series',
          'label_for' => 'blfa_series_slug',
          'class' => 'ui-hidden-input'
        )
      )
    );

    return $args;
  }
}
