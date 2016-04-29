<?php

for ($i = 1; $i < 11; $i++) {
      echo "$i\n";
          sleep(1);
              echo "\033[1A";
}

?>
