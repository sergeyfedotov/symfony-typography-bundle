Symfony Typography Bundle
===============

[![Build Status](https://travis-ci.org/sergeyfedotov/symfony-typography-bundle.svg?branch=master)](https://travis-ci.org/sergeyfedotov/symfony-typography-bundle)

Installation
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

For lazy typographers initialization:
```
$ composer require ocramius/proxy-manager:^1.0
```

Configuration
---------------
```yaml
# app/config/config.yml

fsv_typography:
    typographers:
        default:
            mdash:
                options:
                    Text.paragraphs: off
        another:
            smartypants:
                attr: 1
        service:
            id: my_service_id
# ...
```

Disable form extension:
```yaml
fsv_typography:
    enable_form_extension: false
```

Usage
---------------
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

```php
// AppBundle/Controller/ExampleController.php

public function exampleAction()
{
    // ...
    $content = $this->get('fsv_typography.typographer_map')->getTypographer('default')->typography($rawContent);
    $content = $this->get('fsv_typography.typographer_map.default')->typography($rawContent);
    // ...
}
```
