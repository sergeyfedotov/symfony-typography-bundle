Типограф для Symfony 2
===============

[![Build Status](https://travis-ci.org/sergeyfedotov/symfony-typography-bundle.svg?branch=master)](https://travis-ci.org/sergeyfedotov/symfony-typography-bundle)

Для обработки текста используется [типограф Муравьёва](https://github.com/emuravjev/mdash).

Установка
---------------
```
$ composer require fsv/typography-bundle
```

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Fsv\TypographyBundle\FsvTypographyBundle(),
    );
}
```

Для отложенной инициализации типографа нужно установить дополнительный пакет:

```
$ composer require ocramius/proxy-manager:^1.0
```

Настройка
---------------
```yaml
# app/config/config.yml

fsv_typography:
    typographs:
        default:
            Nobr.spaces_nobr_in_surname_abbr: off
            Text.paragraphs: off
            Text.auto_links: off
            Text.email: off
            Text.breakline: off
            Text.no_repeat_words: off
            # ...
```

Можно создать любое количество конфигураций:

```yaml
fsv_typography:
    typographs:
        article:
            # ...
        news:
            # ...
```

Можно отключить расширение для формы:

```yaml
fsv_typography:
    enable_form_extension: false
    # ...
```

Использование
---------------
### Типографирование в форме

```php
// AppBundle\Form\Type\ExampleFormType.php

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder->add('content', TextareaType::class, [
        'typography' => 'default'
    ]);
    // ...
}
```

В качестве значения опции `typography` передаётся название конфигурации.

### Типографирование через сервис

Для каждой конфигурации создаётся сервис:
```
fsv_typography.typograph.default
fsv_typography.typograph.news
fsv_typography.typograph.article
...
```

```php
// AppBundle/Controller/ExampleController.php

public function exampleAction()
{
    // ...
    $content = $this->get('fsv_typography.typograph.default')->apply($rawContent);
    // ...
}
```
