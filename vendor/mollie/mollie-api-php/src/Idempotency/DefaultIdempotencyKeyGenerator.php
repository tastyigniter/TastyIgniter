<?php
namespace Mollie\Api\Idempotency;

use Mollie\Api\Exceptions\IncompatiblePlatform;

class DefaultIdempotencyKeyGenerator implements IdempotencyKeyGeneratorContract
{
    const DEFAULT_LENGTH = 16;

    /**
     * @var int
     */
    protected $length;

    public function __construct($length = self::DEFAULT_LENGTH)
    {
        $this->length = $length;
    }

    /**
     * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
     * @return string
     */
    public function generate()
    {
        $length = $this->length;

        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            try {
                $bytes = random_bytes($size);
            } catch (\Exception $e) {
                throw new IncompatiblePlatform(
                    'PHP function random_bytes missing. Consider overriding the DefaultIdempotencyKeyGenerator with your own.',
                    IncompatiblePlatform::INCOMPATIBLE_RANDOM_BYTES_FUNCTION
                );
            }

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}
