<?php

// flash message
function flash($message)
{
    $_SESSION['flash'] = $message;
}

function flashForm($message)
{
    $_SESSION['flashForm'] = $message;
}
?>
