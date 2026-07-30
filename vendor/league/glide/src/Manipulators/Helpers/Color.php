<?php

namespace League\Glide\Manipulators\Helpers;

class Color
{
    /**
     * 3 digit color code expression.
     */
    const SHORT_RGB = '/^[0-9a-f]{3}$/i';

    /**
     * 4 digit color code expression.
     */
    const SHORT_ARGB = '/^[0-9]{1}[0-9a-f]{3}$/i';

    /**
     * 6 digit color code expression.
     */
    const LONG_RGB = '/^[0-9a-f]{6}$/i';

    /**
     * 8 digit color code expression.
     */
    const LONG_ARGB = '/^[0-9]{2}[0-9a-f]{6}$/i';

    /**
     * The red value.
     *
     * @var int
     */
    protected $red;

    /**
     * The green value.
     *
     * @var int
     */
    protected $green;

    /**
     * The blue value.
     *
     * @var int
     */
    protected $blue;

    /**
     * The alpha value.
     *
     * @var int|float
     */
    protected $alpha;

    /**
     * Create color helper instance.
     *
     * @param string $value The color value.
     */
    public function __construct($value)
    {
        do {
            if ($hex = $this->getHexFromColorName($value)) {
                $rgba = $this->parseHex($hex);
                $alpha = 1;
                break;
            }

            if (preg_match(self::SHORT_RGB, $value)) {
                $rgba = $this->parseHex($value.$value);
                $alpha = 1;
                break;
            }

            if (preg_match(self::SHORT_ARGB, $value)) {
                $rgba = $this->parseHex(substr($value, 1).substr($value, 1));
                $alpha = (float) substr($value, 0, 1) / 10;
                break;
            }

            if (preg_match(self::LONG_RGB, $value)) {
                $rgba = $this->parseHex($value);
                $alpha = 1;
                break;
            }

            if (preg_match(self::LONG_ARGB, $value)) {
                $rgba = $this->parseHex(substr($value, 2));
                $alpha = (float) substr($value, 0, 2) / 100;
                break;
            }

            $rgba = [255, 255, 255];
            $alpha = 0;
        } while (false);

        $this->red = $rgba[0];
        $this->green = $rgba[1];
        $this->blue = $rgba[2];
        $this->alpha = $alpha;
    }

    /**
     * Parse hex color to RGB values.
     *
     * @param string $hex The hex value.
     *
     * @return array The RGB values.
     */
    public function parseHex($hex)
    {
        return array_map('hexdec', str_split($hex, 2));
    }

    /**
     * Format color for consumption.
     *
     * @return string The formatted color.
     */
    public function formatted()
    {
        return 'rgba('.$this->red.', '.$this->green.', '.$this->blue.', '.$this->alpha.')';
    }

    /**
     * Get hex code by color name.
     *
     * @param string $name The color name.
     *
     * @return string|null The hex code.
     */
    public function getHexFromColorName($name)
    {
        $colors = [
            'aliceblue' => 'F0F8FF',
            'antiquewhite' => 'FAEBD7',
            'aqua' => '00FFFF',
            'aquamarine' => '7FFFD4',
            'azure' => 'F0FFFF',
            'beige' => 'F5F5DC',
            'bisque' => 'FFE4C4',
            'black' => '000000',
            'blanchedalmond' => 'FFEBCD',
            'blue' => '0000FF',
            'blueviolet' => '8A2BE2',
            'brown' => 'A52A2A',
            'burlywood' => 'DEB887',
            'cadetblue' => '5F9EA0',
            'chartreuse' => '7FFF00',
            'chocolate' => 'D2691E',
            'coral' => 'FF7F50',
            'cornflowerblue' => '6495ED',
            'cornsilk' => 'FFF8DC',
            'crimson' => 'DC143C',
            'cyan' => '00FFFF',
            'darkblue' => '00008B',
            'darkcyan' => '008B8B',
            'darkgoldenrod' => 'B8860B',
            'darkgray' => 'A9A9A9',
            'darkgreen' => '006400',
            'darkkhaki' => 'BDB76B',
            'darkmagenta' => '8B008B',
            'darkolivegreen' => '556B2F',
            'darkorange' => 'FF8C00',
            'darkorchid' => '9932CC',
            'darkred' => '8B0000',
            'darksalmon' => 'E9967A',
            'darkseagreen' => '8FBC8F',
            'darkslateblue' => '483D8B',
            'darkslategray' => '2F4F4F',
            'darkturquoise' => '00CED1',
            'darkviolet' => '9400D3',
            'deeppink' => 'FF1493',
            'deepskyblue' => '00BFFF',
            'dimgray' => '696969',
            'dodgerblue' => '1E90FF',
            'firebrick' => 'B22222',
            'floralwhite' => 'FFFAF0',
            'forestgreen' => '228B22',
            'fuchsia' => 'FF00FF',
            'gainsboro' => 'DCDCDC',
            'ghostwhite' => 'F8F8FF',
            'gold' => 'FFD700',
            'goldenrod' => 'DAA520',
            'gray' => '808080',
            'green' => '008000',
            'greenyellow' => 'ADFF2F',
            'honeydew' => 'F0FFF0',
            'hotpink' => 'FF69B4',
            'indianred' => 'CD5C5C',
            'indigo' => '4B0082',
            'ivory' => 'FFFFF0',
            'khaki' => 'F0E68C',
            'lavender' => 'E6E6FA',
            'lavenderblush' => 'FFF0F5',
            'lawngreen' => '7CFC00',
            'lemonchiffon' => 'FFFACD',
            'lightblue' => 'ADD8E6',
            'lightcoral' => 'F08080',
            'lightcyan' => 'E0FFFF',
            'lightgoldenrodyellow' => 'FAFAD2',
            'lightgray' => 'D3D3D3',
            'lightgreen' => '90EE90',
            'lightpink' => 'FFB6C1',
            'lightsalmon' => 'FFA07A',
            'lightseagreen' => '20B2AA',
            'lightskyblue' => '87CEFA',
            'lightslategray' => '778899',
            'lightsteelblue' => 'B0C4DE',
            'lightyellow' => 'FFFFE0',
            'lime' => '00FF00',
            'limegreen' => '32CD32',
            'linen' => 'FAF0E6',
            'magenta' => 'FF00FF',
            'maroon' => '800000',
            'mediumaquamarine' => '66CDAA',
            'mediumblue' => '0000CD',
            'mediumorchid' => 'BA55D3',
            'mediumpurple' => '9370DB',
            'mediumseagreen' => '3CB371',
            'mediumslateblue' => '7B68EE',
            'mediumspringgreen' => '00FA9A',
            'mediumturquoise' => '48D1CC',
            'mediumvioletred' => 'C71585',
            'midnightblue' => '191970',
            'mintcream' => 'F5FFFA',
            'mistyrose' => 'FFE4E1',
            'moccasin' => 'FFE4B5',
            'navajowhite' => 'FFDEAD',
            'navy' => '000080',
            'oldlace' => 'FDF5E6',
            'olive' => '808000',
            'olivedrab' => '6B8E23',
            'orange' => 'FFA500',
            'orangered' => 'FF4500',
            'orchid' => 'DA70D6',
            'palegoldenrod' => 'EEE8AA',
            'palegreen' => '98FB98',
            'paleturquoise' => 'AFEEEE',
            'palevioletred' => 'DB7093',
            'papayawhip' => 'FFEFD5',
            'peachpuff' => 'FFDAB9',
            'peru' => 'CD853F',
            'pink' => 'FFC0CB',
            'plum' => 'DDA0DD',
            'powderblue' => 'B0E0E6',
            'purple' => '800080',
            'rebeccapurple' => '663399',
            'red' => 'FF0000',
            'rosybrown' => 'BC8F8F',
            'royalblue' => '4169E1',
            'saddlebrown' => '8B4513',
            'salmon' => 'FA8072',
            'sandybrown' => 'F4A460',
            'seagreen' => '2E8B57',
            'seashell' => 'FFF5EE',
            'sienna' => 'A0522D',
            'silver' => 'C0C0C0',
            'skyblue' => '87CEEB',
            'slateblue' => '6A5ACD',
            'slategray' => '708090',
            'snow' => 'FFFAFA',
            'springgreen' => '00FF7F',
            'steelblue' => '4682B4',
            'tan' => 'D2B48C',
            'teal' => '008080',
            'thistle' => 'D8BFD8',
            'tomato' => 'FF6347',
            'turquoise' => '40E0D0',
            'violet' => 'EE82EE',
            'wheat' => 'F5DEB3',
            'white' => 'FFFFFF',
            'whitesmoke' => 'F5F5F5',
            'yellow' => 'FFFF00',
            'yellowgreen' => '9ACD32',
        ];

        $name = strtolower($name);

        if (array_key_exists($name, $colors)) {
            return $colors[$name];
        }
    }
}
