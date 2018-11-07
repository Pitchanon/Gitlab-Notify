# Gitlab-Notify

## Installation

- [Packagist](https://packagist.org/packages/pitchanon/gitlab-notify)

Require it in your `composer.json` file.

```json
"require": {
    "pitchanon/line": "dev-master",
    "pitchanon/gitlab-notify": "dev-master"
  }
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated

Composer command

```sh
$ composer require pitchanon/line
$ composer require pitchanon/gitlab-notify
```

## How to use

```php
$entityBody = "{"event_name":"push"}";

$line = new Pitchanon\GitlabNotify\GitlabNotify();
$line::Config(["token" => "xxxxx"]);
$res = $line::Notify($entityBody);
```
