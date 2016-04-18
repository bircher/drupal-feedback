<?php

/**
 * @file
 * Contains feedback_message.page.inc..
 *
 * Page callback for Feedback message entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Feedback message templates.
 *
 * Default template: feedback_message.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_feedback_message(array &$variables) {
  // Fetch FeedbackMessage Entity Object.
  $feedback_message = $variables['elements']['#feedback_message'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

/**
* Prepares variables for a custom entity type creation list templates.
*
* Default template: feedback_message-content-add-list.html.twig.
*
* @param array $variables
*   An associative array containing:
*   - content: An array of feedback_message-types.
*
* @see block_content_add_page()
*/
function template_preprocess_feedback_message_content_add_list(&$variables) {
  $variables['types'] = array();
  $query = \Drupal::request()->query->all();
  foreach ($variables['content'] as $type) {
    $variables['types'][$type->id()] = array(
      'link' => Link::fromTextAndUrl($type->label(), new Url('entity.feedback_message.add_form', array(
        'feedback_message_type' => $type->id()
      ), array('query' => $query))),
      'description' => array(
      '#markup' => $type->label(),
      ),
      'title' => $type->label(),
      'localized_options' => array(
      'query' => $query,
      ),
    );
  }
}
