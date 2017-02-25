<?php

namespace Drupal\kalkulator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Controller routines for page example routes.
 */
class PageMain extends ControllerBase {

  /**
   * Page.
   */
  public function page($nid) {

    $node = Node::load($nid);
    if($node->getType() == 'kalkulator'){
      $result = $this->res($node);
      $itog = $this->itog($node);
      $node->field_kalkulator_rez->setValue($result);
      $node->field_kalkulator_itog->setValue($itog);
      $node->save(TRUE);
    }
    else {
      return FALSE;
    }

    $output = [
      'text' => [
        '#type' => 'markup',
        '#markup' => 'R:' . $nid,
      ],
    ];
    return $output;
  }
  /**
   * Расчет результатов. Вовращает цифру.
   */
  public static function res($node) {
    $kapit = $node->field_kalkulator_kapit->value;
    $procent = $node->field_kalkulator_procent->value;
    $sroc = $node->field_kalkulator_srock->value;
    $summa = $node->field_kalkulator_summa->value;
    $pr_za_mes = ($summa * $procent / 100) / 12;
    $result = $summa;
    if ($kapit == TRUE) {
      for ($i = 1; $i <= $sroc; $i++) {
        $result = ($result + $result * $procent / 100 / 12);
      }
      $result = $result - $summa;      
    }
    else {
        $result = $pr_za_mes * $sroc;
    }
    return $result;
  }

  public static function itog($node) {
    $kapit = $node->field_kalkulator_kapit->value;
    $procent = $node->field_kalkulator_procent->value;
    $sroc = $node->field_kalkulator_srock->value;
    $summa = $node->field_kalkulator_summa->value;
    $pr_za_mes = ($summa * $procent / 100) / 12;
    $itog = $summa;
    if ($kapit == TRUE) {
      for ($i = 1; $i <= $sroc; $i++) {
        $itog = $itog + $itog * $procent / 100 / 12;
      }
    }
    else {
        $itog = $summa + $pr_za_mes * $sroc;
    }
    return $itog;
  }

}
