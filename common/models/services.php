<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "V_ECFIL001".
 *
 * @property integer $ID_SERVICES
 * @property string $UNIT_OF_MEASUREMENTS
 * @property string $NAME_SERVICES
 * @property string $UNIT_LETTER
 * @property string $UNIT_REDUCED_NAME
 * @property integer $IS_CURRENCY
 * @property integer $CURRENCY_CODE
 */
class services extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_ECFIL001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oc1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_SERVICES', 'UNIT_OF_MEASUREMENTS', 'NAME_SERVICES', 'UNIT_LETTER', 'UNIT_REDUCED_NAME', 'IS_CURRENCY'], 'required'],
            [['ID_SERVICES', 'IS_CURRENCY', 'CURRENCY_CODE'], 'integer'],
            [['UNIT_OF_MEASUREMENTS'], 'string', 'max' => 10],
            [['NAME_SERVICES'], 'string', 'max' => 40],
            [['UNIT_LETTER'], 'string', 'max' => 2],
            [['UNIT_REDUCED_NAME'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_SERVICES' => 'Id  Services',
            'UNIT_OF_MEASUREMENTS' => 'Unit  Of  Measurements',
            'NAME_SERVICES' => 'Name  Services',
            'UNIT_LETTER' => 'Unit  Letter',
            'UNIT_REDUCED_NAME' => 'Unit  Reduced  Name',
            'IS_CURRENCY' => 'Is  Currency',
            'CURRENCY_CODE' => 'Currency  Code',
        ];
    }
    public function afterFind()
    {
        $this->NAME_SERVICES = iconv('windows-1251', 'UTF-8',$this->NAME_SERVICES);
    }

}
