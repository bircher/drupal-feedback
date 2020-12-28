<?php

/**
 * @file
 * Contains \Drupal\feedback\FeedbackMessageListBuilder.
 */

namespace Drupal\feedback;

use Drupal\Core\Link;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Feedback message entities.
 *
 * @ingroup feedback
 */
class FeedbackMessageListBuilder extends EntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Feedback message ID');
    $header['name'] = $this->t('Name');
    $header['path'] = $this->t('Path');
    $header['user'] = $this->t('User');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\feedback\Entity\FeedbackMessage */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl($entity->label(), new Url(
      'entity.feedback_message.canonical', array(
        'feedback_message' => $entity->id(),
      )
    ));
    $row['path'] = $entity->getPath();
    $owner = $entity->getOwner();
    $row['user'] = $owner->id() ? $owner->toLink() : $owner->getDisplayName();

    return $row + parent::buildRow($entity);
  }

}
