<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\AddEmailToSMSForwarderResponse;
use Hampel\SynergyWholesale\Generated\Response\AddMailForwardResponse;
use Hampel\SynergyWholesale\Generated\Response\AddSimpleURLForwardResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteEmailToSMSForwarderResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteMailForwardResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteSimpleURLForwardResponse;
use Hampel\SynergyWholesale\Generated\Response\EditSimpleURLForwardResponse;
use Hampel\SynergyWholesale\Generated\Response\GetSimpleURLForwardsResponse;
use Hampel\SynergyWholesale\Generated\Response\ListEmailToSMSForwardersResponse;
use Hampel\SynergyWholesale\Generated\Response\ListMailForwardsResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class ForwardingApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function will add a new mail forward using the supplied details
     *
     * SOAP operation: addMailForward
     */
    public function addMailForward(
        string $domainName,
        string $source,
        string $destination,
    ): AddMailForwardResponse {
        return AddMailForwardResponse::fromWire($this->client->call('addMailForward', [
            'domainName' => $domainName,
            'source' => $source,
            'destination' => $destination,
        ]));
    }

    /**
     * This function will delete an existing mail forward using the supplied details
     *
     * SOAP operation: deleteMailForward
     */
    public function deleteMailForward(
        string $domainName,
        int $forwardID,
    ): DeleteMailForwardResponse {
        return DeleteMailForwardResponse::fromWire($this->client->call('deleteMailForward', [
            'domainName' => $domainName,
            'forwardID' => $forwardID,
        ]));
    }

    /**
     * This function will list all mail forwards using the supplied details
     *
     * SOAP operation: listMailForwards
     */
    public function listMailForwards(
        string $domainName,
    ): ListMailForwardsResponse {
        return ListMailForwardsResponse::fromWire($this->client->call('listMailForwards', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will add a simple url forward to the dns system
     *
     * SOAP operation: addSimpleURLForward
     */
    public function addSimpleURLForward(
        string $domainName,
        string $hostName,
        string $destination,
        string $type,
        string $pageTitle,
        string $metaKeywords,
        string $metaDescription,
        int $refreshSeconds,
        string $redirectMessage,
        ?bool $wildcardSource = null,
        ?bool $retainPath = null,
    ): AddSimpleURLForwardResponse {
        return AddSimpleURLForwardResponse::fromWire($this->client->call('addSimpleURLForward', [
            'domainName' => $domainName,
            'hostName' => $hostName,
            'destination' => $destination,
            'type' => $type,
            'pageTitle' => $pageTitle,
            'metaKeywords' => $metaKeywords,
            'metaDescription' => $metaDescription,
            'refreshSeconds' => $refreshSeconds,
            'redirectMessage' => $redirectMessage,
            'wildcardSource' => $wildcardSource,
            'retainPath' => $retainPath,
        ]));
    }

    /**
     * This function will get a list of all mail forwards for the specified domain name
     *
     * SOAP operation: getSimpleURLForwards
     */
    public function getSimpleURLForwards(
        string $domainName,
    ): GetSimpleURLForwardsResponse {
        return GetSimpleURLForwardsResponse::fromWire($this->client->call('getSimpleURLForwards', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will edit a URL forwarder in the system
     *
     * SOAP operation: editSimpleURLForward
     */
    public function editSimpleURLForward(
        string $domainName,
        string $recordID,
        ?string $source = null,
        ?string $destination = null,
    ): EditSimpleURLForwardResponse {
        return EditSimpleURLForwardResponse::fromWire($this->client->call('editSimpleURLForward', [
            'domainName' => $domainName,
            'recordID' => $recordID,
            'source' => $source,
            'destination' => $destination,
        ]));
    }

    /**
     * This function will delete a mail forward from the system
     *
     * SOAP operation: deleteSimpleURLForward
     */
    public function deleteSimpleURLForward(
        string $domainName,
        string $recordID,
    ): DeleteSimpleURLForwardResponse {
        return DeleteSimpleURLForwardResponse::fromWire($this->client->call('deleteSimpleURLForward', [
            'domainName' => $domainName,
            'recordID' => $recordID,
        ]));
    }

    /**
     * This function will list all of the email to sms forwarders for the reseller
     *
     * SOAP operation: listEmailToSMSForwarders
     */
    public function listEmailToSMSForwarders(): ListEmailToSMSForwardersResponse
    {
        return ListEmailToSMSForwardersResponse::fromWire($this->client->call('listEmailToSMSForwarders', []));
    }

    /**
     * This function will add a new email to sms forwarder for the reseller
     *
     * SOAP operation: addEmailToSMSForwarder
     */
    public function addEmailToSMSForwarder(
        string $sourceEmail,
        string $senderID,
    ): AddEmailToSMSForwarderResponse {
        return AddEmailToSMSForwarderResponse::fromWire($this->client->call('addEmailToSMSForwarder', [
            'sourceEmail' => $sourceEmail,
            'senderID' => $senderID,
        ]));
    }

    /**
     * This function will delete an email to sms forwarder
     *
     * SOAP operation: deleteEmailToSMSForwarder
     */
    public function deleteEmailToSMSForwarder(
        string $forwarderID,
    ): DeleteEmailToSMSForwarderResponse {
        return DeleteEmailToSMSForwarderResponse::fromWire($this->client->call('deleteEmailToSMSForwarder', [
            'forwarderID' => $forwarderID,
        ]));
    }
}
