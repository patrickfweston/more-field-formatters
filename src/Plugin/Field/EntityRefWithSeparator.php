<?php

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceLabelFormatter;

/**
 * Plugin implementation of the 'entity reference rendered entity' formatter.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_entity_reference_label_separator",
 *   label = @Translation("Label (with separator)"),
 *   description = @Translation("Displays the label of an entity reference with a separator between elements."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityRefWithSeparator extends EntityReferenceLabelFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    // Grab the settings for this plugin.
    $separator = $this->getSetting('separator');
    $last_element = $this->getSetting('last_element');
    $separator_for_two = $this->getSetting('separator_for_two');

    $num_elements = count($elements);

    // Add a suffix to all of the elements except for the last element.
    for ($i = 0; $i < $num_elements - 1; $i++) {
      $elements[$i]['#suffix'] = $separator;
    }

    // If we have more than 1 element then add some last element text between
    // the last two items.
    if ($last_element && $num_elements > 1) {
      $elements[$num_elements - 1]['#prefix'] = ' ' . $last_element . ' ';
    }

    // Lastly, if we have just two items, don't separate.
    if (!$separator_for_two && $num_elements == 2) {
      unset($elements[0]['#suffix']);
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'separator' => '',
      'last_element' => '',
      'separator_for_two' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['separator'] = [
      '#title' => t('Separator between items'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('separator'),
    ];

    $element['last_element'] = [
      '#title' => t('Last element prefix'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('last_element'),
    ];

    $element['separator_for_two'] = [
      '#title' => t('Separator between only two items'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('separator_for_two'),
    ];

    return $element + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = t('Separator between labels: %separator', array('%separator' => $this->getSetting('separator')));

    return $summary;
  }

}
