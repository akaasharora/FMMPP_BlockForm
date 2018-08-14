<?php
/**
 * @file
 * Contains \Drupal\dino_roar\Form\LaoImportFormBase.
 * Base settings for LAO Import, inherited by individual forms.
 * See LaoImportHelper for the actual web service ingestion / queue processing behaviour.
 */

namespace Drupal\dino_roar\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueWorkerManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dino_roar;

abstract class RoarFormBase extends ConfigFormBase {
    protected $ws_url_ct_member;
  /**
   *  Populate all variables with their stored configuration values upon instantiation
   */
  public function __construct(QueueFactory $queue, QueueWorkerManagerInterface $queue_manager) {
    $config = $this->config('dino_roar.settings');

    $this->ws_url_ct_member = $config->get('ws_url_ct_member');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
      return new static(
          $container->get('queue'),
          $container->get('plugin.manager.queue_worker')
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['dino_roar.settings',];
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'dino_roar_form_base';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }
}
