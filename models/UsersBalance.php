<?php

namespace pantera\user\balance\models;

/**
 * This is the model class for table "users_balance".
 *
 * @property int $user_id
 * @property string $balance
 */
class UsersBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_balance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['balance'], 'number'],
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
