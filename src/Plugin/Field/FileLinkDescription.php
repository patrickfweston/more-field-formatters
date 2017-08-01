<?php

namespace Drupal\more_field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Plugin\Field\FieldFormatter\UrlPlainFormatter;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Plugin implementation of the 'file_url_plain' formatter.
 *
 * Provides a link to the file with a separate description.
 *
 * @FieldFormatter(
 *   id = "more_field_formatters_file_link_description",
 *   label = @Translation("Link to file with description"),
 *   description = @Translation("Outputs a file as distinct variables with a link to the file and the text of its description."),
 *   field_types = {
 *     "file"
 *   }
 * )
 */
class FileLinkDescription extends UrlPlainFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      $elements[$delta] = array(
        '#cache' => array(
          'tags' => $file->getCacheTags(),
        ),
      );

      $file_url = Url::fromUri(file_create_url($file->getFileUri()));

      $file_item = $file->_referringItem;
      $description = $file_item->getValue()['description'];

      // Break the URL and description into pieces.
      $elements[$delta]['#url'] = $file_url->toString();
      $elements[$delta]['#description'] = $description;
    }

    return $elements;
  }

}
