<?php

/**
 * @file
 * Contains \Drupal\feedback\Form\FeedbackMessageForm.
 */

namespace Drupal\feedback\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Feedback message edit forms.
 *
 * @ingroup feedback
 */
class FeedbackMessageForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\feedback\Entity\FeedbackMessage */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        // TODO: Make the message configurable per message type.
        drupal_set_message($this->t('Created the Feedback message.'));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Feedback message.', [
          '%label' => $entity->label(),
        ]));
    }
  }

}
