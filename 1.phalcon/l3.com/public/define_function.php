<?php

/**
 * return price
 * ex: 1001 => 1 tỷ 1 triệu
 * @author Tom
 */
function convertPrice($price) {
    if(empty($price)) {
        return "Đang cập nhật...";
    }
    if($price < 1000) {
        return $price . ' triệu';
    }
    $ty = (int)($price / 1000);
    $ty = $ty . ' tỷ ';
    $trieu = $price % 1000;
    return $ty . ($trieu > 0 ? $trieu.' triệu' : '');
}

/**
 * return price
 * ex: 1001 => $ 1,001
 * @author Tom
 */
function convertPriceEn($price) {
    if(empty($price)) {
        return "Updating...";
    }
    return "$ ".number_format($price);
}