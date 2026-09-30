<?php

namespace App\Enums;

use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * Barcode symbologies supported by the admin.
 * Values match the `name` column of the barcodes table and map to
 * picqer/php-barcode-generator types.
 */
enum BarcodeType: string
{
    case EAN_13 = 'EAN-13';
    case UPC_A = 'UPC-A';

    public function label(): string
    {
        return match ($this) {
            self::EAN_13 => 'EAN-13 (retail, worldwide)',
            self::UPC_A => 'UPC-A (retail, North America)',
        };
    }

    /**
     * The picqer generator constant for this type.
     */
    public function generatorType(): string
    {
        return match ($this) {
            self::EAN_13 => BarcodeGeneratorPNG::TYPE_EAN_13,
            self::UPC_A => BarcodeGeneratorPNG::TYPE_UPC_A,
        };
    }

    /**
     * Laravel validation rule for a code of this type.
     * EAN-13: 12 digits (checksum auto-added) or 13 digits.
     * UPC-A: 11 digits (checksum auto-added) or 12 digits.
     */
    public function codeRule(): array
    {
        return match ($this) {
            self::EAN_13 => ['digits_between:12,13'],
            self::UPC_A => ['digits_between:11,12'],
        };
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'value');
    }
}
