# labnet
LabNet 2017
The version was upgraded Yii Framework from version 2.0.12.2 to 2.0.15.1.

  Please check the upgrade notes for possible incompatible changes
  and adjust your application code accordingly.

  Upgrade from Yii 2.0.14
  -----------------------
  
  * When hash format condition (array) is used in `yii\db\ActiveRecord::findOne()` and `findAll()`, the array keys (column names)
    are now limited to the table column names. This is to prevent SQL injection if input was not filtered properly.
    You should check all usages of `findOne()` and `findAll()` to ensure that input is filtered correctly.
    If you need to find models using different keys than the table columns, use `find()->where(...)` instead.
  
    It's not an issue in the default generated code though as ID is filtered by
    controller code:
  
    The following code examples are **not** affected by this issue (examples shown for `findOne()` are valid also for `findAll()`):
  
    ```php
    // yii\web\Controller ensures that $id is scalar
    public function actionView($id)
    {
        $model = Post::findOne($id);
        // ...
    }
    ```
  
    ```php
    // casting to (int) or (string) ensures no array can be injected (an exception will be thrown so this is not a good practise)
    $model = Post::findOne((int) Yii::$app->request->get('id'));
    ```
  
    ```php
    // explicitly specifying the colum to search, passing a scalar or array here will always result in finding a single record
    $model = Post::findOne(['id' => Yii::$app->request->get('id')]);
    ```
  
    The following code however **is vulnerable**, an attacker could inject an array with an arbitrary condition and even exploit SQL injection:
  
    ```php
    $model = Post::findOne(Yii::$app->request->get('id'));
    ```
  
    For the above example, the SQL injection part is fixed with the patches provided in this release, but an attacker may still be able to search
    records by different condition than a primary key search and violate your application business logic. So passing user input directly like this can cause problems and should be avoided.
  
  
  Upgrade from Yii 2.0.13
  -----------------------
  
  * Constants `IPV6_ADDRESS_LENGTH`, `IPV4_ADDRESS_LENGTH` were moved from `yii\validators\IpValidator` to `yii\helpers\IpHelper`.
    If your application relies on these constants, make sure to update your code to follow the changes.
  
  * `yii\base\Security::compareString()` is now throwing `yii\base\InvalidArgumentException` in case non-strings are compared.
  
  * `yii\db\ExpressionInterface` has been introduced to represent a wider range of SQL expressions. In case you check for
    `instanceof yii\db\Expression` in your code, you might consider changing that to checking for the interface and use the newly
    introduced methods to retrieve the expression content.
  
  * Added JSON support for PostgreSQL and MySQL as well as Arrays support for PostgreSQL in ActiveRecord layer.
    In case you already implemented such support yourself, please switch to Yii implementation.
    * For MySQL JSON and PgSQL JSON & JSONB columns Active Record will return decoded JSON (that can be either array or scalar) after data population
    and expects arrays or scalars to be assigned for further saving them into a database.
    * For PgSQL Array columns Active Record will return `yii\db\ArrayExpression` object that acts as an array
    (it implements `ArrayAccess`, `Traversable` and `Countable` interfaces) and expects array or `yii\db\ArrayExpression` to be
    assigned for further saving it into the database.
  
    In case this change makes the upgrade process to Yii 2.0.14 too hard in your project, you can [switch off the described behavior](https://github.com/yiisoft/yii2/issues/15716#issuecomment-368143206)
    Then you can take your time to change your code and then re-enable arrays or JSON support.
  
  * `yii\db\PdoValue` class has been introduced to replace a special syntax that was used to declare PDO parameter type 
    when binding parameters to an SQL command, for example: `['value', \PDO::PARAM_STR]`.
    You should use `new PdoValue('value', \PDO::PARAM_STR)` instead. Old syntax will be removed in Yii 2.1.
  
  * `yii\db\QueryBuilder::conditionBuilders` property and method-based condition builders are no longer used. 
    Class-based conditions and builders are introduced instead to provide more flexibility, extensibility and
    space to customization. In case you rely on that property or override any of default condition builders, follow the 
    special [guide article](http://www.yiiframework.com/doc-2.0/guide-db-query-builder.html#adding-custom-conditions-and-expressions)
    to update your code.
  
  * Protected method `yii\db\ActiveQueryTrait::createModels()` does not apply indexes as defined in `indexBy` property anymore.  
    In case you override default ActiveQuery implementation and relied on that behavior, call `yii\db\Query::populate()`
    method instead to index query results according to the `indexBy` parameter.
  
  * Log targets (like `yii\log\EmailTarget`) are now throwing `yii\log\LogRuntimeException` in case log can not be properly exported.
  
  * You can start preparing your application for Yii 2.1 by doing the following:
  
    - Replace `::className()` calls with `::class` (if you’re running PHP 5.5+).
    - Replace usages of `yii\base\InvalidParamException` with `yii\base\InvalidArgumentException`.
    - Replace calls to `Yii::trace()` with `Yii::debug()`.
    - Remove calls to `yii\BaseYii::powered()`.
    - If you are using XCache or Zend data cache, those are going away in 2.1 so you might want to start looking for an alternative.
  
  Upgrade from Yii 2.0.12
  -----------------------
  
  * The `yii\web\Request` class allowed to determine the value of `getIsSecureConnection()` form the
    `X-Forwarded-Proto` header if the connection was made via a normal HTTP request. This behavior
    was insecure as the header could have been set by a malicious client on a non-HTTPS connection.
    With 2.0.13 Yii adds support for configuring trusted proxies. If your application runs behind a reverse proxy and relies on
    `getIsSecureConnection()` to return the value form the `X-Forwarded-Proto` header you need to explicitly allow
    this in the Request configuration. See the [guide](http://www.yiiframework.com/doc-2.0/guide-runtime-requests.html#trusted-proxies) for more information.
  
    This setting also affects you when Yii is running on IIS webserver, which sets the `X-Rewrite-Url` header.
    This header is now filtered by default and must be listed in trusted hosts to be detected by Yii:
  
    ```php
    [   // accept X-Rewrite-Url from all hosts, as it will be set by IIS
        '/.*/' => ['X-Rewrite-Url'],
    ]
    ```
  
  * For compatibiliy with [PHP 7.2 which does not allow classes to be named `Object` anymore](https://wiki.php.net/rfc/object-typehint),
    we needed to rename `yii\base\Object` to `yii\base\BaseObject`.
    
    `yii\base\Object` still exists for backwards compatibility and will be loaded if needed in projects that are
    running on PHP <7.2. The compatibility class `yii\base\Object` extends from `yii\base\BaseObject` so if you
    have classes that extend from `yii\base\Object` these would still work.
    
    What does not work however will be code that relies on `instanceof` checks or `is_subclass_of()` calls
    for `yii\base\Object` on framework classes as these do not extend `yii\base\Object` anymore but only
    extend from `yii\base\BaseObject`. In general such a check is not needed as there is a `yii\base\Configurable`
    interface you should check against instead.
    
    Here is a visualisation of the change (`a < b` means "b extends a"):
    
    ```
    Before:
    
    yii\base\Object < Framework Classes
    yii\base\Object < Application Classes
    
    After Upgrade:
    
    yii\base\BaseObject < Framework Classes
    yii\base\BaseObject < yii\base\Object < Application Classes
  
    ```
    
    If you want to upgrade PHP to version 7.2 in your project you need to remove all cases that extend `yii\base\Object`
    and extend from `yii\base\BaseObject` instead:
    
    ```
    yii\base\BaseObject < Framework Classes
    yii\base\BaseObject < Application Classes
    ```
    
    For extensions that have classes extending from `yii\base\Object`, to be compatible with PHP 7.2, you need to
    require `"yiisoft/yii2": "~2.0.13"` in composer.json and change affected classes to extend from `yii\base\BaseObject`
    instead. It is not possible to allow Yii versions `<2.0.13` and be compatible with PHP 7.2 or higher.
  
  * A new method `public static function instance($refresh = false);` has been added to the `yii\db\ActiveRecordInterface` via a new
    `yii\base\StaticInstanceInterface`. This change may affect your application in the following ways:
  
    - If you have an `instance()` method defined in an `ActiveRecord` or `Model` class, you need to check whether the behavior is
      compatible with the method added by Yii.
    - Otherwise this method is implemented in the `yii\base\Model`, so the change only affects your code if you implement `ActiveRecordInterface`
      in a class that does not extend `Model`. You may use `yii\base\StaticInstanceTrait` to implement it.
      
  * Fixed built-in validator creating when model has a method with the same name. 
  
    It is documented, that for the validation rules declared in model by `yii\base\Model::rules()`, validator can be either 
    a built-in validator name, a method name of the model class, an anonymous function, or a validator class name. 
    Before this change behavior was inconsistent with the documentation: method in the model had higher priority, than
    a built-in validator. In case you have relied on this behavior, make sure to fix it.
  
  * Behavior was changed for methods `yii\base\Module::get()` and `yii\base\Module::has()` so in case when the requested
    component was not found in the current module, the parent ones will be checked for this component hierarchically.
    Considering that the root parent module is usually an application, this change can reduce calls to global `Yii::$app->get()`,
    and replace them with module-scope calls to `get()`, making code more reliable and easier to test.
    However, this change may affect your application if you have code that uses method `yii\base\Module::has()` in order
    to check existence of the component exactly in this specific module. In this case make sure the logic is not corrupted.
  
  * If you are using "asset" command to compress assets and your web applicaiton `assetManager` has `linkAssets` turned on,
    make sure that "asset" command config has `linkAssets` turned on as well.

  You can find the upgrade notes for all versions online at:
  https://github.com/yiisoft/yii2/blob/2.0.15.1/framework/UPGRADE.md