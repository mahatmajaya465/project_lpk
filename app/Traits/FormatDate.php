<?php

namespace App\Traits;

trait FormatDate
{
    public function tanggalIndonesian($value)
    {
        $tanggal = Date('Y-m-d', strtotime($value));
        $mounth = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        $pecahkan = explode('-', $tanggal);
        $indonesian = $pecahkan[2] . ' ' . ucfirst($mounth[(int)$pecahkan[1] - 1]) . ' ' . $pecahkan[0];
        return $indonesian;
    }

    public function periodeIndonesian($value)
    {
        $value = Date('Y-m-d', strtotime($value));
        $mounth = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        $pecahkan = explode('-', $value);
        $indonesian = $mounth[(int)$pecahkan[1] - 1] . ' ' . $pecahkan[0];
        return $indonesian;
    }
}
