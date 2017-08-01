<?php

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;

/**
 * Plugin implementation for a link with text formatter.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_link_with_text",
 *   label = @Translation("Link with text"),
 *   description = @Translation("Displays a link with hard-coded text."),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class LinkWithText extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    $text = $this->getSetting('text');

    foreach ($elements as &$element) {
      if ($text) {
        $element['#title'] = $text;
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
