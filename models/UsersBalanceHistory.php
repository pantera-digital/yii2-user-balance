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
    const STATUS_INITIAL = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_DECLINED = -1;

    const OPERATION_TYPE_INCREASE = 'operation_increase';
    const OPERATION_TYPE_DECREASE = 'operation_decrease';

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
        $balance->balance = (new \yii\db\Query())->from(self::tableName())->where(['user_id' => $this->user_id, 'status' => self::STATUS_CONFIRMED])->sum('sum');
        $balance->save();
    }

    public function getStatusName()
    {
        $statusNames = [
            self::STATUS_INITIAL => 'В обработке',
            self::STATUS_CONFIRMED => 'Оплачен',
            self::STATUS_DECLINED => 'Отклонен',
        ];
        return $statusNames[$this->status];
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
