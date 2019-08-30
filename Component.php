<?php

namespace pantera\user\balance;

use pantera\user\balance\models\UsersBalanceHistory;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class Component extends \yii\base\Component
{
    /**
     * @var $userModel string
     * your project user model
     */
    public $userModel;

    public function init() {
        if (!$this->userModel) {
            throw new InvalidConfigException('Please set the user model in config');
        }
    }

    public function getBalance(ActiveRecord $user, $status = UsersBalanceHistory::STATUS_CONFIRMED, $operationType = null)
    {
        $condition = 'user_id = :user_id AND status = :status';
        switch ($operationType) {
            case UsersBalanceHistory::OPERATION_TYPE_INCREASE:
                $condition .= ' AND sum > 0';
            break;
            case UsersBalanceHistory::OPERATION_TYPE_DECREASE:
                $condition .= ' AND sum < 0';
            break;
        }

        $params = [
            ':user_id' => $user->getPrimaryKey(),
            ':status' => $status,
        ];

        return (new \yii\db\Query())->from(UsersBalanceHistory::tableName())
                    ->where($condition, $params)
                    ->sum('sum');
    }
}
