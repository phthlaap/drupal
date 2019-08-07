<?php
/**
 * @ file
 * Created by IntelliJ IDEA.
 * User: pc07
 * Date: 11/06/2019
 * Time: 10:49
 */
namespace Drupal\subscribe\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Creates a 'Foobar' Block
 * @Block(
 * id = "subscribe_block_8xd",
 * admin_label = @Translation("Module Subscribe"),
 * )
 */

class SubscribeBlock extends BlockBase
{
  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form = \Drupal::formBuilder()->getForm('Drupal\subscribe\Form\SubscribeForm');
    return $form;
  }

}