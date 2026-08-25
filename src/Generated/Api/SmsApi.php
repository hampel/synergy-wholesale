<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\DetermineSMSCostResponse;
use Hampel\SynergyWholesale\Generated\Response\SendSMSResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class SmsApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function will send an sms
     *
     * SOAP operation: sendSMS
     */
    public function sendSMS(
        string $destination,
        string $senderID,
        string $message,
    ): SendSMSResponse {
        return SendSMSResponse::fromWire($this->client->call('sendSMS', [
            'destination' => $destination,
            'senderID' => $senderID,
            'message' => $message,
        ]));
    }

    /**
     * This function determine the cost of the sms to be sent along with how many messages are required to be sent
     *
     * SOAP operation: determineSMSCost
     */
    public function determineSMSCost(
        string $destination,
        string $message,
    ): DetermineSMSCostResponse {
        return DetermineSMSCostResponse::fromWire($this->client->call('determineSMSCost', [
            'destination' => $destination,
            'message' => $message,
        ]));
    }
}
