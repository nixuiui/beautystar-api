<?php
function addStyle($src) {
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . asset($src) . "\"/>";
}
function addScriptJs($src) {
    echo "<script src=\"" . asset($src) . "\" type=\"text/javascript\"></script>";
}
function htmlAlert($class, $message) {
    switch ($class) {
        case 'success':
            $icon = "check";
            break;
        case 'info':
            $icon = "info-outline";
            break;
        case 'warning':
            $icon = "alert-triangle";
            break;
        case 'danger':
            $icon = "close-circle-o";
            break;
        default:
            // code...
            break;
    }
    echo "
        <div role=\"alert\" class=\"alert alert-". $class ." alert-icon alert-dismissible\">
            <div class=\"icon\"><span class=\"mdi mdi-" . $icon . "\"></span></div>
            <div class=\"message\">
                <button type=\"button\" data-dismiss=\"alert\" aria-label=\"Close\" class=\"close\"><span aria-hidden=\"true\" class=\"mdi mdi-close\"></span></button>
                " . $message . "
            </div>
        </div>";
}
