<?php

namespace KyleBlanker\HtmlBuilder\Exceptions;

class VoidContent extends \Exception
{
    public function __construct($element)
    {
        $string = 'Element: "%s" is a void element, it can not have content';
        $message = sprintf($string,$element);
        parent::__construct($message);
    }
}
