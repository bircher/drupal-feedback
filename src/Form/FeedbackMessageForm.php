<?php

/**
 * @file
 * Contains \Drupal\feedback\Form\FeedbackMessageForm.
 */

namespace Drupal\feedback\Form;

use Drupal\Core\Config\Entity\ConfigEntityStorage;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManagerInterface;

/**
 * Form controller for Feedback message edit forms.
 *
 * @ingroup feedback
 */
class FeedbackMessageForm extends ContentEntityForm {

  /**
   * The feedback_message_type storage.
   *
   * @var \Drupal\Core\Config\Entity\ConfigEntityStorage
   */
  protected $feedbackMessageTypeStorage;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->feedbackMessageTypeStorage = $container->get('entity_type.manager')
      ->getStorage('feedback_message_type');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\feedback\Entity\FeedbackMessage */
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        /* @var $message_type \Drupal\feedback\Entity\FeedbackMessageType */
        $message_type = $this->feedbackMessageTypeStorage->load($entity->getType());
        $this->messenger()->addStatus($message_type->getSuccessMessage());
        break;

      default:
        $this->messenger()->addStatus($this->t('Saved the %label Feedback message.', [
          '%label' => $entity->label(),
        ]));
    }
  }

}
