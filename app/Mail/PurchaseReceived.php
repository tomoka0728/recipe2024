<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected object $user,
        protected array $carts,
        protected array|object $address,
        protected int $sendPrice,
        protected int $usedPoints,
        protected string $pointUsage,
        protected int $total,
        protected int $sum,
        protected int $tax,
        protected string $paymentMethod,
        protected string $purchaseCreatedAt,
        protected int $grantPoint
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@recipemart.com', 'RecipeMart'),
            subject: '【RecipeMart】ご注文確定のお知らせ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase_received',
            with: [
                'user' => $this->user,
                'carts' => $this->carts,
                'address' => $this->address,
                'sendPrice' => $this->sendPrice,
                'usedPoints' => $this->usedPoints,
                'pointUsage' => $this->pointUsage,
                'total' => $this->total,
                'sum' => $this->sum,
                'tax' => $this->tax,
                'paymentMethod' => $this->paymentMethod,
                'purchaseCreatedAt' => $this->purchaseCreatedAt,
                'grantPoint' => $this->grantPoint,
            ],
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
