<?php


/**
 * Handle response formatting
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class Utils {

    /**
     * Escape the given string
     * @param $input string to be escaped
     * @return string escaped string
     */
    private static function escape($input) {
        if(is_array($input)){
            array_walk_recursive($input,function (&$val,$key){
                $val = htmlspecialchars(trim($val), ENT_QUOTES);
            });
            return $input;
        }
        return htmlspecialchars(trim($input), ENT_QUOTES);
    }

    /**
     * Function to search array data for a specific value by the provided key
     * Returns the found array keys
     * @param array $arrayData
     * @param string $searchKey
     * @param string $searchValue
     * @return array|boolean
     */
    private static function searchMultiArrayByKeyReturnKeys($arrayData, $searchKey, $searchValue) {
        $size = is_array($arrayData) ? sizeof($arrayData) : 0;
        for ($i = 0; $i < $size; $i++) {
            if (strtolower($arrayData[$i][$searchKey]) == strtolower($searchValue)) {
                return $arrayData[$i];
            }
        }
        return false;
    }

    /**
     * Get SDP callback data from an array
     * @param $responseData
     * @param $item
     * @return mixed|string
     */
    public static function getCallbackResponseDataItemValue($responseData, $item) {

        $itemValue = "";

        $search = self::searchMultiArrayByKeyReturnKeys($responseData, "name", $item);

        if (sizeof($search) > 0) {
            $itemValue = $search['value'];
        }

        return $itemValue;
    }
}