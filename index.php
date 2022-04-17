<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Калькулятор</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <form action="index.php" method="POST" class="calc" style="gap: 3px;">
    <input type="text" readonly name="calc" class="equation">
    <input value="(" type="button" class="calc-element bracket-open">
    <input value=")" type="button" class="calc-element bracket-close">
    <input value="C" type="button" class="delete">
    <input value="/" type="button" class="calc-element division">
    <input value="7" type="button" class="calc-element seven">
    <input value="8" type="button" class="calc-element eight">
    <input value="9" type="button" class="calc-element nine">
    <input value="*" type="button" class="calc-element multiplication">
    <input value="4" type="button" class="calc-element four">
    <input value="5" type="button" class="calc-element five">
    <input value="6" type="button" class="calc-element six">
    <input value="-" type="button" class="calc-element minus">
    <input value="1" type="button" class="calc-element one">
    <input value="2" type="button" class="calc-element two">
    <input value="3" type="button" class="calc-element three">
    <input value="+" type="button" class="calc-element plus">
    <input type="button">
    <input value="0" type="button" class="calc-element zero">
    <input type="button">
    <input type="submit" class="equal" value="=">
  </form>

  <?php
    $calc = "";
    if (!empty($_POST["calc"])) {
      $calc = $_POST["calc"];
    }

    $result = "";
    if (!empty($calc)) {
      $result = calc($calc)[0];
    }

    function bracketError($seq) {
      if (array_count_values($seq)["("] != array_count_values($seq)[")"]) {
        return true;
      } else {
        return false;
      }
    }

    function calc($calc) {
      if (gettype($calc) == "string") {
        $seq = to_array($calc);
      }
      else {
        $seq = $calc;
      }

      if (bracketError($seq)) {
        return ["Беды со скобками"];
      }

      $bracketsOpen = 99999;
      $bracketsClose = 99999;

      if (array_search("(", $seq) !== false) {
        $bracketOpenPosition = array_search("(", $seq);
        $seq[$bracketOpenPosition] = "#";

        $seqReverse = array_reverse($seq);
        $bracketClosePosition = (count($seq) - array_search(")", $seqReverse) - 1);
        $seq[$bracketClosePosition] = "#";
          
        $bracketsOpen = $bracketOpenPosition;
        $bracketsClose = $bracketClosePosition;
      }
      
      if ($bracketsOpen != 99999) {
        $res = array_slice($seq, $bracketsOpen, $bracketsClose + 1);
        array_pop($res);
        array_shift($res);
        $res = calc($res);
        
        array_splice($seq, $bracketsOpen, $bracketsClose - $bracketsOpen + 1, $res);
        return calc($seq);
      }
      $index = 0;
      while ($index < count($seq) - 1) {
        if ($seq[$index] == "*") {
          $seq = mult($seq, $index);
          $index--;
        }
        else if ($seq[$index] == "/") {
          $seq = div($seq, $index);
          $index--;
        }
        $index++;
      }
      $index = 0;
      while ($index < count($seq) - 1) {
        if ($seq[$index] == "+") {
          $seq = plus($seq, $index);
          $index--;
        }
        else if ($seq[$index] == "-") {
          $seq = minus($seq, $index);
          $index--;
        }
        $index++;
      }
      return $seq;
    }

    function mult($seq, $index) {
      $res = (string)((int)$seq[$index - 1] * (int)$seq[$index + 1]);
      array_splice($seq, $index - 1, 3, $res);
      return $seq;
    }
    function div($seq, $index) {
      $res = (string)((int)$seq[$index - 1] / (int)$seq[$index + 1]);
      array_splice($seq, $index - 1, 3, $res);
      return $seq;
    }
    function plus($seq, $index) {
      $res = (string)((int)$seq[$index - 1] + (int)$seq[$index + 1]);
      array_splice($seq, $index - 1, 3, $res);
      return $seq;
    }
    function minus($seq, $index) {
      $res = (string)((int)$seq[$index - 1] - (int)$seq[$index + 1]);
      array_splice($seq, $index - 1, 3, $res);
      return $seq;
    }

    function to_array($calc) {
      $res = explode(" ", $calc);
      array_pop($res);
      return $res;
    }
  ?>
  <script>
    let res = "<?=$result?> ";
  </script>
  <script src="script.js"></script>
</body>
</html>