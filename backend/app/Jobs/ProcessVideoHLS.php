<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProcessVideoHLS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->video->update(['conversion_status' => 'processing']);

            // Define the HLS export path (a directory per video)
            $hlsPath = 'videos/' . $this->video->id . '/playlist.m3u8';

            // We use a relatively low bitrate for 720p to save processing time on Render/VPS
            $lowBitrate = (new X264('aac'))->setKiloBitrate(1000);
            
            // FFMpeg takes the original file from the r2 disk and exports HLS to the r2 disk
            FFMpeg::fromDisk('r2')
                ->open($this->video->video_path)
                ->exportForHLS()
                ->addFormat($lowBitrate)
                ->toDisk('r2')
                ->save($hlsPath);

            // Once complete, update the database
            $this->video->update([
                'hls_path' => $hlsPath,
                'conversion_status' => 'completed'
            ]);

        } catch (\Exception $e) {
            $this->video->update(['conversion_status' => 'failed']);
            throw $e; // Re-throw to trigger job failure handling
        }
    }
}
