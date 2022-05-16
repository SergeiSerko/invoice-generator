<?php

namespace App\Service\Order\Sender;


use App\Service\Order\DTO\Order;
use App\Service\Order\Types\InvoiceFormatEnumType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Implementation of OrderInvoiceSenderInterface which sends an invoice via email.
 */
class OrderInvoiceEmailSender implements OrderInvoiceSenderInterface
{
    private MailerInterface $mailer;
    private SerializerInterface $serializer;
    private string $subject = 'Invoice from %s';
    private string $from = 'rest-test@dev';


    public function __construct(
        MailerInterface $mailer,
        SerializerInterface $serializer,
        string $subject = null,
        string $from = null
    )
    {
        $this->mailer = $mailer;
        $this->serializer = $serializer;
        $this->subject = $subject ?? $this->subject;
        $this->from = $from ?? $this->from;
    }

    public function send(Order $order): void
    {
        $to = $order->getOrderPlacement()->getEmail();

        $format = $order->getOrderPlacement()->getInvoiceFormat();
        $data = $this->serializer->serialize($order->getInvoice(),
                                             $format,
                                             ['groups' => ['Invoice']]);

        $subject = sprintf($this->subject, date('Y-m-d H:i:s'));
        $email = (new Email())
            ->to($to)
            ->from($this->from)
            ->subject($subject)
            ->attach($data, "$subject.$format", InvoiceFormatEnumType::MIME[$format]);
        $this->mailer->send($email);
    }


}