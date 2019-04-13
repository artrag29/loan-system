<?php

namespace Drupal\loan\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class LoanController.
 */
class LoanController extends ControllerBase {

  /**
   * Show.
   *
   * @return string
   *   Return Hello string.
   */
  public function show() {

    $header = [
      [
        'data' => 'Scheduled Payment',
        'class' => 'col-4 text-nowrap',
      ],
      [
        'data' => 'Scheduled Number of Payments',
        'class' => 'col-4 text-nowrap',
      ],
      [
        'data' => 'Actual Number of Payments',
        'class' => 'col-4 text-nowrap',
      ],
      [
        'data' => 'Total Early Payments',
        'class' => 'col-4 text-nowrap',
      ],
      [
        'data' => 'Total Interest',
        'class' => 'col-4 text-nowrap',
      ],
    ];

    $rows = [];


    $loanForm = \Drupal::formBuilder()->getForm('Drupal\loan\Form\LoanForm');

    $rows[] = [
      [
        'data' => $loanForm['loan_amount']['#value'],
        'class' => 'text-nowrap',
      ],
    ];

    $table = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $table;

  }

}
