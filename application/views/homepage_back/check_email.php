<?php

if($_POST)
{
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
     http_response_code(200); // Email is good
}
else {
      http_response_code(418); // I'm a teapot. Email is bad.
}
}
?>
