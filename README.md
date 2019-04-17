# Fixtures (for Craft 3)

This plugin provides all the necessary means to run Craft Elements as [Yii2 fixtures](https://www.yiiframework.com/doc/guide/2.0/en/test-fixtures). If you're not familiar with [Yii2 fixtures](https://www.yiiframework.com/doc/guide/2.0/en/test-fixtures) it is advised to read [their manual first](https://www.yiiframework.com/doc/guide/2.0/en/test-fixtures).

## Installation

This tool can be installed [using Composer](https://getcomposer.org/doc/00-intro.md). Run the following command from the root of your project:

```
composer require robuust/craft-fixtures
```

This will add `robuust/craft-fixtures` as a requirement to your  project's `composer.json` file and install the source-code into the `vendor/robuust/craft-fixtures` directory.

Fixtures is now available as an installable plugin in Craft. You can install it in the cp or use `./craft install/plugin fixtures`

## Usage

This plugin provides abstract fixtures that you will have to extend and implement.

### Creating fixtures

Create a folder called "fixtures" in your project root.
In this folder we will put our fixture classes, fixture data and the (optional) fixture migrations.

In the [Yii2 docs](https://www.yiiframework.com/doc/guide/2.0/en/test-fixtures#defining-a-fixture) you can read about fixture classes and fixture data.

This plugin provides a base for fixtures for Craft elements. The main logic is defined in `robuust\fixtures\base\ElementFixture`. Our fixture classes can contain the following methods (next to all the features [`yii\test\ActiveFixture`](https://www.yiiframework.com/doc/api/2.0/yii-test-activefixture) has to offer:

`ElementFixture::isPrimaryKey(string $key): bool` to define which model attributes can be used to identify a unique Element

`ElementFixture::getElement(array $data): Element?` to get an element which is identified by the given data. The defined primary keys are used to identify the given data.


#### All fixtures
ElementFixture will define `$this->siteIds` with all site handles as keys.

#### Asset

Extend `robuust\fixtures\base\AssetFixture` to add assets. Its datafile could look like this:

```php
<?php

// We need a copy because Asset will move the temp file
copy(__DIR__.'/assets/product.jpg', 'product.jpg');

return [
    [
        'tempFilePath' => 'product.jpg',
        'filename' => 'product.jpg',
        'volumeId' => $this->volumeIds['products'],
        'folderId' => $this->folderIds['clothes'],
    ],
];
```

This will upload and link product.jpg as an asset.

AssetFixture will define `$this->volumeIds` and `$this->folderIds` with their handles as key.

Its primary keys are: `volumeId`, `folderId`, `filename` and `title`.

#### Category

Extend `robuust\fixtures\base\CategoryFixture` to add categories. Its datafile could look like this:

```php
<?php

return [
    [
        'groupId' => $this->groupIds['categories'],
        'title' => 'Category',
    ],
];
```

CategoryFixture will define `$this->groupIds` with all category group handles as key.

Its primary keys are: `siteId`, `groupId` and `title`.

#### Entry

Extend `robuust\fixtures\base\EntryFixture` to add entries. Its datafile could look like this:

```php
<?php

return [
    [
        'sectionId' => $this->sectionIds['home'],
        'typeId' => $this->typeIds['home']['home'],
        'title' => 'Home',
    ],
];
```

EntryFixture will define `$this->sectionIds` with all section handles as key. It will also define `$this->typeIds` with all section handles as the first key and the entry type handles as the second key.

Its primary keys are: `siteId`, `sectionId`, `typeId` and `title`.

#### GlobalSet

Extend `robuust\fixtures\base\GlobalSetFixture` to update (!) globals (they must already exist). Its datafile could look like this:

```php
<?php

return [
    [
        'handle' => 'contact'
        'contactAddress' => 'foo',
        'contactCity' => 'bar',
    ],
];
```

Its primary keys are: `siteId` and `handle`, the handle being the one of the (already existing) global set.

#### Tag

Extend `robuust\fixtures\base\TagFixture` to add tags. Its datafile could look like this:

```php
<?php

return [
    [
        'groupId' => $this->groupIds['tags'],
        'title' => 'Tag',
    ],
];
```

TagFixture will define `$this->groupIds` with all tag group handles as key.

Its primary keys are: `siteId`, `groupId` and `title`.

#### User

Extend `robuust\fixtures\base\UserFixture` to add users. Its datafile could look like this:

```php
<?php

return [
    [
        'username' => 'User',
        'email' => 'info@example.com',
    ],
];
```

Its primary keys are: `siteId`, `username` and `email`.

#### Product

Extend `robuust\fixtures\base\Product` to add products. Its datafile could look like this:

```php
<?php

return [
    [
        'typeId' => $this->productTypeIds['clothes'],
        'title' => 'Product',
    ],
];
```

ProductFixture will define `$this->productTypeIds` with all product type handles as key.

Its primary keys are: `siteId`, `typeId` and `title`.

### Running fixtures

Once you install the Plugin in Craft, you can run some command line actions. When you run `./craft` in the command line, you will now see these actions:

```
- fixtures/fixture                    Manages fixture data loading and unloading.
    fixtures/fixture/load (default)   Loads the specified fixture data.
    fixtures/fixture/unload           Unloads the specified fixtures.
```

The `fixtures/fixture` actions are extended from Yii2 and will take the same arguments. Run all your fixtures with `./craft fixtures/fixture/load "*"`

### Running fixture migrations

Next to the `fixtures/fixture` actions in the command line, you will also find:

```
- fixtures/migrate                    Migrate controller for fixtures.
    fixtures/migrate/create           Creates a new migration.
    fixtures/migrate/down             Downgrades the application by reverting old migrations.
    fixtures/migrate/fresh            Truncates the whole database and starts the migration from the
                                      beginning.
    fixtures/migrate/history          Displays the migration history.
    fixtures/migrate/mark             Modifies the migration history to the specified version.
    fixtures/migrate/new              Displays the un-applied new migrations.
    fixtures/migrate/redo             Redoes the last few migrations.
    fixtures/migrate/to               Upgrades or downgrades till the specified version.
    fixtures/migrate/up (default)     Upgrades the application by applying new migrations.
```

The `fixtures/migrate` actions are extended from Craft and will take the same arguments. Run all your migrations with `./craft fixtures/migrate/up`

### Using fixtures in tests

To use these fixtures in [Codeception](https://codeception.com/) tests with Craft 3 you can use the `robuust\fixtures\test\Craft` module in stead of using [Codeception's Yii2 module](https://codeception.com/docs/modules/Yii2). 

```yaml
modules:
    enabled:
        - \robuust\fixtures\test\Craft:
            part: [init, fixtures]
            configFile: 'config/app.test.php' # based on vendor/craftcms/cms/tests/_craft/config/test.php
            entryUrl: 'http://localhost/index.php'
            cleanup: true
```

You can load fixtures in tests the way the [Yii2 docs describe it](https://www.yiiframework.com/doc/guide/2.0/en/test-fixtures#using-fixtures).

## Example

This is an example of a fixture for a fictional "Contact Page"

`fixtures/ContactPageEntryFixture.php`

```php
<?php

namespace fixtures;

use fixtures\base\EntryFixture;

/**
 * Contact page Fixture for Entry model.
 */
class ContactPageEntryFixture extends EntryFixture
{
    /**
     * {@inheritdoc}
     */
    public $dataFile = __DIR__.'/data/contact-page-entry.php';

    /**
     * {@inheritdoc}
     */
    public $depends = [
        'fixtures\SomeAssetFixture',
    ];
}
```

`fixtures/data/contact-page-entry.php`

```php
<?php

use craft\elements\Asset;

$articleThumbIds = Asset::find()->filename('article-thumb.jpg')->ids();

return [
    [
        'sectionId' => $this->sectionIds['contact'],
        'typeId' => $this->typeIds['contact']['contact'],
        'title' => 'Contact',
        'contactMapTitle' => 'Floorplan',
        'contactMapText' => '
            <p>
              Maecenas faucibus mollis interdum. Fusce dapibus, tellus ac cursus commodo, tortor
              mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio
              dui. Aenean lacinia bibendum nulla sed consectetur. Curabitur blandit tempus porttitor.
            </p>',
        'contactMapImage' => $articleThumbIds,
        'contactMapPDF' => Asset::find()->filename('test.pdf')->ids(),
    ],
];
```

## License

This project has been licensed under the MIT License (MIT). Please see [License File](LICENSE) for more information.

## Changelog

[CHANGELOG.md](CHANGELOG.md)
