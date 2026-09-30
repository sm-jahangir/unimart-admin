<?php

namespace App\Models;

use App\Enums\BarcodeType;
use Illuminate\Database\Eloquent\Model;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Picqer\Barcode\Exceptions\InvalidCharacterException;

class Barcode extends Model
{
    protected $guarded = ['id'];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The symbology of this barcode row, e.g. BarcodeType::EAN_13.
     */
    public function type(): BarcodeType
    {
        return BarcodeType::from($this->name);
    }

    /**
     * Render a code as a PNG data URI, ready for <img src="...">.
     *
     * Note: the generator zero-pads short numeric codes, so enforce the
     * proper length at input time with BarcodeType::codeRule().
     *
     * @throws InvalidCharacterException for non-numeric codes.
     */
    public function pngDataUri(string $code, int $widthFactor = 3, int $heightFactor = 40): string
    {
        return 'data:image/png;base64,'.base64_encode(
            (new BarcodeGeneratorPNG)->getBarcode($code, $this->type()->generatorType(), $widthFactor, $heightFactor)
        );
    }

    /**
     * Render a code as an SVG string (crisper for print layouts, starts with <?xml).
     *
     * @throws InvalidCharacterException for non-numeric codes.
     */
    public function svg(string $code, float $widthFactor = 3.0, int $height = 40, string $color = '#000000'): string
    {
        return (new BarcodeGeneratorSVG)
            ->getBarcode($code, $this->type()->generatorType(), $widthFactor, $height, $color);
    }
}
