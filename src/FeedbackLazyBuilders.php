<?php

/**
 * @file
 * Contains \Drupal\comment\CommentLazyBuilders.
 */

namespace Drupal\feedback;

use Drupal\comment\CommentManagerInterface;
use Drupal\comment\Plugin\Field\FieldType\CommentItemInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfo;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;

/**
 * Defines a service for comment #lazy_builder callbacks.
 */
class FeedbackLazyBuilders {

  /**
   * The entity manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfo
   */
  protected $bundleInfo;
  
  /**
   * The entity manager service.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The entity form builder service.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilderInterface
   */
  protected $entityFormBuilder;

  /**
   * Comment manager service.
   *
   * @var \Drupal\comment\CommentManagerInterface
   */
  protected $commentManager;

  /**
   * Current logged in user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a new CommentLazyBuilders object.
   *
   * @param \Drupal\Core\Entity\EntityTypeBundleInfo $bundle_info
   *   The bundle info service to know which feedback types exist.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity manager service.
   * @param \Drupal\Core\Entity\EntityFormBuilderInterface $entity_form_builder
   *   The entity form builder service.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current logged in user.
   * @param \Drupal\comment\CommentManagerInterface $comment_manager
   *   The comment manager service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(EntityTypeBundleInfo $bundle_info, EntityTypeManagerInterface $entity_manager, EntityFormBuilderInterface $entity_form_builder, AccountInterface $current_user, ModuleHandlerInterface $module_handler, RendererInterface $renderer) {
    $this->bundleInfo = $bundle_info;
    $this->entityManager = $entity_manager;
    $this->entityFormBuilder = $entity_form_builder;
    $this->currentUser = $current_user;
    $this->moduleHandler = $module_handler;
    $this->renderer = $renderer;
  }

  /**
   * #lazy_builder callback; builds the feedback form.
   *
   * @param string $commented_entity_type_id
   *   The commented entity type ID.
   * @param string $commented_entity_id
   *   The commented entity ID.
   * @param string $field_name
   *   The comment field name.
   * @param string $comment_type_id
   *   The comment type ID.
   *
   * @return array
   *   A renderable array containing the comment form.
   */
  public function renderForm($type, $path, $query_string = NULL) {
    if ($query_string) {
      $path .= '?' . $query_string;
    }
    $values = [
      'type' => $type,
      'link' => $path,
    ];

    $feedback = $this->entityManager->getStorage('feedback_message')->create($values);
    return $this->entityFormBuilder->getForm($feedback);
  }

}
