# Pirate Translator
The Pirate Translator Package adds fast and dynimic translation funtionalites to your Laravel Application.

## Installation

### 1. Require the Package

```
composer require tpc/pirates-translator
```

### 2. Add the DB Credentials
create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### 3. Run The Installer

```
php artisan piratetranslator:install
```

Now the installation done.

## Usage

### Adding new locale

```
$locale = 'ckb';
PirateTranslator::addLanguage($locale)
```

### Adding new Translation

```
$newTranslation = [
  'locale' => 'ckb',
  'table_name' => 'user',
  'column_name' => 'name',
  'phrase_key' => 'raman',
  'value' => 'Raman Koye'
];

PirateTranslator::addTranslation($newTranslation);
```

### Update Translation
```
$updateTranslation = [
  'id' => 'ckb', // id is required*.
  'value' => 'Raman Zana' //include other fields/columns that you want to update.
];

PirateTranslator::updateTranslation($updateTranslation);
```

### Bluk Insert

```
$blukTranslation = [
  [
    'locale' => 'ckb',
    'table_name' => 'user',
    'column_name' => 'name',
    'phrase_key' => 'raman',
    'value' => 'Raman Koye'
  ],
  [
    'locale' => 'ckb',
    'table_name' => 'user',
    'column_name' => 'name',
    'phrase_key' => 'aram',
    'value' => 'Aram Taher'
  ]
];

PirateTranslator::blukInsert($blukTranslation);
```

### Access
using laravel localization helper function.
Key Format `table_name.phrase_key.column_name'
```
\\ table_name = user
\\ phrase_key = raman
\\ column_name = name
\\ value = Raman Zana

__('pirates.user.ahmed.name'); //output: "Raman Zana"
```

### Refreshing Cache 
- All locales.
```
piratetranslator:cache
```
- single locale.
```
piratetranslator:cache {locale}
```
