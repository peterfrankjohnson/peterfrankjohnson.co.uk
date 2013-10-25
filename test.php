<?php

$message = print_r( $_SERVER , true );
mail ( 'peter.johnson@web-tonic.co.uk', 'Test Message', $message );
