<?php
/*****
 * http://rest.test/cards?&expand=purses&hash=0L/QsNGA0L7Qu9GMINC00LvRjyDQntCZ0JvQodC40YHRgtC10Lw=
 */


namespace app\common\models;

use Yii;

/**
 * This is the model class for table "V_ECFIL015".
 *
 * @property integer $ID_CARD
 * @property string $CARD_NUMBER
 * @property string $MONTHLY_LIMIT
 * @property string $ID_SERVICES
 * @property string $SIZE_PURSE
 * @property string $BORDER_OVERDRAFT
 * @property string $LIMIT_PURSE
 * @property string $ID_CIRCUIT
 * @property string $DESCRIPTION_CIRCUIT
 * @property string $INDIVIDUAL_LIMIT
 * @property string $ID_PHYSICAL
 */
class purse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_ECFIL015';
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
            [['ID_CARD'], 'integer'],
            [['CARD_NUMBER', 'MONTHLY_LIMIT', 'ID_SERVICES', 'SIZE_PURSE', 'BORDER_OVERDRAFT', 'LIMIT_PURSE', 'ID_CIRCUIT', 'INDIVIDUAL_LIMIT', 'ID_PHYSICAL'], 'number'],
            [['DESCRIPTION_CIRCUIT'], 'string', 'max' => 6],
            [['ID_CARD'], 'exist', 'skipOnError' => true, 'targetClass' => cards::className(), 'targetAttribute' => ['ID_CARD' => 'ID_CARD']],
            // [['ID_SERVICES'], 'exist', 'skipOnError' => true, 'targetClass' => services::className(), 'targetAttribute' => ['ID_SERVICES' => 'ID_SERVICES']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_CARD' => 'Id  Card',
            'CARD_NUMBER' => 'Card  Number',
            'MONTHLY_LIMIT' => 'Monthly  Limit',
            'ID_SERVICES' => 'Id  Services',
            'SIZE_PURSE' => 'Size  Purse',
            'BORDER_OVERDRAFT' => 'Border  Overdraft',
            'LIMIT_PURSE' => 'Limit  Purse',
            'ID_CIRCUIT' => 'Id  Circuit',
            'DESCRIPTION_CIRCUIT' => 'Description  Circuit',
            'INDIVIDUAL_LIMIT' => 'Individual  Limit',
            'ID_PHYSICAL' => 'Id  Physical',
        ];
    }

public function fields()
{

    return [
        'ID_SERVICES',
        'SERVICES_DESCRIPTION' => function(){
            return $this->getser($this->ID_SERVICES);
        },
        'LIMIT_PURSE',
        'MONTHLY_LIMIT',
        'INDIVIDUAL_LIMIT',
    ];

    }
    public function getservices()
    {
        return $this->hasOne(services::className(), ['ID_SERVICES' => 'ID_SERVICES']);
    }

    public function afterFind()
    {
        $this->DESCRIPTION_CIRCUIT = iconv('windows-1251', 'UTF-8',$this->DESCRIPTION_CIRCUIT);
    }

    /***
     * @param $id
     * @return string
     */
    public function getser($id)
    {
        switch ($id) {
            case 1:
                return 'Рубли';
                break;
            case 3:
                return 'Аи-80';
                break;
            case 4:
                return 'Аи-92';
                break;
            case 5:
                return 'Аи-95';
                break;
            case 6:
                return 'Дт';
                break;
            case 7:
                return 'Дт зим.';
                break;
            case 8:
                return 'Мойка';
                break;
            case 9:
                return 'Аи-98';
                break;
            case 10:
                return 'Газ пропан-бутан';
                break;
            case 11:
                return 'Бонусы';
                break;
            case 12:
                return 'ДТplus';
                break;
            case 13:
                return 'Евро 92/4';
                break;
            case 14:
                return 'Евро 95/4';
                break;
            case 15:
                return 'AdBlueR';
                break;
            case 16:
                return 'Дт Арктика';
                break;
        }
    }

}
