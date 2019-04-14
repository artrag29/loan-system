<?php

namespace Drupal\loan\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'LoanBlock' block.
 *
 * @Block(
 *  id = "loan_block",
 *  admin_label = @Translation("Loan block"),
 * )
 */
class LoanBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $build = Drupal::formBuilder()->getForm('Drupal\loan\Form\LoanForm');

    return $build;
  }

}
