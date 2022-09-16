<?php

declare(strict_types=1);

namespace Visavi\Captcha;

use Exception;

class GifEncoder
{
    /* GIF header 6 bytes */
    private $gif = 'GIF89a';
    private $buf = [];
    private $img = -1;
    private $lop;
    private $dis;
    private $ofs;
    private $col;

    /**
     * GIF encoder
     *
     * @param array  $frames
     * @param array  $delays
     * @param int    $lop
     * @param int    $dis
     * @param int    $red
     * @param int    $green
     * @param int    $blue
     * @param array  $ofs
     * @param string $mod
     *
     * @throws Exception
     */
    public function __construct(
        array $frames,
        array $delays,
        int $lop,
        int $dis,
        int $red = 0,
        int $green = 0,
        int $blue = 0,
        array $ofs = [],
        string $mod = 'bin'
    ) {
        $this->lop = ($lop > -1) ? $lop : 0;
        $this->dis = ($dis > -1) ? ($dis < 3 ? $dis : 3) : 2;
        $this->col = ($red > -1 && $green > -1 && $blue > -1) ? ($red | ($green << 8) | ($blue << 16)) : -1;
        $this->ofs = $ofs;

        $iMax = count($frames);
        for ($i = 0; $i < $iMax; $i++) {
            if (strtolower($mod) === 'url') {
                $this->buf[] = fread(fopen($frames[$i], 'rb'), filesize($frames[$i]));
            } elseif (strtolower($mod) === 'bin') {
                $this->buf[] = $frames[$i];
            } else {
                throw new Exception(sprintf('%s (%s)', 'Unintelligible flag!', $mod));
            }

            if (strpos($this->buf[$i], 'GIF87a') !== 0 && strpos($this->buf[$i], 'GIF89a') !== 0) {
                throw new Exception(sprintf('%s (%d source)', 'Source is not a GIF image!', $i));
            }

            for ($j = (13 + 3 * (2 << (ord($this->buf[$i][10]) & 0x07))), $k = true; $k; $j++) {
                switch ($this->buf[$i][$j]) {
                    case '!':
                        if ((substr($this->buf[$i], ($j + 3), 8)) === 'NETSCAPE') {
                            throw new Exception(sprintf(
                                '%s (%d source)',
                                'Does not make animation from animated GIF source!',
                                $i + 1
                            ));
                        }
                        break;
                    case ';':
                        $k = false;
                        break;
                }
            }
        }

        $this->addHeader();
        $iMax = count($this->buf);
        for ($i = 0; $i < $iMax; $i++) {
            $this->addFrames($i, $delays[$i]);
        }

        $this->addFooter();
    }

    /**
     * Add header
     */
    private function addHeader(): void
    {
        if (ord($this->buf[0][10]) & 0x80) {
            $cmap = 3 * (2 << (ord($this->buf[0][10]) & 0x07));
            $this->gif .= substr($this->buf[0], 6, 7);
            $this->gif .= substr($this->buf[0], 13, $cmap);
            $this->gif .= "!\377\13NETSCAPE2.0\3\1";
            $this->gif .= chr($this->lop & 0xFF) . chr(($this->lop >> 8) & 0xFF) . "\0";
        }
    }

    /**
     * Add frames
     *
     * @param int $i
     * @param int $d
     */
    private function addFrames(int $i, int $d): void
    {
        $localStr  = 13 + 3 * (2 << (ord($this->buf[$i][10]) & 0x07));
        $localEnd  = strlen($this->buf[$i]) - $localStr - 1;
        $localTmp  = substr($this->buf[$i], $localStr, $localEnd);
        $globalLen = 2 << (ord($this->buf[0][10]) & 0x07);
        $localLen  = 2 << (ord($this->buf[$i][10]) & 0x07);
        $globalRgb = substr($this->buf[0], 13, 3 * (2 << (ord($this->buf[0][10]) & 0x07)));
        $localRgb  = substr($this->buf[$i], 13, 3 * (2 << (ord($this->buf[$i][10]) & 0x07)));
        $localExt  = "!\xF9\x04" . chr(($this->dis << 2) + 0) . chr(($d >> 0) & 0xFF) . chr(($d >> 8) & 0xFF) . "\x0\x0";

        if ($this->col > -1 && ord($this->buf[$i][10]) & 0x80) {
            for ($j = 0; $j < (2 << (ord($this->buf[$i][10]) & 0x07)); $j++) {
                if (
                    ord($localRgb[3 * $j + 0]) === (($this->col >> 16) & 0xFF)
                    && ord($localRgb[3 * $j + 1]) === (($this->col >> 8) & 0xFF)
                    && ord($localRgb[3 * $j + 2]) === (($this->col >> 0) & 0xFF)
                ) {
                    $localExt = "!\xF9\x04" . chr(($this->dis << 2) + 1) . chr(($d >> 0) & 0xFF) . chr(($d >> 8) & 0xFF) . chr($j) . "\x0";
                    break;
                }
            }
        }

        switch ($localTmp[0]) {
            case '!':
                $localImg = substr($localTmp, 8, 10);
                $localTmp = substr($localTmp, 18);
                break;
            case ',':
                $localImg = substr($localTmp, 0, 10);
                $localTmp = substr($localTmp, 10);
                break;
            default:
                $localImg = $localTmp;
        }

        if ($this->img > -1 && ord($this->buf[$i][10]) & 0x80) {
            if ($globalLen === $localLen && $this->blockCompare($globalRgb, $localRgb, $globalLen)) {
                $this->gif .= ($localExt . $localImg . $localTmp);
            } else {
                if ($this->ofs) {
                    $localImg[1] = chr($this->ofs[$i][0] & 0xFF);
                    $localImg[2] = chr(($this->ofs[$i][0] & 0xFF00) >> 8);
                    $localImg[3] = chr($this->ofs[$i][1] & 0xFF);
                    $localImg[4] = chr(($this->ofs[$i][1] & 0xFF00) >> 8);
                }

                $byte = ord($localImg[9]);
                $byte |= 0x80;
                $byte &= 0xF8;
                $byte |= (ord($this->buf[$i][10]) & 0x07);
                $localImg[9] = chr($byte);
                $this->gif .= $localExt . $localImg . $localRgb . $localTmp;
            }
        } else {
            $this->gif .= ($localExt . $localImg . $localTmp);
        }

        $this->img = 1;
    }

    /**
     * Add footer
     */
    private function addFooter(): void
    {
        $this->gif .= ';';
    }

    /**
     * Block compare
     *
     * @param string $globalBlock
     * @param string $localBlock
     * @param int    $len
     *
     * @return bool
     */
    private function blockCompare(string $globalBlock, string $localBlock, int $len): bool
    {
        for ($i = 0; $i < $len; $i++) {
            if (
                $globalBlock[3 * $i + 0] !== $localBlock[3 * $i + 0]
                || $globalBlock[3 * $i + 1] !== $localBlock[3 * $i + 1]
                || $globalBlock[3 * $i + 2] !== $localBlock[3 * $i + 2]
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get animation
     *
     * @return string
     */
    public function getAnimation(): string
    {
        return $this->gif;
    }
}
