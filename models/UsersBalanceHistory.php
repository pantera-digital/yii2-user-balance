<?php

namespace pantera\user\balance\models;

use Yii;

/**
 * This is the model class for table "users_balance_history".
 *
 * @property int $id
 * @property int $user_id
 * @property string $sum
 * @property string $method
 * @property string $comment
 * @property string $created_at
 */
class UsersBalanceHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_balance_history}}';
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        $balance = UsersBalance::findOne(['user_id' => $this->user_id]);
        if (!$balance) {
            $balance = new UsersBalance(['user_id' => $this->user_id]);
        }
        $balance->balance = (new \yii\db\Query())->from(self::tableName())->where(['user_id' => $this->user_id])->sum('sum');
        $balance->save();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['sum'], 'number'],
            [['comment'], 'string'],
            [['comment'], 'default', 'value' => 'Баланс изменен администратором'],
            [['method'], 'string', 'max' => 31],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'sum' => 'Сумма',
            'method' => 'Способ',
            'comment' => 'Комментарий',
            'created_at' => 'Дата транзакции',
        ];
    }
}
