# yii2-user-balance

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
php yii migrate --migrationPath=vendor/pantera-digital/yii2-user-balance/migrations
```

Usage
---------------------------------

Add below lines to 'components' section:

```
'userBalance' => [
    'class' => \pantera\user\balance\Component::class,
    'userModel' => 'path-to-your-user-module\models\User',
],
```
 
And add this to 'modules' section:

```
'user-balance' => [
    'class' => \pantera\user\balance\Module::class,
    'access' => ['admin'], // by default 'access' => ['@']
]
```
