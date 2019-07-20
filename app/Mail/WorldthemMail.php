<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WorldthemMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $text;
    public function __construct($subject,$text) {
        $this->subject= $subject ;
        $this->text= $text ;
        $this-> build();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      
      $address_from = @config('mail.from.address');
      $name_from = @config('mail.from.name');
     
      $address_from = $address_from=="hello@example.com" ? \Wh::constant_key(_MAIN_OPTIONS_,  "admin_mail") : $address_from;
   
        return $this->view( 'standart.email.email') 
                ->from($address_from, $name_from)
                ->replyTo($address_from, $name_from)
                ->subject($this->subject) ->with([
                        'subject' => $this->subject,
                        'content' => $this->text,
                    ]);  
    }
    
    
}
