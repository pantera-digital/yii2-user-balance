# yii2-user-balance

==========

User balance module for Yii2 apps

Install
---------------------------------

Run

```
php composer require pantera-digital/yii2-user-balance "*"
```

Or add to composer.json

```
"pantera-digital/yii2-user-balance": "*",
```

and execute:

```
php composer update
```

Migrations:

```
php yii migrate --migrationPath=vendor/pantera/user/balance/migrations
```

Usage
---------------------------------
//Add below lines to components array
'userBalance' => [
            'class' => \pantera\user\balance\Component::class,
            'userModel' => 'pantera\YiiYii2User\models\User',
        ],
//And add this to modules array
'user-balance' => [
            'class' => \pantera\user\balance\Module::class,
        ]
    
...
