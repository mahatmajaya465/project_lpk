<?php

namespace App\Traits;

trait FormatRupiah
{
    public function rupiahWithoutRP($value)
    {
        if (is_float($value)) {
            $value = round($value);
            $value = number_format($value, 3, '.', '');
        }

        $rupiah = number_format($value, 0, ',', '.');
        $rupiah = str_replace('.', '', $rupiah);
        return $rupiah;
    }

    public function rupiah($value)
    {
        $value = str_replace(',', '.', $value);
        
        if (is_float($value)) {
            $value = round($value);
            $value = number_format($value, 3, '.', '');
        }

        $rupiah = number_format($value, 0, ',', '.');
        return $rupiah;
    }

    public function removeRupiah($value)
    {
        $value = str_replace("Rp. ", "", $value);
        $nominal = str_replace(".", "", $value);

        return $nominal;
    }
}
