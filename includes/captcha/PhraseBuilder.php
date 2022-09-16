<?php

declare(strict_types=1);

namespace Visavi\Captcha;

class PhraseBuilder
{
    /**
     * Get random phrase of given length with given charset
     *
     * @param int    $length
     * @param string $characters
     *
     * @return string
     */
    public function getPhrase(
        int $length = 6,
        string $characters = 'abcdefghijklmnpqrstuvwxyz123456789'
    ): string {
        $phrase = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $phrase .= $characters[rand(0, $charactersLength - 1)];
        }

        return $phrase;
    }
}
