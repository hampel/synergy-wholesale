<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\SslcancelSSLCertificateResponse;
use Hampel\SynergyWholesale\Generated\Response\SslcheckDomainBeaconResponse;
use Hampel\SynergyWholesale\Generated\Response\SslcheckTxtCodesResponse;
use Hampel\SynergyWholesale\Generated\Response\SsldecodeCSRResponse;
use Hampel\SynergyWholesale\Generated\Response\SslgenerateCSRResponse;
use Hampel\SynergyWholesale\Generated\Response\SslgetCertSimpleStatusResponse;
use Hampel\SynergyWholesale\Generated\Response\SslgetCertStatusResponse;
use Hampel\SynergyWholesale\Generated\Response\SslgetDomainBeaconResponse;
use Hampel\SynergyWholesale\Generated\Response\SslgetSSLCertificateResponse;
use Hampel\SynergyWholesale\Generated\Response\SsllistAllCertsResponse;
use Hampel\SynergyWholesale\Generated\Response\SslpurchaseSSLCertificateResponse;
use Hampel\SynergyWholesale\Generated\Response\SslreissueCertificateResponse;
use Hampel\SynergyWholesale\Generated\Response\SslrenewSSLCertificateResponse;
use Hampel\SynergyWholesale\Generated\Response\SslresendDVEmailResponse;
use Hampel\SynergyWholesale\Generated\Response\SslresendIssuedCertificateEmailResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function will decode the supplied csr and return the csr details
     *
     * SOAP operation: SSL_decodeCSR
     */
    public function decodeCSR(
        string $csr,
    ): SsldecodeCSRResponse {
        return SsldecodeCSRResponse::fromWire($this->client->call('SSL_decodeCSR', [
            'csr' => $csr,
        ]));
    }

    /**
     * This function will get the specified certificate details
     *
     * SOAP operation: SSL_getSSLCertificate
     */
    public function getSSLCertificate(
        string $certID,
    ): SslgetSSLCertificateResponse {
        return SslgetSSLCertificateResponse::fromWire($this->client->call('SSL_getSSLCertificate', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function will get the specified certificate status in advanced format
     *
     * SOAP operation: SSL_getCertStatus
     */
    public function getCertStatus(
        string $certID,
    ): SslgetCertStatusResponse {
        return SslgetCertStatusResponse::fromWire($this->client->call('SSL_getCertStatus', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function will get the certificates current status in simple format
     *
     * SOAP operation: SSL_getCertSimpleStatus
     */
    public function getCertSimpleStatus(
        string $certID,
    ): SslgetCertSimpleStatusResponse {
        return SslgetCertSimpleStatusResponse::fromWire($this->client->call('SSL_getCertSimpleStatus', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function will resend the issued certificate email
     *
     * SOAP operation: SSL_resendIssuedCertificateEmail
     */
    public function resendIssuedCertificateEmail(
        string $certID,
    ): SslresendIssuedCertificateEmailResponse {
        return SslresendIssuedCertificateEmailResponse::fromWire($this->client->call('SSL_resendIssuedCertificateEmail', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function will resend the domain-verified confirmation email
     *
     * SOAP operation: SSL_resendDVEmail
     */
    public function resendDVEmail(
        string $certID,
    ): SslresendDVEmailResponse {
        return SslresendDVEmailResponse::fromWire($this->client->call('SSL_resendDVEmail', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function purchases an ssl certificate
     *
     * SOAP operation: SSL_purchaseSSLCertificate
     */
    public function purchaseSSLCertificate(
        string $privateKey,
        string $csr,
        string $productID,
        string $firstName,
        string $lastName,
        string $emailAddress,
        string $address,
        string $city,
        string $state,
        string $postCode,
        string $country,
        string $phone,
        string $fax,
        ?string $registrationNumber = null,
        ?string $businessCategory = null,
    ): SslpurchaseSSLCertificateResponse {
        return SslpurchaseSSLCertificateResponse::fromWire($this->client->call('SSL_purchaseSSLCertificate', [
            'privateKey' => $privateKey,
            'csr' => $csr,
            'productID' => $productID,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'emailAddress' => $emailAddress,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'postCode' => $postCode,
            'country' => $country,
            'phone' => $phone,
            'fax' => $fax,
            'registrationNumber' => $registrationNumber,
            'businessCategory' => $businessCategory,
        ]));
    }

    /**
     * This function renews an ssl certificate
     *
     * SOAP operation: SSL_renewSSLCertificate
     */
    public function renewSSLCertificate(
        string $certID,
        string $firstName,
        string $lastName,
        string $emailAddress,
        string $address,
        string $city,
        string $state,
        string $postCode,
        string $country,
        string $phone,
        string $fax,
    ): SslrenewSSLCertificateResponse {
        return SslrenewSSLCertificateResponse::fromWire($this->client->call('SSL_renewSSLCertificate', [
            'certID' => $certID,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'emailAddress' => $emailAddress,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'postCode' => $postCode,
            'country' => $country,
            'phone' => $phone,
            'fax' => $fax,
        ]));
    }

    /**
     * This function will cancel and refund any eligible ssl certs / orders
     *
     * SOAP operation: SSL_cancelSSLCertificate
     */
    public function cancelSSLCertificate(
        string $certID,
    ): SslcancelSSLCertificateResponse {
        return SslcancelSSLCertificateResponse::fromWire($this->client->call('SSL_cancelSSLCertificate', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function will reissue a ssl certificate
     *
     * SOAP operation: SSL_reissueCertificate
     */
    public function reissueCertificate(
        string $certID,
        string $newCSR,
    ): SslreissueCertificateResponse {
        return SslreissueCertificateResponse::fromWire($this->client->call('SSL_reissueCertificate', [
            'certID' => $certID,
            'newCSR' => $newCSR,
        ]));
    }

    /**
     * This function will get the domain beacon for the certificate
     *
     * SOAP operation: SSL_getDomainBeacon
     */
    public function getDomainBeacon(
        string $certID,
        string $domainName,
    ): SslgetDomainBeaconResponse {
        return SslgetDomainBeaconResponse::fromWire($this->client->call('SSL_getDomainBeacon', [
            'certID' => $certID,
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will check the domain beacon at trustwave
     *
     * SOAP operation: SSL_checkDomainBeacon
     */
    public function checkDomainBeacon(
        string $certID,
        string $domainName,
    ): SslcheckDomainBeaconResponse {
        return SslcheckDomainBeaconResponse::fromWire($this->client->call('SSL_checkDomainBeacon', [
            'certID' => $certID,
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will return all the currently stored ssls
     *
     * SOAP operation: SSL_listAllCerts
     */
    public function listAllCerts(): SsllistAllCertsResponse
    {
        return SsllistAllCertsResponse::fromWire($this->client->call('SSL_listAllCerts', []));
    }

    /**
     * This function will check the DNS beacon at trustwave
     *
     * SOAP operation: SSL_checkTxtCodes
     */
    public function checkTxtCodes(
        string $certID,
    ): SslcheckTxtCodesResponse {
        return SslcheckTxtCodesResponse::fromWire($this->client->call('SSL_checkTxtCodes', [
            'certID' => $certID,
        ]));
    }

    /**
     * This function will return a csr, private key and self signed certificate
     *
     * @param list<string>|null $subjectAltNames
     *
     * SOAP operation: SSL_generateCSR
     */
    public function generateCSR(
        int $numOfYears,
        string $country,
        string $state,
        string $city,
        string $organisation,
        string $organisationUnit,
        string $commonName,
        string $emailAddress,
        ?array $subjectAltNames = null,
        ?int $privateKeyLength = null,
    ): SslgenerateCSRResponse {
        return SslgenerateCSRResponse::fromWire($this->client->call('SSL_generateCSR', [
            'numOfYears' => $numOfYears,
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'organisation' => $organisation,
            'organisationUnit' => $organisationUnit,
            'commonName' => $commonName,
            'emailAddress' => $emailAddress,
            'subjectAltNames' => $subjectAltNames,
            'privateKeyLength' => $privateKeyLength,
        ]));
    }
}
