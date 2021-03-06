<?php

namespace app\modules\v02\models;

use app\common\models\tranz;
use Yii;


/**
 * This is the model class for table "V_ECFIL012".
 *
 * @property integer $ID_CARD
 * @property integer $ID_BELONGING
 * @property string $DESCRIPTION_BELONGING
 * @property integer $ID_CLIENT
 * @property integer $ID_CONDITION
 * @property string $DESCRIPTION_CONDITION
 * @property integer $CARD_NUMBER
 * @property integer $TYPE_CARD
 * @property string $DESCRIPTION_TYPE_CARD
 * @property integer $PHYSICALLY_CARD
 * @property string $DESCRIPTION_PHYSICALLY
 * @property string $DATE_CARD
 * @property string $ID_PERSONNEL
 * @property integer $NUMBER_TERMINAL
 * @property string $REASON_NOT_WORKING_CONDITION
 * @property string $HOLDER_CARD
 * @property string $PROTECTION_PIN
 * @property integer $NEW_CARD
 * @property integer $ID_FIRM_IN_CARD
 * @property integer $ID_FILIAL_IN_CARD
 * @property string $EXP_DATE
 * @property string $PAN_CODE_CARD
 * @property string $PIN_CODE_CARD
 * @property integer $ID_LOYALTY_PATTERN
 * @property string $E_MAIL
 * @property integer $DETALING_ID
 * @property string $DET_MESSAGE1
 * @property string $DET_MESSAGE2
 */
class cards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_ECFIL012';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oc1');
    }


    public static function primaryKey()
    {
        return array('CARD_NUMBER');
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_CARD', 'ID_BELONGING', 'ID_CLIENT', 'ID_CONDITION', 'CARD_NUMBER', 'TYPE_CARD', 'PHYSICALLY_CARD', 'NUMBER_TERMINAL', 'HOLDER_CARD', 'PROTECTION_PIN', 'NEW_CARD', 'ID_FIRM_IN_CARD', 'ID_FILIAL_IN_CARD', 'EXP_DATE', 'PAN_CODE_CARD', 'PIN_CODE_CARD', 'ID_LOYALTY_PATTERN', 'DETALING_ID'], 'required'],
            [['ID_CARD', 'ID_BELONGING', 'ID_CLIENT', 'ID_CONDITION', 'CARD_NUMBER', 'TYPE_CARD', 'PHYSICALLY_CARD', 'NUMBER_TERMINAL', 'NEW_CARD', 'ID_FIRM_IN_CARD', 'ID_FILIAL_IN_CARD', 'ID_LOYALTY_PATTERN', 'DETALING_ID'], 'integer'],
            [['ID_PERSONNEL'], 'number'],
            [['DESCRIPTION_BELONGING'], 'string', 'max' => 18],
            [['DESCRIPTION_CONDITION', 'DET_MESSAGE1', 'DET_MESSAGE2'], 'string', 'max' => 16],
            [['DESCRIPTION_TYPE_CARD'], 'string', 'max' => 17],
            [['DESCRIPTION_PHYSICALLY'], 'string', 'max' => 12],
            [['DATE_CARD', 'EXP_DATE'], 'string', 'max' => 7],
            [['REASON_NOT_WORKING_CONDITION', 'E_MAIL'], 'string', 'max' => 100],
            [['HOLDER_CARD'], 'string', 'max' => 62],
            [['PROTECTION_PIN'], 'string', 'max' => 10],
            [['PAN_CODE_CARD'], 'string', 'max' => 30],
            [['PIN_CODE_CARD'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_CARD' => 'Id  Card',
            'ID_BELONGING' => 'Id  Belonging',
            'DESCRIPTION_BELONGING' => 'Description  Belonging',
            'ID_CLIENT' => 'Id  Client',
            'ID_CONDITION' => 'Id  Condition',
            'DESCRIPTION_CONDITION' => 'Description  Condition',
            'CARD_NUMBER' => 'Card  Number',
            'TYPE_CARD' => 'Type  Card',
            'DESCRIPTION_TYPE_CARD' => 'Description  Type  Card',
            'PHYSICALLY_CARD' => 'Physically  Card',
            'DESCRIPTION_PHYSICALLY' => 'Description  Physically',
            'DATE_CARD' => 'Date  Card',
            'ID_PERSONNEL' => 'Id  Personnel',
            'NUMBER_TERMINAL' => 'Number  Terminal',
            'REASON_NOT_WORKING_CONDITION' => 'Reason  Not  Working  Condition',
            'HOLDER_CARD' => 'Holder  Card',
            'PROTECTION_PIN' => 'Protection  Pin',
            'NEW_CARD' => 'New  Card',
            'ID_FIRM_IN_CARD' => 'Id  Firm  In  Card',
            'ID_FILIAL_IN_CARD' => 'Id  Filial  In  Card',
            'EXP_DATE' => 'Exp  Date',
            'PAN_CODE_CARD' => 'Pan  Code  Card',
            'PIN_CODE_CARD' => 'Pin  Code  Card',
            'ID_LOYALTY_PATTERN' => 'Id  Loyalty  Pattern',
            'E_MAIL' => 'E  Mail',
            'DETALING_ID' => 'Detaling  ID',
            'DET_MESSAGE1' => 'Det  Message1',
            'DET_MESSAGE2' => 'Det  Message2',

        ];
    }
    public function fields()
    {
        return [
            'ID_CARD',
            'ISSUE_DATE' => function(){return date('d.m.Y',strtotime($this->DATE_CARD));},
            'ID_CLIENT',
            'CARD_NUMBER',
            'HOLDER_CARD',
            'DATE_LAST_SERVICE' => function(){return $this->getLastService($this->CARD_NUMBER);},
            'ID_CONDITION',
            'DESCRIPTION_CONDITION',
            ];
    }
    public function extraFields()
    {
        return ['limits'];
    }
    // Модернизируем вывод кошельков
    public function getlimits()
    {
        // Получение списка кошельков
        $_limits = limit::find()->where(['ID_CARD' => $this->ID_CARD])->andWhere(['<>', 'ID_SERVICES', '11']) ->asArray()->all();
        $_new_limits = array();
        $_i_limit = array('AMOUNT'=> '', 'UNIT' => '', 'TYPE' => '', 'CODE' => '','FUEL' => '');

        foreach ($_limits  as $limit)
        {

            // Проверка индивидуального лимита
            if ($limit['INDIVIDUAL_LIMIT'] == 0)
            {
                $_i_limit = array_replace($_i_limit,[
                    'AMOUNT' => $limit['LIMIT_PURSE'],
                    'UNIT' => $this->getunit($limit['ID_SERVICES']),
                    'TYPE' => $this->gettype($limit['MONTHLY_LIMIT']),
                    'CODE' => $_i_limit['CODE'].','.$limit['ID_SERVICES'],
                    'FUEL' => $_i_limit['FUEL'].','.$this->getser($limit['ID_SERVICES'])
                ]);
            }
            else
            {
                array_push($_new_limits, [
                        'AMOUNT' =>$limit['LIMIT_PURSE'],
                        'UNIT' => $this->getunit($limit['ID_SERVICES']),
                        'TYPE' => $this->gettype($limit['MONTHLY_LIMIT']),
                        'CODE' => $limit['ID_SERVICES'],
                        'FUEL' => $this->getser($limit['ID_SERVICES'])
                ]);
            }
        }
        // Удаляем первую запятую БРЕД !!!!!!!
        $_i_limit = array_replace($_i_limit,[
            'CODE' => mb_substr($_i_limit['CODE'],1),
            'FUEL' => mb_substr($_i_limit['FUEL'],1)
            ]);
        // Обьеденяем массивы
        array_push($_new_limits, $_i_limit);
        return $_new_limits;
    }

    public function afterFind()
    {
        $this->DESCRIPTION_CONDITION = iconv('windows-1251', 'UTF-8',$this->DESCRIPTION_CONDITION);
        $this->HOLDER_CARD = iconv('windows-1251', 'UTF-8',$this->HOLDER_CARD);
    }

    public function getLastService($id)
    {
        // return $this->find()->select('max(DATA)')->where(['GR_NOMER' => $id])->asArray()->all();
        $r = Yii::$app->db->createCommand('SELECT TO_CHAR(max(DATA),\'dd.mm.yyyy\' ) as DATE_LAST_SERVICE  FROM ECFIL139 WHERE GR_NOMER ='.$id)->queryOne();
        return $r['DATE_LAST_SERVICE'];
    }

    public function getunit($id)
    {
        switch ($id) {
            case 1:
                return 'currency';
                break;
            case 8:
                return 'currency';
                break;
            default:
                return 'liters';
                break;
        }
    }

    public function gettype($id)
    {
        switch ($id) {
            case 0:
                return 'daily';
                break;
            case 1:
                return 'monthly';
                break;
        }
    }

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
