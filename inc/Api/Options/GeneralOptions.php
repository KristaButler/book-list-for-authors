<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Options;

use \Inc\Api\Options\Options;

/**
 *
 */
class GeneralOptions extends Options {
  protected function getSettings() {
    $args = array (
      array (
        'option_group' => 'blfa_plugin',
        'option_name' => 'blfa_plugin_settings',
        'callback' => array($this->sanitizer, 'sanitizeGeneralInputs')
      )
    );

    return $args;
  }

  protected function getSections() {
    $args = array (
      array (
        'id' => 'blfa_settings_general',
        'title' => 'General Settings',
        'page' => 'blfa_plugin_settings',
      ),
      array (
        'id' => 'blfa_settings_allbooks',
        'title' => 'All Books Page',
        'page' => 'blfa_plugin_settings',
        'callback' => array($this->callbacks, 'allBooksOptionsSection')
      ),
      array (
        'id' => 'blfa_settings_seriespage',
        'title' => 'Series Pages',
        'page' => 'blfa_plugin_settings',
        'callback' => array($this->callbacks, 'seriesPageOptionsSection')
      ),
      array (
        'id' => 'blfa_settings_bookpage',
        'title' => 'Book Pages',
        'page' => 'blfa_plugin_settings',
        'callback' => array($this->callbacks, 'bookPageOptionsSection')
      )
    );

    return $args;
  }

  protected function getFields() {
    $args = array (
      //General
      //#region
      array (
        'id' => 'blfa_settings_author',
        'title' => 'Your Author Name',
        'callback' => array($this->printer, 'printTextInput'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_general',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_settings_author',
          'class' => 'blfa-text-input'
        )
      ),
      array (
        'id' => 'blfa_settings_website',
        'title' => 'Your Author Website',
        'callback' => array($this->printer, 'printTextInput'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_general',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_settings_website',
          'class' => 'blfa-text-input'
        )
      ),
      //#endregion
      //All Books
      //#region
      array (
        'id' => 'blfa_allbooks_include_page',
        'title' => 'Include All Books Page',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_include_page',
          'class' => 'ui-toggle ui-first'
        )
      ),
      array (
        'id' => 'blfa_allbooks_page_layout',
        'title' => 'Page Layout',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Page Layout',
          'label_for' => 'blfa_allbooks_page_layout',
          'class' => 'ui-choose-one blfa-allbooks',
          'options' => array (
            array (
              'title' => 'Grid',
              'value' => 'grid',
              'img' => 'assets/img/grid.png',
            ),
            array (
              'title' => 'List',
              'value' => 'list',
              'img' => 'assets/img/list.png'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_allbooks_list_layout',
        'title' => 'List Type',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'List Type',
          'label_for' => 'blfa_allbooks_list_layout',
          'class' => 'ui-choose-one blfa-allbooks blfa_allbooks_list_layout',
          'options' => array (
            array (
              'title' => 'Centered',
              'value' => 'centered',
              'img' => 'assets/img/listCentered.png'
            ),
            array (
              'title' => 'Left',
              'value' => 'left',
              'img' => 'assets/img/list.png'
            ),
            array (
              'title' => 'Right',
              'value' => 'right',
              'img' => 'assets/img/listRight.png'
            ),
            array (
              'title' => 'Alternate',
              'value' => 'alternate',
              'img' => 'assets/img/alternate.png',
            )
          )
        )
      ),
      array (
        'id' => 'blfa_allbooks_include_number',
        'title' => 'Include Book Number',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_include_number',
          'class' => 'ui-toggle blfa-allbooks'
        )
      ),
      array (
        'id' => 'blfa_allbooks_number_top',
        'title' => 'Book Number On Top',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_number_top',
          'class' => 'ui-toggle blfa-allbooks blfa_allbooks_number_top'
        )
      ),
      array (
        'id' => 'blfa_allbooks_include_title',
        'title' => 'Include Title',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_include_title',
          'class' => 'ui-toggle blfa-allbooks'
        )
      ),
      array (
        'id' => 'blfa_allbooks_include_author',
        'title' => 'Include Author',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_include_author',
          'class' => 'ui-toggle blfa-allbooks'
        )
      ),
      array (
        'id' => 'blfa_allbooks_include_desc',
        'title' => 'Include Description',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_include_desc',
          'class' => 'ui-toggle blfa-allbooks'
        )
      ),
      array (
        'id' => 'blfa_allbooks_include_buy_button',
        'title' => 'Include Buy Button for Default Retailer',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_allbooks_include_buy_button',
          'class' => 'ui-toggle blfa-allbooks'
        )
      ),
      array (
        'id' => 'blfa_allbooks_cover_size',
        'title' => 'Cover Thumbnail Size',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_allbooks',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Cover Thumbnail Size',
          'label_for' => 'blfa_allbooks_cover_size',
          'class' => 'ui-choose-one blfa-allbooks',
          'options' => array (
            array (
              'title' => 'Small',
              'value' => 'small',
              'img' => 'assets/img/small.png'
            ),
            array (
              'title' => 'Medium',
              'value' => 'medium',
              'img' => 'assets/img/medium.png',
            ),
            array (
              'title' => 'Large',
              'value' => 'large',
              'img' => 'assets/img/large.png'
            )
          )
        )
      ),
      //#endregion
      //Series Pages
      //#region
      array (
        'id' => 'blfa_seriespage_include_page',
        'title' => 'Include Series Pages',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_seriespage_include_page',
          'class' => 'ui-toggle ui-first'
        )
      ),
      array (
        'id' => 'blfa_series_page_layout',
        'title' => 'Page Layout',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Page Layout',
          'label_for' => 'blfa_series_page_layout',
          'class' => 'ui-choose-one blfa-seriespage',
          'options' => array (
            array (
              'title' => 'Grid',
              'value' => 'grid',
              'img' => 'assets/img/grid.png',
            ),
            array (
              'title' => 'List',
              'value' => 'list',
              'img' => 'assets/img/list.png'
            ),
            array (
              'title' => 'Featured',
              'value' => 'featured',
              'img' => 'assets/img/featured.png'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_series_list_layout',
        'title' => 'List Type',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'List Type',
          'label_for' => 'blfa_series_list_layout',
          'class' => 'ui-choose-one blfa-seriespage blfa_series_list_layout',
          'options' => array (
            array (
              'title' => 'Centered',
              'value' => 'centered',
              'img' => 'assets/img/listCentered.png'
            ),
            array (
              'title' => 'Left',
              'value' => 'left',
              'img' => 'assets/img/list.png'
            ),
            array (
              'title' => 'Right',
              'value' => 'right',
              'img' => 'assets/img/listRight.png'
            ),
            array (
              'title' => 'Alternate',
              'value' => 'alternate',
              'img' => 'assets/img/alternate.png',
            )
          )
        )
      ),
      array (
        'id' => 'blfa_series_featured_cover_size',
        'title' => 'Featured Book Cover Size',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Featured Book Cover Size',
          'label_for' => 'blfa_series_featured_cover_size',
          'class' => 'ui-choose-one blfa-seriespage blfa-featured',
          'options' => array (
            array (
              'title' => 'Medium',
              'value' => 'medium',
              'img' => 'assets/img/medium.png',
            ),
            array (
              'title' => 'Large',
              'value' => 'large',
              'img' => 'assets/img/large.png'
            ),
            array (
              'title' => 'Extra Large',
              'value' => 'exlarge',
              'img' => 'assets/img/exlarge.png'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_series_featured_book',
        'title' => 'Book to Feature',
        'callback' => array($this->printer, 'printRadio'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Book to Feature',
          'label_for' => 'blfa_series_featured_book',
          'class' => 'ui-choose-radio blfa-seriespage blfa-featured',
          'options' => array (
            array (
              'title' => 'First in Series',
              'value' => 'first',
              'class' => 'ui-radio-choice',
            ),
            array (
              'title' => 'Recently Published',
              'value' => 'recent',
              'class' => 'ui-radio-choice'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_series_featured_by_me',
        'title' => 'Only Feature My Books',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_featured_by_me',
          'class' => 'ui-toggle blfa-seriespage blfa-featured'
        )
      ),
      array (
        'id' => 'blfa_series_include_number',
        'title' => 'Include Book Number',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_include_number',
          'class' => 'ui-toggle blfa-seriespage'
        )
      ),
      array (
        'id' => 'blfa_series_number_top',
        'title' => 'Book Number On Top',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_number_top',
          'class' => 'ui-toggle blfa-seriespage blfa_series_number_top'
        )
      ),
      array (
        'id' => 'blfa_series_include_title',
        'title' => 'Include Title',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_include_title',
          'class' => 'ui-toggle blfa-seriespage'
        )
      ),
      array (
        'id' => 'blfa_series_include_author',
        'title' => 'Include Author',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_include_author',
          'class' => 'ui-toggle blfa-seriespage'
        )
      ),
      array (
        'id' => 'blfa_series_include_desc',
        'title' => 'Include Description',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_include_desc',
          'class' => 'ui-toggle blfa-seriespage'
        )
      ),
      array (
        'id' => 'blfa_series_include_buy_button',
        'title' => 'Include Buy Button for Default Retailer',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_series_include_buy_button',
          'class' => 'ui-toggle blfa-seriespage'
        )
      ),
      array (
        'id' => 'blfa_series_cover_size',
        'title' => 'Cover Thumbnail Size',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_seriespage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Cover Thumbnail Size',
          'label_for' => 'blfa_series_cover_size',
          'class' => 'ui-choose-one blfa-seriespage',
          'options' => array (
            array (
              'title' => 'Small',
              'value' => 'small',
              'img' => 'assets/img/small.png'
            ),
            array (
              'title' => 'Medium',
              'value' => 'medium',
              'img' => 'assets/img/medium.png',
            ),
            array (
              'title' => 'Large',
              'value' => 'large',
              'img' => 'assets/img/large.png'
            )
          )
        )
      ),
      //#endregion
      //Book Pages
      //#region
      array (
        'id' => 'blfa_bookpage_include_page',
        'title' => 'Include Book Detail Pages',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_bookpage_include_page',
          'class' => 'ui-toggle ui-first'
        )
      ),
      array (
        'id' => 'blfa_bookpage_page_layout',
        'title' => 'Page Layout',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Page Layout',
          'label_for' => 'blfa_bookpage_page_layout',
          'class' => 'ui-choose-one blfa-bookpage',
          'options' => array (
            array (
              'title' => 'Center',
              'value' => 'center',
              'img' => 'assets/img/centered.png'
            ),
            array (
              'title' => 'Left',
              'value' => 'left',
              'img' => 'assets/img/left.png',
            ),
            array (
              'title' => 'Right',
              'value' => 'right',
              'img' => 'assets/img/right.png'
            ),
            array (
              'title' => 'Left, No Wrapping',
              'value' => 'left-nowrap',
              'img' => 'assets/img/left-no-wrap.png'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_bookpage_cover_size',
        'title' => 'Book Cover Image Size',
        'callback' => array($this->printer, 'printChooseOne'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Book Cover Image Size',
          'label_for' => 'blfa_bookpage_cover_size',
          'class' => 'ui-choose-one blfa-bookpage',
          'options' => array (
            array (
              'title' => 'Small',
              'value' => 'small',
              'img' => 'assets/img/small.png'
            ),
            array (
              'title' => 'Medium',
              'value' => 'medium',
              'img' => 'assets/img/medium.png',
            ),
            array (
              'title' => 'Large',
              'value' => 'large',
              'img' => 'assets/img/large.png'
            ),
            array (
              'title' => 'Extra Large',
              'value' => 'exlarge',
              'img' => 'assets/img/exlarge.png'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_bookpage_link_cover',
        'title' => 'Link Cover to Default Retailer',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_bookpage_link_cover',
          'class' => 'ui-toggle blfa-bookpage'
        )
      ),
      array (
        'id' => 'blfa_bookpage_buy_button_location',
        'title' => 'Buy Buttons Location',
        'callback' => array($this->printer, 'printRadio'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'Buy Buttons Location',
          'label_for' => 'blfa_bookpage_buy_button_location',
          'class' => 'ui-choose-radio blfa-bookpage',
          'options' => array (
            array (
              'title' => 'Below Cover',
              'value' => 'below-cover',
              'class' => 'ui-radio-choice',
            ),
            array (
              'title' => 'Below Description',
              'value' => 'below-desc',
              'class' => 'ui-radio-choice'
            )
          )
        )
      ),
      array (
        'id' => 'blfa_bookpage_include_number',
        'title' => 'Include Book Number',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_bookpage_include_number',
          'class' => 'ui-toggle blfa-bookpage'
        )
      ),
      array (
        'id' => 'blfa_bookpage_number_top',
        'title' => 'Book Number On Top',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_bookpage_number_top',
          'class' => 'ui-toggle blfa-bookpage blfa_bookpage_number_top'
        )
      ),
      array (
        'id' => 'blfa_bookpage_include_author',
        'title' => 'Include Author',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_bookpage_include_author',
          'class' => 'ui-toggle blfa-bookpage'
        )
      ),
      array (
        'id' => 'blfa_bookpage_link_author',
        'title' => 'When to Link to Author Page',
        'callback' => array($this->printer, 'printRadio'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'title' => 'When to Link to Author Page',
          'label_for' => 'blfa_bookpage_link_author',
          'class' => 'ui-choose-radio blfa-bookpage blfa_bookpage_link_author',
          'options' => array (
            array (
              'title' => 'Always',
              'value' => 'always',
              'class' => 'ui-radio-choice'
            ),
            array (
              'title' => 'Never',
              'value' => 'never',
              'class' => 'ui-radio-choice'
            ),
            array (
              'title' => "When it isn't me.",
              'value' => 'not-me',
              'class' => 'ui-radio-choice',
            )
          )
        )
      ),
      array (
        'id' => 'blfa_bookpage_include_series',
        'title' => 'Include Series Title',
        'callback' => array($this->printer, 'printCheckbox'),
        'page' => 'blfa_plugin_settings',
        'section' => 'blfa_settings_bookpage',
        'args' => array (
          'option_name' => 'blfa_plugin_settings',
          'label_for' => 'blfa_bookpage_include_series',
          'class' => 'ui-toggle blfa-bookpage'
        )
      )
      //#endregion
    );

    return $args;
  }
}
