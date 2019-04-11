<?php

namespace Drupal\loan\Service;

use PhpOffice\PhpSpreadsheet\Calculation\Financial;

/**
 * Class calculation.
 */
class Calculation {


  public function calculation($start_date, $interest_rate, $loan_amount, $loan_period, $payments_per_year,  $extra_payments) {

    $rate = $interest_rate/100/$payments_per_year;
    $months = $payments_per_year*$loan_period;
    $loan = $loan_amount;

    if ($rate!= 0) {
      $amount = number_format(($rate * -$loan * pow((1 + $rate), $months) / (1 - pow((1 + $rate), $months))), 3);
    } else {
      $amount = $loan / $months;
    }

    $rows = [];
    $beginning_balance = $loan;
    $cumulative_interest = 0;
    $pay_date = strtotime($start_date);
    $total_extra_payments = 0;
    $total_interest = 0;
    $i = 0;
    while ( $i <= $beginning_balance ) {
      $i++;
      $interest = number_format(($beginning_balance * ($interest_rate/100/$payments_per_year)),3);
      if ($amount + $extra_payments < $beginning_balance) {
        $total_payment = $amount + $extra_payments;
      }else {
        $total_payment = $beginning_balance;
      }
      if ($amount + $extra_payments < $beginning_balance) {
         $extra_payments;
      } elseif ( $amount < $beginning_balance ) {
        $extra_payments = $beginning_balance - $amount;
      } else {
        $extra_payments = 0;
      }

      $principal =  $total_payment - $interest;
      $cumulative_interest += $interest;

      $date = date('Y-m-d', $pay_date);

      $pay_date = strtotime('+1 month', $pay_date);


      if ($total_payment < $beginning_balance) {
        $ending_balance = $beginning_balance - $principal;
      }
      else {
        $ending_balance = 0;
      }


      $rows[] = [
        $i,
        $date,
        number_format($beginning_balance,3),
        number_format($amount,3),
        number_format($extra_payments,3),
        number_format($total_payment,3),
        number_format($principal,3),
        number_format($interest,3),
        number_format($ending_balance,3),
        number_format($cumulative_interest,3),
      ];

      $beginning_balance = $ending_balance;
      $total_interest += $interest;
      $total_extra_payments += $extra_payments;
    }


    return;
  }

}
