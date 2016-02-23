Типограф для Symfony 2
===============

[![Build Status](https://travis-ci.org/sergeyfedotov/symfony-typography-bundle.svg?branch=master)](https://travis-ci.org/sergeyfedotov/symfony-typography-bundle)

Для обработки текста используется [типограф Муравьёва](https://github.com/emuravjev/mdash).

Установка
---------------
```$ composer require fsv/typography-bundle```

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

Использование
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

```php
# AppBundle\Form\Type\CustomFormType.php

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder->add('content', TextareaType::class, [
        'typography' => 'default'
    ]);
    # ...
}
```
