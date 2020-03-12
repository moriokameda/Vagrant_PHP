<?php
function h($s) {// エスケープ関数
    return htmlspecialchars($s, ENT_QUOTES,'UTF-8');
}
