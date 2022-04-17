<?php
  function trig($expression) {
    $subarr = explode("(", $expression);
    $number = (int)$subarr[1];
    $trig_funcs = ["sin", "cos", "tan"];
    foreach ($trig_funcs as $func) {
      if ($func == substr($expression, 0, 3)) {
        switch ($func) {
          case ("sin"):
            return (string)sin($number);
          case ("cos"):
            return (string)cos($number);
          case ("tan"):
            return (string)tan($number);
        }
      }
    }
  }
?>