<?php

class BuilderTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDocument()
    {
        $builder = new \KyleBlanker\HtmlBuilder\Builder();

        $document = $builder->createDocument()->build();
        $this->assertEquals('<!DOCTYPE html>'.PHP_EOL.'<html><head></head><body></body></html>',$document);
    }

    public function testCreateElement()
    {
        $builder = new \KyleBlanker\HtmlBuilder\Builder();
        $div = $builder->element('div')->render();
        $this->assertEquals('<div></div>',$div);
    }

    public function testCreateElementAttribute()
    {
        $builder = new \KyleBlanker\HtmlBuilder\Builder();

        $div = $builder->element('div')
            ->attribute('style','color: #ff0000')
            ->render();

        $this->assertEquals('<div style="color: #ff0000"></div>',$div);
    }

    public function testCreateElementNest()
    {
        $builder = new \KyleBlanker\HtmlBuilder\Builder();

        $div = $builder->element('div')
            ->nest(function($builder){
                $builder->element('p');
            })->render();

        $this->assertEquals('<div><p></p></div>',$div);
    }

    public function testCreateElementMultipleNest()
    {
        $builder = new \KyleBlanker\HtmlBuilder\Builder();

        $div = $builder->element('div')
            ->nest(function($builder){
                $builder->element('p')->nest(function($builder){
                    $builder->element('a');
                });
            })->render();

        $this->assertEquals('<div><p><a></a></p></div>',$div);
    }
}
