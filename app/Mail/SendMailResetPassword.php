<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Env;
use App\Models\User;

class SendMailResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $url;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $token)
    {
        $this->data = $data;
        if($this->data->role == User::ROLE_CUSTOMER) {
            $this->url = env('APP_URL') . '/password-change/' . urlencode($token);
        } else {
            $this->url = env('APP_URL') . '/admin/password-change/' . urlencode($token);
        }
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gửi thư đặt lại mật khẩu')
            ->markdown('Mails.send_mail_reset_password');
    }
}
