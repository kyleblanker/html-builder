# HTMLBuilder
Lightweight html builder

[![Build Status](https://travis-ci.org/kyleblanker/html-builder.svg)](https://travis-ci.org/kyleblanker/html-builder) [![Total Downloads](https://poser.pugx.org/kyleblanker/html-builder/downloads)](https://packagist.org/packages/kyleblanker/html-builder) [![License](https://poser.pugx.org/kyleblanker/html-builder/license)](https://packagist.org/packages/kyleblanker/html-builder)

## Examples

### Creating a basic element
```PHP
$builder = new \KyleBlanker\HtmlBuilder\Builder();
$element = $builder->element('p','Hello world');

echo $element->render();
```

### Creating a basic element with an attribute
```PHP
$builder = new \KyleBlanker\HtmlBuilder\Builder();

$element = $builder->element('p','Hello World')->attribute('style','color: #ff0000');
```

### Nesting elements
```PHP
$builder = new \KyleBlanker\HtmlBuilder\Builder();

$element = $builder->element('div')->nest(function($builder){
    $builder->element('p','This element is nested');
});
```

### Adding child elements
```PHP
$builder = new \KyleBlanker\HtmlBuilder\Builder();

$parent = $builder->element('div');

$childElement = $builder->element('p');

$parent->child($childElement);
```

### Creating an html document
```PHP
$builder = new \KyleBlanker\HtmlBuilder\Builder();
$document = $builder->createDocument();

$document->getHead()->nest(function($builder){
    $builder->element('title','Page Title');
});

$document->getBody()->nest(function($builder){
    $builder->element('div')->attribute('style','background: #ff0000');
});

echo $document->build();
```
