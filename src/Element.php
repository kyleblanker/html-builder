<?php
namespace KyleBlanker\HtmlBuilder;

use Closure;
use KyleBlanker\HtmlBuilder\Exceptions\VoidContent;

class Element
{
    private $tag;
    private $void;
    private $content;
    private $builder;
    private $elements = [];
    private $attributes = [];

    /**
     * @param Builder $builder The html builder instance
     * @param string $tag Element tag
     * @param string $content Element's text content
     */
    public function __construct(Builder $builder, $tag,$content = false)
    {
        $this->builder = $builder;
        $this->tag = strtolower($tag);

        $void_tags = [
            'area',
            'base',
            'br',
            'col',
            'command',
            'embed',
            'hr',
            'img',
            'input',
            'keygen',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr'
        ];

        $this->void = in_array($this->tag,$void_tags);

        if(!$this->void && !is_null($content))
        {
            $this->content($content);
        }
    }

    /**
     * Sets the element's content
     * @param string $content Element's text content
     * @return Element
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Adds attribute to the element
     * @param string $key
     * @param string $value
     * @return Element
     */
    public function attribute($key,$value = null)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Adds an array of attributes to the element
     * @param array $attributes
     * @return Element
     */
    public function attributes(array $attributes)
    {
        foreach($attributes as $key => $value)
        {
            $this->attribute($key,$value);
        }

        return $this;
    }

    /**
     * Allows nesting of other elements inside of the current one
     * @param Closure $closure
     * @return Element
     */
    public function nest(Closure $closure)
    {
        if($this->void)
        {
            throw new VoidContent($this->tag);
        }

        $parent_nest = $this->builder->getNestElement();

        $this->builder->setNestElement($this);

        $result = $closure($this->builder);

        $this->builder->setNestElement($parent_nest);

        return $this;
    }

    /**
     * Adds an element that will be nested to the array
     * @param Element $element
     * @return Element
     */
    public function element(Element $element)
    {
        if($this->void)
        {
            throw new VoidContent($this->tag);
        }

        array_push($this->elements,$element);

        return $this;
    }

    /**
     * Renders the object into a valid html string
     * @return string
     */
    public function render()
    {
        $html = '<' . $this->tag;


        foreach($this->attributes as $key => $value)
        {
            $value = $value ?? $key;
            $html .= ' ' . $key . '="' . $value . '"';
        }

        if($this->void)
        {
            $html .= ' />';
            return $html;
        }

        $html .= '>';

        foreach($this->elements as $element)
        {
            $html .= $element->render();
        }

        if(!empty($this->content))
        {
            $html .= $this->content;
        }

        $html .= '</' . $this->tag . '>';

        return $html;
    }
}
