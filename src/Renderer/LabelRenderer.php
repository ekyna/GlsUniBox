<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Renderer;

use Com\Tecnick\Barcode\Barcode;
use Ekyna\Component\GlsUniBox\Api\Config;

use function imagecolorallocate;
use function imagecreatefromgif;

/**
 * Class LabelRenderer
 * @package Ekyna\Component\GlsUniBox\Renderer
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class LabelRenderer
{
    protected ?array $layout = null;
    protected ?array $fonts  = null;
    protected ?array $colors = null;

    /** @var resource|\GdImage|null */
    protected $image = null;

    /**
     * Renders the label from the given data.
     */
    public function render(array $data): string
    {
        $this->initialize();

        $this->build($data);

        return $this->getImageData();
    }

    public function setLayout(array $layout): LabelRenderer
    {
        $this->layout = $layout;

        return $this;
    }

    public function setFonts(array $fonts): LabelRenderer
    {
        $this->fonts = $fonts;

        return $this;
    }

    public function setColors(array $colors): LabelRenderer
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Initializes the label.
     */
    private function initialize()
    {
        $this->image = imagecreatefromgif(__DIR__ . '/../Resources/img/gls-label.gif');

        $this->colors = [
            'black' => imagecolorallocate($this->image, 0, 0, 0),
            'white' => imagecolorallocate($this->image, 255, 255, 255),
        ];

        if (null !== $this->layout) {
            return;
        }

        $this->layout = [
            // Control bar 1
            Config::T110  => ['s' => 84, 'x' => 28, 'y' => 155],
            Config::T310  => ['s' => 84, 'x' => 545, 'y' => 155, 'c' => 'white'],
            Config::T100  => ['s' => 84, 'x' => 662, 'y' => 155],
            Config::T105  => ['s' => 84, 'x' => 662, 'y' => 155],
            Config::T101  => ['s' => 84, 'x' => 877, 'y' => 155, 'c' => 'white'],
            // Control bar 2
            Config::T320  => ['s' => 72, 'x' => 28, 'y' => 305],
            Config::T8951 => ['s' => 32, 'x' => 387, 'y' => 245],
            Config::T8952 => ['s' => 32, 'x' => 622, 'y' => 245],
            Config::T330  => ['s' => 48, 'x' => 370, 'y' => 320],
            Config::T8913 => ['s' => 48, 'x' => 622, 'y' => 320],
            Config::T200  => ['s' => 52, 'x' => 962, 'y' => 297, 'f' => 'swiss_bold'],
            // Control bar 3 (barcodes)
            // Control bar 4
            Config::T500  => ['s' => 40, 'x' => 20, 'y' => 780],
            Config::T540  => ['s' => 20, 'x' => 255, 'y' => 780],
            Config::T541  => ['s' => 20, 'x' => 390, 'y' => 780],
            Config::T530  => ['s' => 32, 'x' => 520, 'y' => 780, 'append' => 'KG'],
            // Bloc 1
            Config::T751  => ['s' => 38, 'x' => 30, 'y' => 965],
            Config::T752  => ['s' => 38, 'x' => 30, 'y' => 1070],
            // Bloc 2
            Config::T860  => ['s' => 30, 'x' => 30, 'y' => 1290],
            Config::T861  => ['s' => 30, 'x' => 30, 'y' => 1347],
            Config::T862  => ['s' => 30, 'x' => 30, 'y' => 1404],
            Config::T863  => ['s' => 30, 'x' => 30, 'y' => 1461],
            // Bloc 3

            // Bloc 4
            Config::T8915 => ['s' => 28, 'x' => 1110, 'y' => 1020, 'a' => 270, 'prepend' => 'Client '],
            Config::T8914 => ['s' => 28, 'x' => 1110, 'y' => 1350, 'a' => 270, 'prepend' => 'ContactId '],
            Config::T810  => ['s' => 24, 'x' => 1060, 'y' => 830, 'a' => 270],
            Config::T820  => ['s' => 24, 'x' => 1015, 'y' => 830, 'a' => 270],
        ];

        $this->fonts = [
            'swiss_normal' => __DIR__ . '/../Resources/font/Swiss721CondensedBT.ttf',
            'swiss_bold'   => __DIR__ . '/../Resources/font/Swiss721BoldCondensedBT.ttf',
        ];
    }

    /**
     * Writes the fields to the label.
     *
     * @param array $data
     */
    protected function build(array $data)
    {
        foreach ($this->layout as $key => $c) {
            if (!isset($data[$key]) || 0 === strlen($value = $data[$key])) {
                continue;
            }

            if (isset($c['prepend'])) {
                $value = $c['prepend'] . $value;
            }
            if (isset($c['append'])) {
                $value .= $c['append'];
            }

            $angle = $c['a'] ?? 0;
            $color = $c['c'] ?? 'black';
            $font = $c['f'] ?? 'swiss_normal';

            $this->text($value, $c['s'], $c['x'], $c['y'], $color, $font, $angle);
        }

        // Primary barcode
        $matrix = imagecreatefromstring($this->getBarcodeDatamatrix($data[Config::T8902]));
        imagecopy($this->image, $matrix, 57, 398, 0, 0, imagesx($matrix), imagesy($matrix));
        imagedestroy($matrix);

        // Mondial relay
        if (isset($data[Config::T200]) && $data[Config::T200] === 'SHD') {
            $this->text('Mondial Relay', 40, 475, 420);

            // Barcode
            $barcode = imagecreatefromstring($this->getBarcode128($data[Config::T8913]));
            imagecopy($this->image, $barcode, 425, 462, 0, 0, imagesx($barcode), imagesy($barcode));
            imagedestroy($barcode);

            $this->text('GLS' . $data[Config::T8913], 32, 500, 670);
        }

        // Secondary barcode
        $matrix = imagecreatefromstring($this->getBarcodeDatamatrix($data[Config::T8903]));
        imagecopy($this->image, $matrix, 895, 400, 0, 0, imagesx($matrix), imagesy($matrix));
        imagedestroy($matrix);

        // Pages
        if (isset($data[Config::T8904]) && isset($data[Config::T8905])) {
            $pages = $data[Config::T8904] . '/' . $data[Config::T8905];
            $this->text($pages, 20, 792, 780);
        }

        // Service label
        $service = null;
        if (isset($data[Config::T750])) {
            $service = $data[Config::T750];
        } elseif (isset($data[Config::T200]) && $data[Config::T200] === 'T13') {
            $service = '13.00SERVICE';
        }
        if ($service) {
            $this->text($service, 38, 30, 870);
        }

        // Téléphones
        if (isset($data[Config::T1230])) {
            $this->text($data[Config::T1230], 38, 30, 1175);
        } elseif (isset($data[Config::T871])) {
            $this->text($data[Config::T871], 38, 30, 1175);
        }

        // Ref. destinataire
        if (isset($data[Config::T859]) && !empty($value = $data[Config::T859])) {
            $this->text('Ref Dest : ' . $value, 22, 600, 1230);
        }

        // Pays / Code postal / Ville destinataire
        $this->text($data[Config::T100] . ' ' . $data[Config::T330] . ' ' . $data[Config::T864], 30, 30, 1518);

        // Expediteur
        $this->text('Expediteur', 28, 1110, 810, 'black', 'swiss_bold', 270);

        // Pays / Code postal / Ville expéditeur
        $value = $data[Config::T821] . ' ' . $data[Config::T822] . ' ' . $data[Config::T823];
        $this->text($value, 28, 925, 830, 'black', 'swiss_normal', 270);
    }

    /**
     * Writes the given text.
     *
     * @noinspection PhpTooManyParametersInspection
     */
    private function text(
        string $text,
        int    $size,
        int    $x,
        int    $y,
        string $color = 'black',
        string $font = 'swiss_normal',
        int    $angle = 0
    ): void {
        imagettftext($this->image, $size, $angle, $x, $y, $this->colors[$color], $this->fonts[$font], $text);
    }

    /**
     * Returns the image raw data.
     *
     * @return string
     */
    private function getImageData(): string
    {
        ob_start();
        imagegif($this->image);
        $output = ob_get_contents();
        ob_end_clean();
        imagedestroy($this->image);

        return $output;
    }

    /**
     * Returns the datamatrix from the given data.
     */
    public function getBarcodeDatamatrix(string $data): string
    {
        $barcode = new Barcode();

        $bObj = $barcode->getBarcodeObj(
            'DATAMATRIX',
            $data,
            256,
            256,
            'black',
            [0, 0, 0, 0]
        )->setBackgroundColor('white');

        return $bObj->getPngData();
    }

    /**
     * Returns the barcode from the given data.
     */
    public function getBarcode128(string $data): string
    {
        $barcode = new Barcode();

        $bObj = $barcode->getBarcodeObj(
            'C128',
            $data,
            380,
            135,
            'black',
            [0, 0, 0, 0]
        )->setBackgroundColor('white');

        return $bObj->getPngData();
    }
}
