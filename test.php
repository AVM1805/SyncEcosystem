<?php
function isImage($path) {
    $exp = explode(".", $path);
    $img_exp = ['png', 'jpg', 'jpeg', 'svg', 'gif'];
    if(is_numeric(array_search($exp[1], $img_exp))) {
        return true;
    }
}

echo isImage("/public/files/1616272125Проживание.png");