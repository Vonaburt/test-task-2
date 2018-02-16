# Описание
Тестовое задание #2

# Директории

- приемочные тесты: `tests/acceptance`
- реализация степов: `tests/_support/Step`
- описание страниц: `tests/_support/Pages`

# Требования для запуска
- php 7.1 и выше
- composer 1.6.3 и выше

# Конфигурация запуска
Настраивается в файле `tests/acceptance.suite.yml`, подробнее: https://codeception.com/docs/modules/WebDriver

# Запуск
Скрипт start_selenium.sh для запуска selenium-server, находится в корне проекта:
```sh
#!/bin/sh
java -jar selenium-server-standalone-3.9.1.jar
```

Скрипт start.sh, для запуска теста:

```sh
#!/bin/sh
composer install
composer dump-autoload --optimize
vendor/codeception/codeception/codecept clean
vendor/codeception/codeception/codecept build
vendor/codeception/codeception/codecept run --steps --html --debug
```

# Отчет
Формируется автоматически, `tests/_output/report.html`

![Alt text](https://monosnap.com/file/VMRiO6tnyPXHUC0JiOw9a6SVtm8wbT.png)
