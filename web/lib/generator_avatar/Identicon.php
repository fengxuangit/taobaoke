<?php
$dir = dirname(__FILE__).'/';
        require_once $dir."GeneratorInterface.php";
        require_once $dir."BaseGenerator.php";
        require_once $dir."GdGenerator.php";

/**
 * @author Benjamin Laugueux <benjamin@yzalis.com>
 */
class Identicon
{
    /**
     * @var GeneratorInterface
     */
    private $generator;

    public function __construct($generator = null)
    {
        if (null === $generator) {
            $this->generator = new GdGenerator();
        } else {
            $this->generator = $generator;
        }

    }

    /**
     * Set the image generetor
     *
     * @param GeneratorInterface $generator
     *
     * @throws \Exception
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * Display an Identicon image
     *
     * @param string  $string
     * @param integer $size
     * @param string  $color
     * @param string  $backgroundColor
     */
    public function displayImage($string, $size = 120, $color = null, $backgroundColor = null)
    {
        header("Content-Type: image/png");
        echo $this->getImageData($string, $size, $color, $backgroundColor);
    }

    /**
     * Get an Identicon PNG image data
     *
     * @param string  $string
     * @param integer $size
     * @param string  $color
     * @param string  $backgroundColor
     *
     * @return string
     */
    public function getImageData($string, $size = 120, $color = null, $backgroundColor = null)
    {
        return $this->generator->getImageBinaryData($string, $size, $color, $backgroundColor);
    }

    /**
     * Get an Identicon PNG image resource
     *
     * @param string  $string
     * @param integer $size
     * @param string  $color
     * @param string  $backgroundColor
     *
     * @return string
     */
    public function getImageResource($string, $size = 120, $color = null, $backgroundColor = null)
    {
        return $this->generator->getImageResource($string, $size, $color, $backgroundColor);
    }

    /**
     * Get an Identicon PNG image data as base 64 encoded
     *
     * @param string  $string
     * @param integer $size
     * @param string  $color
     * @param string  $backgroundColor
     *
     * @return string
     */
    public function getImageDataUri($string, $size = 120, $color = null, $backgroundColor = null)
    {
        return sprintf('data:image/png;base64,%s', base64_encode($this->getImageData($string, $size, $color, $backgroundColor)));
    }
	
	
	//2015.06.05 自行添加的保存到本地
	function save($string,$path,$size = 120){
		$content= $this->getImageData($string, $size , null, null);
		return file_put_contents($path,$content);
	}

	
}
