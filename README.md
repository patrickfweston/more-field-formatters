# More Field Formatters
The purpose of this module is to provide a set of simple field formatters that are commonly used on sites. Rather than copying these formatters from project to project in a custom module, they can be pulled into different projects.

Most of the field formatters provided are built off of existing Drupal 8 field formatters, but provide some additional options or customization.

## Contributing
Contributions to this set of formatters is always welcome. If you create a new formatter that you think can be easily reused on another project, feel free to contribute the formatter as a plugin.

If possible, extend from an existing Drupal 8 formatter.

Also, add documentation to this README file about the formatter and its options.

## Plugins
[Entity Reference](#entity-reference)<br />
[File](#file)<br />
[Image](#image)<br />
[Link](#link)<br />
[Text](#text)<br />

### Entity Reference
#### Label with class
Adds a class to an entity reference.

_Additional options:_
- Element: an element to wrap the label in (only if not displayed as a link)
  - `span`
  - `div`
  - `p`
  - `li`
- Class: a class to add to the wrapping element
- Title: an optional title to use as a hard-coded value

#### Separator
Adds separator between entity reference items. This is configurable with options to treat two items differently than three items. Additionally, the last item separator is configurable (to meet needs regarding the Oxford comma).

_Additional options:_
- Separator: a separator to place between elements
- Separator (last element): a separator between the last item and second to last item
- Separator (between only two elements): a separator when there are only two items

Example:
- Separator: ","
- Separator: (last element): "and"
- Separator (two elements): "+"

Item One<br />
Item One + Item Two<br />
Item One, Item Two and Item Three<br />

### File
#### Link to file with description
A link to a file with the file's description broken as a separate variable accessible via Twig. Helpful to allow for content editors to customize the link text for files.

_Additional options:_
<br />None.

This formatter provides variables that are accessible via Twig:
- `#url`: the URL to the file
- `#description`: the description entered for this file

#### Link to file with text
A link to a file with some hard-coded text as the value for the link text.

_Additional options:_
- Text: the hard-coded text to use for the file

### Image
#### Image with class
A default Drupal 8 image with a class.

_Additional options:_
- Class: the class(es) to wrap around the image.

### Link
#### Link with class
A link with a class wrapped it.

_Additional options:_
- Class: the class to wrap around the link

This formatter also provides additional variables that are accessible via Twig:
- `#is_external`: boolean value, TRUE if the link is external
- `#full_url`: string, value of the full URL for this link

#### Link with text
A link with hard-coded text. Useful for instances where a link should always have the same text. For example, a link with the text "Download".

_Additional options:_
- Text: the hard-coded text to use

### Text
#### Trimmed text
A trimmed text formatter for plain text elements. If the text is shorter than the trim length, nothing occurs. If the text is longer, an ellipsis is appended.

_Additional options:_
- Trim length: the number of characters to trim

## Copyright
Copyright 2017, Palantir.net
