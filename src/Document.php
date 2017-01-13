<?php
namespace KyleBlanker\HtmlBuilder;

use Gajus\Dindent\Indenter;

class Document
{
    private $html;
    private $head;
    private $body;
    private $doctype = '<!DOCTYPE html>';
    private $metatags = [];

    /**
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->html = $builder->element('html');
        $this->head = $builder->element('head');
        $this->body = $builder->element('body');
    }

    /**
     * @param string $doctype
     * Sets the document type of the html content
     */
    public function setDoctype($doctype)
    {
        $this->doctype = $doctype;
    }

    /**
     * Returns the html element object
     * @return Element
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Returns the head element object
     * @return Element
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Returns the body element object
     * @return Element
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Builds the html document
     * @return string
     */
    public function build()
    {
        $this->html->element($this->head);
        $this->html->element($this->body);

        return $this->doctype . PHP_EOL . $this->html->render();
    }
}
