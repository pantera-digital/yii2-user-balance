<?php

namespace pantera\user\balance\models;

use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "users_balance".
 *
 * @property int $user_id
 * @property string $balance
 */
class UsersBalance extends \yii\db\ActiveRecord
{
    public $income_money;
    public $comment;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_balance';
    }

    public function income($incoming) {
        if(!empty($incoming)) {
            $this->balance = $this->balance + $incoming;
            return $this;
        } else {
            throw new Exception('Trying to use income method with empty argument, please fill the incoming value argument');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balance','income_money'], 'number'],
            [['income_money'],'required'],
            [['comment'], 'safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'comment' => 'Комментарий',
            'balance' => 'Текущий баланс',
            'income_money' => 'Сумма',
        ];
    }
}
