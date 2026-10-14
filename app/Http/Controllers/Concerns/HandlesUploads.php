<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;

trait HandlesUploads
{
    /** Validasi (JPG/PNG/WEBP, maks 2MB) lalu simpan ke public/uploads/{folder}. Return nama file atau false. */
    protected function simpanGambar(UploadedFile $file, string $folder, string $prefix): string|false
    {
        $diizinkan = ['image/jpeg', 'image/png', 'image/webp'];

        if (! in_array($file->getMimeType(), $diizinkan, true) || $file->getSize() > 2 * 1024 * 1024) {
            return false;
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $nama = $prefix . uniqid() . '_' . time() . '.' . $ext;
        $dir = public_path('uploads/' . $folder);

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $file->move($dir, $nama);

        return $nama;
    }

    protected function hapusGambar(?string $nama, string $folder): void
    {
        if ($nama) {
            $path = public_path('uploads/' . $folder . '/' . $nama);
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }
}
