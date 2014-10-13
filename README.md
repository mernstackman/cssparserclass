cssparserclass
==============

This PHP Class is used to parse css file/ stylesheet.
Was improved from Gabriel Anderson's answer (http://stackoverflow.com/a/6589386/2232458) about css parsing method.
Many thanks to Gabriel Anderson.

Key Features:
- Edit stylesheet's content.
- Return an array of edited css.
- Support all css properties.
- Ability to process repeated properties such as "background".

Limitation:
- Not supporting css media queries.


USAGE:

1. Include this class in your php file. Example: require_once('class.styleedit.php');
2. initialize the class. example: $cssEditor = new cssEditor();

- Edit CSS:
$cssEditor->editCss($default, $custom, array("#selector 1", ".selector 2", ".etc"));

- Return an array of edited stylesheet's content:
$cssEditor->getCssArray($default, $custom, array("#selector 1", ".selector 2", ".etc"));

-- This Readme File Isn't Yet Finished --
