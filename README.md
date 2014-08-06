yii2-xunsearch
==============

composer.json
----------------
```json
"require": {
    xj/yii2-xunsearch: "*"
},
```

Configure Components
---------------
```php
return [
    'components' => [
        'xunsearch' => [
            'class' => 'xj\\xunsearch\\Connection',
            //Put Xunsearch ini to $configDirectory
            'configDirectory' => '@common/config/xunsearch',
        ],
    ],
];
```

Create ActiveRecord
---------------
```php
class Demo extends \xj\xunsearch\ActiveRecord {

    public static function primaryKey() {
        return ['pid'];
    }

    public function rules() {
        return [
            [['pid', 'subject', 'message'], 'required']
        ];
    }

    public function attributes() {
        return [
            'pid', 'subject', 'message',
        ];
    }

}
```

INSERT
--------------
```php
$model = new Demo();
$model->setAttributes([
    'pid' => 1,
    'subject' => 'haha',
    'message' => 'hehe',
]);
$model->save();
```

QUERY
---------------
```php
//where syntax
$models = Demo::find()->where([
            'wild', 'key1', '-key2', // key1 -key2
            'wild', 'key1', 'key2', 'key3', // key1 key2 key3
            'pid' => [5, 6, 7], // (pid:5) OR (pid:6) OR (pid:7)
            'pid' => 5, // pid:5
            'and', 'key1', 'key2', 'key3', // (key1) AND (key2) AND (key3)
            'or', '5', '6', '7', // (5) OR (6) OR (7)
            'and', '啊', ['or', 'pid:30', 'pid:31'] // (啊) AND ((pid:30) OR (pid:31))
        ])->all();
var_dump($models);

//asArray
$models = Demo::find()->where([
            'wild', 'key1', '-key2', // key1 -key2
        ])->asArray()->all();
```

UPDATE
---------------
```php
$model = Demo::findByPk(1);
$model->subject = 'mod subject';
$model->save();
```

DELETE
---------------
```php
$model = Demo::findByPk(1);
$model->delete();
```

COUNT
---------------
```php
$count = Demo::find()->where([
            'wild', 'key1',
        ])->count();
```

Work with ActiveDataProvider
----------------
```php
$query = Demo::find();
$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => $query,
]);
$models = $dataProvider->getModels();
var_dump($models);
```
