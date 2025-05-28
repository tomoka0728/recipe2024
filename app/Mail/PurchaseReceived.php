<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $carts;
    public $address;
    public $sendPrice;
    public $usedPoints;
    public $pointUsage;
    public $total;
    public $paymentMethod;
    public $purchaseCreatedAt;
    public $sum;
    public $tax;
    public $grantPoint;

    /**
     * Create a new message instance.
     *
     * @param  object  $user
     * @param  array   $carts
     * @param  array|object $address
     * @param  int     $sendPrice
     * @param  int     $usedPoints
     * @param  string  $pointUsage
     * @param  int     $total
     * @return void
     */
    public function __construct($user, $carts, $address, $sendPrice, $usedPoints, $pointUsage, $total, $sum, $tax, $paymentMethod, $purchaseCreatedAt, $grantPoint)
    {
        $this->user = $user;
        $this->carts = $carts;
        $this->address = $address;
        $this->sendPrice = (int)$sendPrice;
        $this->usedPoints = (int)$usedPoints;
        $this->pointUsage = $pointUsage;
        $this->total = (int)$total;
        $this->sum = (int)$sum;
        $this->tax = (int)$tax;
        $this->paymentMethod = $paymentMethod;
        $this->purchaseCreatedAt = $purchaseCreatedAt;
        $this->grantPoint = (int)$grantPoint;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【recipeApp】ご注文確定のお知らせ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase_received',
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
