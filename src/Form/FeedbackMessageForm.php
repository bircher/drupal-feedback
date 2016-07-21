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
   * Constructs a ContentEntityForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Config\Entity\ConfigEntityStorage $feedback_message_type_storage
   *   The feedback message type storage.
   */
  public function __construct(EntityManagerInterface $entity_manager, ConfigEntityStorage $feedback_message_type_storage) {
    parent::__construct($entity_manager);
    $this->feedbackMessageTypeStorage = $feedback_message_type_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('entity.manager')->getStorage('feedback_message_type')
    );
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
        /* @var $message_type FeedbackMessageType */
        $message_type = $this->feedbackMessageTypeStorage->load($entity->getType());
        drupal_set_message($message_type->getSuccessMessage());
        break;

      default:
        drupal_set_message($this->t('Saved the %label Feedback message.', [
          '%label' => $entity->label(),
        ]));
    }
  }

}
