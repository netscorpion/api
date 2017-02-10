<?php
/**
 * Created by PhpStorm.
 * User: a.gorshkov
 * Date: 18.01.2017
 * Time: 13:39
 */

namespace app\common\controllers;
use yii\rest\Serializer;

class MySerializer extends Serializer
{
    public function serialize($data)
    {
        $d = parent::serialize($data);
        
        if ($d != null) {
            $myData = $d['tranzs'];
            $myLink = $d['_links'];
            $myMeta = $d['_meta'];

            if ($myData  != null)
            {
                foreach ($myData  as &$row) {
                    $row['DESCRIPTION_PRICHINY'] = iconv('windows-1251', 'UTF-8', $row['DESCRIPTION_PRICHINY']);
                    $row['NAME_TO'] = iconv('windows-1251', 'UTF-8', $row['NAME_TO']);
                    $row['ADDRESS_TO'] = iconv('windows-1251', 'UTF-8', $row['ADDRESS_TO']);
                    $row['DESCRIPTION_KOSH_ZA_CHTO'] = iconv('windows-1251', 'UTF-8', $row['DESCRIPTION_KOSH_ZA_CHTO']);
                }
            }
            return array('tranzs' => $myData, '_links' => $myLink , '_meta' => $myMeta);
        }
    }
}

?>