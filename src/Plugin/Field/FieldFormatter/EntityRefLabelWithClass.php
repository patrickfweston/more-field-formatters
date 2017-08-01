<?php
/**
 * @file
 * Contains the EntityRefLabelWithClass field formatter.
 *
 * Copyright 2017 Palantir.net, Inc.
 */

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceLabelFormatter;
use Drupal\more_field_formatters\MoreFieldFormattersHelper;

/**
 * Plugin implementation of the 'entity_reference_label' formatter.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_entity_reference_label_with_class",
 *   label = @Translation("Label with class"),
 *   description = @Translation("Displays the label of an entity reference with a class wrapping the label."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityRefLabelWithClass extends EntityReferenceLabelFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    // Get the settings for the plugin.
    $classes = $this->getSetting('classes');
    $title = $this->getSetting('title_override');
    $element_wrapper = $this->getSetting('element');

    // Make our list into an array of classes
    $cleaned_classes = MoreFieldFormattersHelper::cleanClass($classes);

    // Set the settings for the different entity reference items.
    foreach ($elements as &$element) {
      if (isset($element['#url'])) {
        $options = $element['#url']->getOption('attributes');
        $options = $options ?: array();

        $element['#url']->setOption('attributes', $options + array('class' => $cleaned_classes));

        if ($title) {
          $element['#title'] = $title;
        }
      }
      else {
        $text = $title ? $title : $element['#plain_text'];
        $element['#markup'] = sprintf("<%s class='%s'>%s</%s>", $element_wrapper, $cleaned_classes, $text, $element_wrapper);
        unset($element['#plain_text']);
      }
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'classes' => '',
      'title_override' => '',
      'element' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['classes'] = [
      '#title' => t('Classes'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('classes'),
    ];

    $elements['title_override'] = [
      '#title' => t('Override Title'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('title_override'),
    ];

    $elements['element'] = [
      '#title' => t('Element'),
      '#type' => 'select',
      '#options' => [
        'span' => 'span',
        'div' => 'div',
        'p' => 'p',
        'li' => 'li',
      ],
      '#default_value' => $this->getSetting('element')
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = t('Additional classes: %classes', array('%classes' => $this->getSetting('classes')));
    $summary[] = t('Overridden title: %title', array('%title' => $this->getSetting('title_override')));
    $summary[] = t('Element: %element', array('%element' => $this->getSetting('element')));

    return $summary;
  }

}
