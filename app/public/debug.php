<?php

function dd(...$vars) {
    foreach ($vars as $var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

}

function h(string $value): string{
    return htmlentities($value);
}