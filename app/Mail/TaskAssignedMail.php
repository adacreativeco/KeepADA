<?php

namespace App\Mail;

use App\Models\MaintenanceTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public MaintenanceTask $task)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yeni Bakım Görevi Atandı: ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tasks.assigned',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
