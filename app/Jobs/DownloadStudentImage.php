<?php

namespace App\Jobs;

use App\Models\Crud;
use App\Models\Students\Crud as StudentsCrud;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Attributes\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadStudentImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;

    /**
     * Create a new job instance.
     */
    public function __construct(StudentsCrud $student)
    {
        $this->student = $student;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->student->image && filter_var($this->student->image, FILTER_VALIDATE_URL)) {
            try {
                $imageContents = file_get_contents($this->student->image);
                $imageName = uniqid('student_') . '.jpg';

                Storage::disk('public')->put('students/' . $imageName, $imageContents);

                // Update DB with new local path
                $this->student->update([
                    'image' => 'storage/students/' . $imageName
                ]);

            } catch (\Exception $e) {
                dd($e);
                // Log::error_file("Image download failed for student {$this->student->id}: " . $e->getMessage());
            }
        }
    }
}
