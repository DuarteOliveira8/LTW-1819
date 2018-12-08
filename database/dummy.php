<?php
$passwords = [
                'qwerty',
                '12345',
                '987654321',
                'matildesantos',
                'password9999',
                'afonsosantos',
                'AsdFgh',
                '111111111',
                'chico999',
                '918273645',
                '235711',
                'matildesantos',
                'vcketaA94',
                'drowssap',
                'Money',
                '123123123'
             ];

for ($i=0; $i < sizeof($passwords); $i++) {
  echo hash('sha256', $passwords[$i]), '<br>';
}

?>
