<?php
/**
 * @file
 * Contains the LinkWithClass field formatter.
 *
 * Copyright 2017 Palantir.net, Inc.
 */

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Drupal\more_field_formatters\MoreFieldFormattersHelper;

/**
 * Plugin implementation of the 'button_link' formatter.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_link_with_class",
 *   label = @Translation("Link with class"),
 *   description = @Translation("Displays a link with an added class."),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class LinkWithClass extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    $classes = $this->getSetting('classes');

    // Make our list into an array of classes
    $cleaned_classes = MoreFieldFormattersHelper::cleanClass($classes);

    foreach ($elements as &$element) {
      $element['#full_url'] = $element['#url']->toString();
      $element['#is_external'] = $element['#url']->isExternal();

      if ($cleaned_classes) {
        $element['#options']['attributes']['class'] = $cleaned_classes;
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

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = t('Additional classes: %classes', array('%classes' => $this->getSetting('classes')));

    return $summary;
  }

}
