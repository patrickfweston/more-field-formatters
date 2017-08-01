<?php
/**
 * @file
 * Contains the FileWithText field formatter.
 *
 * Copyright 2017 Palantir.net, Inc.
 */

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Plugin\Field\FieldFormatter\UrlPlainFormatter;

/**
 * Plugin implementation of the 'file_url_plain' formatter.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_file_with_text",
 *   label = @Translation("Link to file with text"),
 *   description = @Translation("Displays a link to a file with custom, hard-coded text."),
 *   field_types = {
 *     "file"
 *   }
 * )
 */
class FileWithText extends UrlPlainFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    $text = $this->getSetting('text');

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      $elements[$delta] = array(
        '#cache' => array(
          'tags' => $file->getCacheTags(),
        ),
      );

      if ($text) {
        $elements[$delta]['#markup'] = sprintf('<a href="%s">%s</a>', file_url_transform_relative(file_create_url($file->getFileUri())), $text);
      }
      else {
        $elements[$delta]['#markup'] = file_url_transform_relative(file_create_url($file->getFileUri()));
      }
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'text' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['text'] = [
      '#title' => t('Text'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('text'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = t('Overridden text: %text', array('%text' => $this->getSetting('text')));

    return $summary;
  }

}
