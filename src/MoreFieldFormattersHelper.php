<?php

namespace Drupal\more_field_formatters;

/**
 * Class MoreFieldFormattersHelper
 *
 * Provides helper functions for the More Field Formatters module.
 *
 * @package Drupal\more_field_formatters
 */
class MoreFieldFormattersHelper {

  /**
   * Cleans a string into an array of classes.
   *
   * @param $classes
   * @return array|string
   */
  public static function cleanClass($classes) {
    // Clean up the classes into a CSS approved format if the user supplies them
    // in a comma separated list or separated with spaces.
    $cleaned_classes = preg_split('/[ ,]/', $classes, NULL, PREG_SPLIT_NO_EMPTY);
    $cleaned_classes = array_map('trim', $cleaned_classes);

    // Make sure we have a valid CSS class. The function
    // drupal_clean_css_identifier() has been deprecated in D8.
    $cleaned_classes = array_map(
      function ($item) {
        return preg_replace('/[^\x{002D}\x{0030}-\x{0039}\x{0041}-\x{005A}\x{005F}\x{0061}-\x{007A}\x{00A1}-\x{FFFF}]/u', '', $item);
      }, $cleaned_classes
    );

    $cleaned_classes = implode(" ", $cleaned_classes);

    return $cleaned_classes;
  }
}
