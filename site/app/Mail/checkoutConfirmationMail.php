<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class checkoutConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The user instance.
     *
     * @var User
     */
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('onlineadresboek@gmail.com')
            ->view('emails.checkout')
            ->with([
                'data' => $this->data,
            ]);
    }
}