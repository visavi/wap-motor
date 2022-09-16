<?php

declare(strict_types=1);

namespace Visavi\Captcha;

class CaptchaBuilder
{
    /**
     * @var array
     */
    protected $frames;

    /**
     * @var string
     */
    protected $phrase;

    /**
     * @var int
     */
    protected $width = 150;

    /**
     * @var int
     */
    protected $height = 40;

    /**
     * @var string
     */
    protected $font;

    /**
     * @var array
     */
    protected $textColor;

    /**
     * @var array
     */
    protected $backgroundColor;

    /**
     * @var int
     */
    protected $windowWidth = 75;

    /**
     * @var int
     */
    protected $pixelPerFrame = 15;

    /**
     * @var int
     */
    protected $delayBetweenFrames = 20;

    public function __construct($phrase = null)
    {
        if ($phrase) {
            $this->phrase = $phrase;
        } else {
            $phraseBuilder = new PhraseBuilder();
            $this->phrase = $phraseBuilder->getPhrase(rand(4, 6));
        }
    }

    /**
     * Get phrase
     *
     * @return string
     */
    public function getPhrase(): string
    {
        return $this->phrase;
    }

    /**
     * Set text color
     *
     * @param int $r
     * @param int $g
     * @param int $b
     *
     * @return $this
     */
    public function setTextColor(int $r, int $g, int $b): self
    {
        $this->textColor = [$r, $g, $b];

        return $this;
    }

    /**
     * Set background color
     *
     * @param int $r
     * @param int $g
     * @param int $b
     *
     * @return $this
     */
    public function setBackgroundColor(int $r, int $g, int $b): self
    {
        $this->backgroundColor = [$r, $g, $b];

        return $this;
    }

    /**
     * Set image width
     *
     * @param int $width
     *
     * @return $this
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set image height
     *
     * @param int $height
     *
     * @return $this
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Set window width
     *
     * @param int $width
     *
     * @return $this
     */
    public function setWindowWidth(int $width): self
    {
        $this->windowWidth = $width;

        return $this;
    }

    /**
     * Set pixel per frame
     *
     * @param int $pixel
     *
     * @return $this
     */
    public function setPixelPerFrame(int $pixel): self
    {
        $this->pixelPerFrame = $pixel;

        return $this;
    }

    /**
     * Set delay between frames
     *
     * @param int $microseconds
     *
     * @return $this
     */
    public function setDelayBetweenFrames(int $microseconds): self
    {
        $this->delayBetweenFrames = $microseconds;

        return $this;
    }

    /**
     * Set font
     *
     * @param string $path
     *
     * @return $this
     */
    public function setFont(string $path): self
    {
        $this->font = $path;

        return $this;
    }

    /**
     * Render captcha
     *
     * @return string
     * @throws
     */
    public function render(): string
    {
        $this->frames = $this->getFrames();

        $delays = [];
        for ($i = 0, $iMax = count($this->frames); $i < $iMax; $i++) {
            $delays[] = $this->delayBetweenFrames;
        }

        $gif = new GifEncoder($this->frames, $delays, 0, 2);

        return $gif->getAnimation();
    }

    /**
     * Get captcha inline
     *
     * @return string
     */
    public function inline(): string
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->render());
    }

    /**
     * Returns gif frames
     *
     * @return array
     */
    public function getFrames(): array
    {
        $frames = [];
        $params = $this->getImageParams();

        for ($i = -$this->windowWidth; $i < $this->width; $i += $this->pixelPerFrame) {
            $image = $this->getBaseImage();

            $foregroundColor = $this->createColor($image, $params['backgroundColor']);

            // left foreground rectangle
            imagefilledrectangle($image, 0, 0, $i, $this->height, $foregroundColor);

            // right foreground rectangle
            imagefilledrectangle($image, $i + $this->windowWidth, 0, $this->width, $this->height, $foregroundColor);

            $this->applyEffect($image, $params);

            $frames[] = $this->getImageContent($image);
        }

        return $frames;
    }

    /**
     * Get image params
     *
     * @return array
     */
    protected function getImageParams(): array
    {
        static $params;

        if (! $params) {
            $params['font'] = $this->font ?? __DIR__ . '/../fonts/' . rand(0, 6) . '.ttf';
            $params['size'] = $this->width / max(strlen($this->phrase), 5);

            $box = imagettfbbox($params['size'], 0, $params['font'], $this->phrase);

            $params['textWidth']  = $box[2] - $box[0];
            $params['textHeight'] = abs($box[7] + $box[1]);

            $params['x'] = (int) (($this->width - $params['textWidth']) / 2);
            $params['y'] = (int) (($this->height + $params['textHeight']) / 2);

            $params['textColor'] = $this->textColor ?? [rand(0, 150), rand(0, 150), rand(0, 150)];
            $params['backgroundColor'] = $this->backgroundColor ?? [rand(200, 255), rand(200, 255), rand(200, 255)];

            $params['negate'] = rand(0, 1);
        }

        return $params;
    }

    /**
     * Apply some post effects
     *
     * @param resource $image
     *
     * @param array $params
     */
    protected function applyEffect($image, array $params): void
    {
        if (! function_exists('imagefilter')) {
            return;
        }

        if ($this->backgroundColor || $this->textColor) {
            return;
        }

        if ($params['negate'] === 1) {
            imagefilter($image, IMG_FILTER_NEGATE);
        }
    }

    /**
     * Create a base image with the text
     *
     * @return resource
     */
    protected function getBaseImage()
    {
        $params = $this->getImageParams();
        $image  = imagecreatetruecolor($this->width, $this->height);

        // Background
        $backgroundColor = $this->createColor($image, $params['backgroundColor']);
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $backgroundColor);

        // Text
        $textColor = $this->createColor($image, $params['textColor']);
        imagettftext($image, $params['size'], 0, $params['x'], $params['y'], $textColor, $params['font'], $this->phrase);

        return $image;
    }

    /**
     * Create color
     *
     * @param resource $image
     * @param array    $color
     *
     * @return false|int
     */
    protected function createColor($image, array $color)
    {
        return imagecolorallocate($image, $color[0], $color[1], $color[2]);
    }

    /**
     * Get image content
     *
     * @param resource $image
     *
     * @return false|string
     */
    protected function getImageContent($image)
    {
        ob_start();
        imagegif($image);
        imagedestroy($image);

        return ob_get_clean();
    }
}
