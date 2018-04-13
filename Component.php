<?php

namespace pantera\user\balance;

use yii\base\Component as BaseComponent;
use yii\base\InvalidConfigException;


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
}
