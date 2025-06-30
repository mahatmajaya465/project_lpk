<?php

namespace App\Traits;

trait FileUpload
{
    public function FileUpload($file, $type)
    {
        $file_name = time() . '_' . $type . '.' . $file->getClientOriginalExtension();
        $file_path = public_path('/uploads');
        $file->move($file_path, $file_name);

        return $file_name;
    }
}
