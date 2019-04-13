<?php

namespace Drupal\loan\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LoanForm.
 */
class LoanForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'loan_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['start_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Start Date of Loan'),
      '#description' => $this->t('Start Date of Loan'),
      '#weight' => '0',
    ];
    $form['loan_amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Loan Amount'),
      '#description' => $this->t('Loan Amount'),
      '#default_value' => '0',
      '#weight' => '0',
    ];
    $form['interest_rate'] = [
      '#type' => 'number',
      '#title' => $this->t('Annual Interest Rate'),
      '#description' => $this->t('Annual Interest Rate'),
      '#default_value' => '0',
      '#weight' => '0',
    ];
    $form['loan_period'] = [
      '#type' => 'number',
      '#title' => $this->t('Loan Period in Years'),
      '#description' => $this->t('Loan Period in Years'),
      '#default_value' => '0',
      '#weight' => '0',
    ];
    $form['payments_per_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of Payments Per Year'),
      '#description' => $this->t('Number of Payments Per Year'),
      '#default_value' => '0',
      '#weight' => '0',
    ];
    $form['extra_payments'] = [
      '#type' => 'number',
      '#title' => $this->t('Optional Extra Payments'),
      '#default_value' => '0',
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $uid = \Drupal::currentUser()->id();
    \Drupal::logger('loan')->info($uid);


    $start_date = $form_state->getValue('start_date');
    $interest_rate = $form_state->getValue('interest_rate');
    $loan_amount = $form_state->getValue('loan_amount');
    $loan_period = $form_state->getValue('loan_period');
    $payments_per_year = $form_state->getValue('payments_per_year');
    $extra_payments = $form_state->getValue('extra_payments');

    $calculator = Drupal::service('loan.calculation');

    $results = $calculator->calculation($start_date, $interest_rate, $loan_amount, $loan_period, $payments_per_year,  $extra_payments);

    $form_state-> setRebuild();

    // Display result.


    $header = [
      [
        'data' => t('Loan Summary'),
        'class' => 'text-nowrap',
      ],
    ];

    $output  = [
        [
          t('Scheduled Payment'),
          $results['amount'],
        ],


      [
         t('Scheduled Number of Payments'),
         $results['months'],
      ],
      [
         t('Actual Number of Payments'),
         $results['i'],
      ],
      [
         t('Total Early Payments'),
         $results['total_extra_payments'],
      ],
      [
         t('Total Interest'),
         $results['total_interest'],
      ],
    ];

    $table_1 = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $output,
    ];


    $header = [
      [
        'data' => t('PmtNo.'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Payment Date'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Beginning Balance'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Scheduled Payment'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Extra Payment'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Total Payment'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Principal'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Interest'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Ending Balance'),
        'class' => 'text-nowrap',
      ],
      [
        'data' => t('Cumulative Interest'),
        'class' => 'text-nowrap',
      ],
      '',
    ];

    $table_2 = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $results['rows'],
    ];

    Drupal::messenger()->addMessage($table_1);
    Drupal::messenger()->addMessage($table_2);

    return;
  }

}
