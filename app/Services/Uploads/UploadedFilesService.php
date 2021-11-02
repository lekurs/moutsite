<?php


namespace App\Services\Uploads;


use App\Events\ResizeUploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UploadedFilesService
{
//    private function controlUploadedFile(UploadedFile $file)
//    {
//        $mimeTypes = ['image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'];
//
//        if ($file->getError() !== 0) {
//
//            return back()->with('error', $file->getErrorMessage());
//        }
//
//        if (!in_array($file->getMimeType(), $mimeTypes)) {
//
//            return back()->with('error', 'Pas le bon format de fichier');
//        }
//    }

    public function moveFile($file, string $path): void
    {
//        $this->controlUploadedFile($file);

        $file->storeAs($path, $file->getClientOriginalName());

        ResizeUploadedFile::dispatch($file);
    }

    public function removeFile(string $path)
    {
        Storage::delete($path);
    }
}
