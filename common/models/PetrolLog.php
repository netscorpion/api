<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "ECFIL067".
 *
 * @property string $DATA
 * @property integer $VREMYA
 * @property string $STROKA
 * @property integer $TIP_SOBUTIYA
 * @property integer $ID_KTO_RABOTAL
 * @property string $RID
 * @property string $NAME_COMP
 * @property string $USER_COMP
 * @property string $SERTIF
 * @property integer $LAST_RECORD
 */
class PetrolLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ECFIL067';
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
            [['VREMYA', 'TIP_SOBUTIYA', 'ID_KTO_RABOTAL', 'LAST_RECORD'], 'integer'],
            [['RID'], 'required'],
            [['RID'], 'number'],
            [['DATA'], 'string', 'max' => 7],
            [['STROKA'], 'string', 'max' => 1000],
            [['NAME_COMP'], 'string', 'max' => 100],
            [['USER_COMP'], 'string', 'max' => 30],
            [['SERTIF'], 'string', 'max' => 32],
            [['RID'], 'unique'],
            [['LAST_RECORD'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DATA' => 'Data',
            'VREMYA' => 'Vremya',
            'STROKA' => 'Stroka',
            'TIP_SOBUTIYA' => 'Tip  Sobutiya',
            'ID_KTO_RABOTAL' => 'Id  Kto  Rabotal',
            'RID' => 'Rid',
            'NAME_COMP' => 'Name  Comp',
            'USER_COMP' => 'User  Comp',
            'SERTIF' => 'Sertif',
            'LAST_RECORD' => 'Last  Record',
        ];
    }
}
