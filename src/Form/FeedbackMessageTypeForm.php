<?php

/**
 * @file
 * Contains \Drupal\feedback\Form\FeedbackMessageTypeForm.
 */

namespace Drupal\feedback\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FeedbackMessageTypeForm.
 *
 * @package Drupal\feedback\Form
 */
class FeedbackMessageTypeForm extends EntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $feedback_message_type = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $feedback_message_type->label(),
      '#description' => $this->t("Label for the Feedback message type."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $feedback_message_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\feedback\Entity\FeedbackMessageType::load',
      ),
      '#disabled' => !$feedback_message_type->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $feedback_message_type = $this->entity;
    $status = $feedback_message_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Feedback message type.', [
          '%label' => $feedback_message_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Feedback message type.', [
          '%label' => $feedback_message_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($feedback_message_type->urlInfo('collection'));
  }

}
