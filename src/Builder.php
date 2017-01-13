<?php
namespace KyleBlanker\HtmlBuilder;

class Builder
{
    private $nestElement;

    /**
     * Returns a new Builder Document
     *
     * @return Document
     */
    public function createDocument()
    {
        return new Document($this);
    }

    /**
     * Creates a new element, if nestElement is set then it will add the
     * element to that nest element's array
     *
     * @return Element
     */
    public function element($tag,$content = false)
    {
        $element = new Element($this,$tag,$content);

        if($this->nestElement instanceof Element)
        {
            $this->nestElement->element($element);
        }

        return $element;
    }

    /**
     * Sets the nestElement
     *
     */
    public function setNestElement($element)
    {
        $this->nestElement = $element;
    }

    /**
     * Returns the nestElement
     * @return Element
     */
    public function getNestElement()
    {
        return $this->nestElement;
    }

    /**
     * Creates a br element
     * @return Element
     */
    public function br()
    {
        return $this->element('br');
    }

    /**
     * Creates an hr element
     * @return Element
     */
    public function hr()
    {
        return $this->element('hr');
    }

    /**
     * Creates a css link element
     * @param string $url url of the css file
     * @param string $media media attribute value
     * @return Element
     */
    public function css($url,$media = "all")
    {
        $element = $this->element('link')->attributes([
            'rel' => 'stylesheet',
            'href' => $url
        ]);

        if($media != "all")
        {
            $element->attribute('media',$media);
        }

        return $element;
    }

    /**
     * Creates an image element
     * @param string $src source of the image
     * @param string $alt alt attribute value
     * @return Element
     */
    public function image($src,$alt = null)
    {
        $element = $this->element('img')->attribute('src',$src);

        if(!is_null($alt))
        {
            $element->attribute('alt',$alt);
        }

        return $element;
    }

    /**
     * Creates a link element
     * @param string $link href value
     * @param string $title link title
     * @return Element
     */
    public function link($link,$title = null)
    {
        $title = $title ?? $link;
        return $this->element('a',$title)->attribute('href',$link);
    }

    /**
     * Creates a mailto link for an email address
     * @param string $email href value
     * @return Element
     */
    public function mailto($email)
    {
        return $this->element('a',$email)->attribute('href','mailto:' . $email);
    }
}
