<?php

namespace App\Listeners;

use App\Events\ResizeUploadedFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
//use Intervention\Image\Facades\Image;
use Nette\Utils\Image;

class ResizeUploadedFileListener implements ShouldQueue
{
    use InteractsWithQueue;

    private UploadedFile $file;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ResizeUploadedFile  $event
     * @return void
     */
    public function handle(ResizeUploadedFile $event)
    {
        $img = Image::make($event->filePath);
        $img->resize(1920, null, function ($const) {
            $const->aspectRatio();
        })->save($event->filePath);
    }
}
