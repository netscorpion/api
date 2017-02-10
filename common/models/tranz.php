<?php

namespace app\common\models;

use Yii;
use yii\base\Model;


class tranz extends Model
{
    public $MDATA;
    public $ID_KLIENTA;
    public $GR_NOMER;
    public $ID_KOSH_ZA_CHTO;
    public $ID_KOSH_GLOBAL;
    public $DESCRIPTION_KOSH_ZA_CHTO;
    public $OPERATZIYA;
    public $ID_PRICHINY;
    public $DESCRIPTION_PRICHINY;
    public $SUMMA_ZA_CHTO;
    public $TERMINAL_COST;
    public $TERMINAL_SUMM;
    public $DISCONT_COST;
    public $DISCONT_SUMM;
    public $DELTA_PRICE;
    public $EM_GDE_OBSL;
    public $NOMER_TERMINALA;
    public $ID_TO;
    public $NAME_TO;
    public $ADDRESS_TO;
    public $TRN_GUID;

    /*
    public static function primaryKey()
    {
        return array('GR_NOMER');
    }

    */

    public function attributeLabels()
    {
        return [
                'MDATA' => 'MDATA',
                'ID_KLIENTA' =>'ID_KLIENTA',
                'GR_NOMER' =>'GR_NOMER' ,
                'ID_KOSH_ZA_CHTO' => 'ID_KOSH_ZA_CHTO',
                'ID_KOSH_GLOBAL' => 'ID_KOSH_GLOBAL',
                'DESCRIPTION_KOSH_ZA_CHTO' =>'DESCRIPTION_KOSH_ZA_CHTO',
                'OPERATZIYA' => 'OPERATZIYA'  ,
                'ID_PRICHINY' => 'ID_PRICHINY' ,
                'DESCRIPTION_PRICHINY' => 'DESCRIPTION_PRICHINY',
                'SUMMA_ZA_CHTO' => 'SUMMA_ZA_CHTO'  ,
                'TERMINAL_COST' =>'TERMINAL_COST'  ,
                'TERMINAL_SUMM' =>'TERMINAL_SUMM'  ,
                'DISCONT_COST' =>'DISCONT_COST'  ,
                'DISCONT_SUMM' =>'DISCONT_SUMM' ,
                'DELTA_PRICE' =>'DELTA_PRICE' ,
                'EM_GDE_OBSL' =>'EM_GDE_OBSL'  ,
                'NOMER_TERMINALA' =>'NOMER_TERMINALA',
                'ID_TO' =>'ID_TO'  ,
                'NAME_TO' =>'NAME_TO',
                'ADDRESS_TO' =>'ADDRESS_TO',
                'TRN_GUID' =>'TRN_GUID'  ,
        ];
    }

    public function afterFind()
    {
        $this->DESCRIPTION_KOSH_ZA_CHTO = iconv('windows-1251', 'UTF-8',$this->DESCRIPTION_KOSH_ZA_CHTO);
        $this->DESCRIPTION_PRICHINY = iconv('windows-1251', 'UTF-8',$this->DESCRIPTION_PRICHINY);
        $this->NAME_TO = iconv('windows-1251', 'UTF-8',$this->NAME_TO);
        $this->ADDRESS_TO = iconv('windows-1251', 'UTF-8',$this->ADDRESS_TO);
    }
}


