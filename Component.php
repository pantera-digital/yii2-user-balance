<?php

namespace pantera\user\balance;

use pantera\user\balance\models\UsersBalance;
use yii\base\Component as BaseComponent;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;


class Component extends BaseComponent
{
    /**
     * @var $userModel string
     * your project user model
     */
    public $userModel;

    public function init() {
        if(!$this->userModel) throw new InvalidConfigException('Please set the user model in config');
    }

    public function getBalance(ActiveRecord $user)
    {
        return UsersBalance::find()
            ->select('balance')
            ->andWhere(['=', 'user_id', $user->getPrimaryKey()])
            ->scalar();
    }
}
