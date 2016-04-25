<?php

passthru('echo $(tput clear)');
passthru('echo $(tput cup 10 75)');
passthru('echo $(tput setaf 4)');
$mask = "|%5.5s |%-30.30s | x |\n";
printf($mask, 'Num', 'Title');
printf($mask, '1', 'A value that fits the cell');
printf($mask, '2', 'A too long value the end of which will be cut off');

passthru('echo $(reset)');
?>
