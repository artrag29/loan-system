<?php

namespace Drupal\loan\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LoanConfigForm.
 */
class LoanConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'loan.loanconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'loan_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('loan.loanconfig');

    $form['start_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Start Date of Loan'),
      '#default_value' => $config->get('start_date'),
    ];

    $form['loan_amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Loan Amount'),
      '#default_value' => $config->get('loan_amount'),
    ];

    $form['interest_rate'] = [
      '#type' => 'number',
      '#title' => $this->t('Annual Interest Rate'),
      '#default_value' => $config->get('interest_rate'),
    ];

    $form['loan_period'] = [
      '#type' => 'number',
      '#title' => $this->t('Loan Period in Years'),
      '#default_value' => $config->get('loan_period'),
    ];

    $form['payments_per_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of Payments Per Year'),
      '#default_value' => $config->get('payments_per_year'),

    ];

    $form['extra_payments'] = [
      '#type' => 'number',
      '#title' => $this->t('Optional Extra Payments'),
      '#default_value' => $config->get('extra_payments'),
    ];


    return parent::buildForm($form, $form_state);
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
    parent::submitForm($form, $form_state);

    $this->config('loan.loanconfig')
      ->set('start_date', $form_state->getValue('start_date'))
      ->set('loan_amount', $form_state->getValue('loan_amount'))
      ->set('interest_rate', $form_state->getValue('interest_rate'))
      ->set('loan_period', $form_state->getValue('loan_period'))
      ->set('payments_per_year', $form_state->getValue('payments_per_year'))
      ->set('extra_payments', $form_state->getValue('extra_payments'))
      ->save();
  }

}
