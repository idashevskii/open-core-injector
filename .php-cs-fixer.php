<?php

return (new PhpCsFixer\Config())
  ->setRules([
    'encoding' => true,
    'full_opening_tag' => true,
    'blank_line_after_namespace' => true,
    'constant_case' => true,
    'function_declaration' => true,
    'indentation_type' => true,
    'line_ending' => true,
    'lowercase_keywords' => true,
    'method_argument_space' => [
      'on_multiline' => 'ensure_fully_multiline',
    ],
    'no_break_comment' => true,
    'no_closing_tag' => true,
    'no_space_around_double_colon' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_blank_line_at_eof' => true,
    'single_class_element_per_statement' => [
      'elements' => ['property'],
    ],
    'single_line_after_imports' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'blank_line_after_opening_tag' => false,
    'blank_line_between_import_groups' => true,
    'braces' => [
      'allow_single_line_anonymous_class_with_empty_body' => true,
      'allow_single_line_closure' => true,
      'position_after_functions_and_oop_constructs' => 'same',
    ],
    'class_definition' => [
      'inline_constructor_arguments' => false,
      'space_before_parenthesis' => true,
    ],
    'compact_nullable_typehint' => true,
    'declare_equal_normalize' => true,
    'lowercase_cast' => true,
    'lowercase_static_reference' => true,
    'new_with_braces' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_leading_import_slash' => true,
    'no_whitespace_in_blank_line' => true,
    'ordered_class_elements' => [
      'order' => ['use_trait'],
    ],
    'ordered_imports' => [
      'imports_order' => ['class', 'function', 'const'],
      'sort_algorithm' => 'none',
    ],
    'return_type_declaration' => true,
    'short_scalar_cast' => true,
    'single_blank_line_before_namespace' => true,
    'single_import_per_statement' => ['group_to_single_imports' => false],
    'single_trait_insert_per_statement' => true,
    'ternary_operator_spaces' => true,
    'visibility_required' => true,
    'array_syntax' => ['syntax' => 'short'],
    'single_quote' => true,
    'single_line_empty_body' => true,
  ])
  ->setIndent('  ')
  ->setLineEnding("\n")
;
