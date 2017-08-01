<?php

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\BasicStringFormatter;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'basic_string' formatter but with trimmed text.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_basic_string_trimmed",
 *   label = @Translation("Plain text (trimmed)"),
 *   description = @Translation("Displays basic text up to a set character limit."),
 *   field_types = {
 *     "string_long",
 *     "email"
 *   },
 *   quickedit = {
 *     "editor" = "plain_text_trimmed"
 *   }
 * )
 */
class TrimmedText extends BasicStringFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // Get the desired trim length.
    $trim_length = $this->getSetting('trim_length');

    // If we don't have a numeric input, don't trim.
    if (!is_numeric($trim_length) || is_null($trim_length)) {
      $trim_length = -1;
    }

    $elements = [];

    foreach ($items as $delta => $item) {
      if ($trim_length != -1) {
        $item->value = mb_strimwidth($item->value, 0, $trim_length + 3, "...");
      }

      // The text value has no text format assigned to it, so the user input
      // should equal the output, including newlines.
      $elements[$delta] = [
        '#type' => 'inline_template',
        '#template' => '{{ value|nl2br }}',
        '#context' => ['value' => $item->value],
      ];
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'trim_length' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['trim_length'] = [
      '#title' => t('Trim length'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('trim_length'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = t('Trim length: %trim_length', array('%trim_length' => $this->getSetting('trim_length')));

    return $summary;
  }

}
