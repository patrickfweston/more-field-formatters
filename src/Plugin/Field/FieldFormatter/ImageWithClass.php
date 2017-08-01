<?php
/**
 * @file
 * Contains the ImageWithClass field formatter.
 *
 * Copyright 2017 Palantir.net, Inc.
 */

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\image\Plugin\Field\FieldFormatter\ImageFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\more_field_formatters\MoreFieldFormattersHelper;

/**
 * Plugin implementation of the 'image' formatter.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_image_with_class",
 *   label = @Translation("Image with class"),
 *   description = @Translation("Displays an image using the standard template, but adds a class."),
 *   field_types = {
 *     "image"
 *   },
 *   quickedit = {
 *     "editor" = "image"
 *   }
 * )
 */
class ImageWithClass extends ImageFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'image_class' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['image_class'] = [
      '#title' => t('Classes'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('image_class'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = t('Additional classes: %classes', array('%classes' => $this->getSetting('image_class')));

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    $classes = $this->getSetting('image_class');

    // Make our list into an array of classes
    $cleaned_classes = MoreFieldFormattersHelper::cleanClass($classes);

    foreach ($elements as &$element) {
      $element['#item_attributes']['class'] = $cleaned_classes;
    }

    return $elements;
  }

}
