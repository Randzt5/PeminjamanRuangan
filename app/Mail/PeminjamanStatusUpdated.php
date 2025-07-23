<?php

namespace App\Mail;

use App\Models\Peminjaman; // Import model Peminjaman
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PeminjamanStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman; // Properti untuk menyimpan data peminjaman

    /**
     * Create a new message instance.
     */
    public function __construct(Peminjaman $peminjaman)
    {
        // Menerima data peminjaman saat Mailable ini dibuat
        $this->peminjaman = $peminjaman;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Peminjaman Ruangan', // Ini akan menjadi subjek email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Menunjuk ke file view yang akan kita buat sebagai isi email
        return new Content(
            view: 'emails.peminjaman-status-updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}