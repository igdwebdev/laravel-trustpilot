<?php
namespace IGD\Trustpilot\API\BusinessUnit\Review\Invitation;

use Carbon\Carbon;
use DateTime;
use IGD\Trustpilot\API\Api;
use IGD\Trustpilot\API\BusinessUnit\Review\Invitation\Template;
use IGD\Trustpilot\API\BusinessUnit\Review\Review;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class InvitationApi extends Api
{
    /**
     * The business unit id.
     *
     * @var int
     */
    public $businessUnitId = null;

    /**
     * Initialise the business unit reviews with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        parent::__construct();
        $this->businessUnitId = $businessUnitId ?? config('trustpilot.unit_id');
        $this->setPath('/private/business-units/' . $this->businessUnitId);
        $this->setEndpoint(config('trustpilot.endpoints.invitation'));
    }

    /**
     * Create the product review invite.
     *
     * @param array $products An array of product skus, or products
     * @param string $referenceId
     * @param string $customerName
     * @param string $customerEmail
     * @param string $replyTo
     * @param string $senderName
     * @param string $senderEmail
     * @param null|\DateTime $sendProductAt When to send the product review invite at. Note this must be after the send at.
     * @param null|\DateTime $sendAt When to send the service review invite at.
     * @param null|string $templateId
     * @param null|string $redirectUrl
     * @param array $tags
     * @param string $locale
     * @param null|string $locationId
     * @return void
     */
    public function products(array $products, string $referenceId,
        string $customerName, string $customerEmail, string $replyTo,
        string $senderName,
        ?string $senderEmail = null,
        ?DateTime $sendProductAt = null,
        ?DateTime $sendAt = null, ?string $templateId = null,
        ?string $redirectUrl = null, array $tags = [], string $locale = 'en-GB',
        ?string $locationId = null
    ): void {
        // Default send product at
        if ($sendProductAt == null) {
            $sendProductAt = $sendAt == null ? Carbon::now()->subDay() : $sendAt->copy()->addDay();
        }

        // Setup product review invitation array
        $productReviewInvitation = array_filter([
            'preferredSendTime' => $sendProductAt->format('Y-m-d\TH:i:s'),
            'redirectUri' => $redirectUrl,
            'templateId' => $templateId,
        ]);

        // Append products or product skus
        $productKey = 'productSkus';
        if (count($products) > 0) {
            if (Arr::isAssoc($products) || !is_string($products[0])) {
                $productKey = 'products';
                $products = collect($products)->map(function ($product) {
                    if (is_array($product)) {
                        return $product;
                    }
                    return $product->toArray();
                })->toArray();
            }
        }
        $productReviewInvitation[$productKey] = $products;

        $this->service(
            $referenceId, $customerName, $customerEmail, $replyTo, $senderName,
            $senderEmail, $sendAt, $templateId, $redirectUrl, $tags,
            $locale, $locationId, $productReviewInvitation
        );
    }

    /**
     * Create the service review invite.
     *
     * @param string $referenceId
     * @param string $customerName
     * @param string $customerEmail
     * @param string $replyTo
     * @param string $senderName
     * @param string $senderEmail
     * @param null|\DateTime $sendAt When to send the service review invite at.
     * @param null|string $templateId
     * @param null|string $redirectUrl
     * @param array $tags
     * @param string $locale
     * @param null|string $locationId
     * @param array $productReviewInvitation
     * @return void
     */
    public function service(string $referenceId, string $customerName,
        string $customerEmail, string $replyTo, string $senderName,
        ?string $senderEmail = null,
        ?DateTime $sendAt = null, ?string $templateId = null,
        ?string $redirectUrl = null, array $tags = [], string $locale = 'en-GB',
        ?string $locationId = null, array $productReviewInvitation = []
    ): void {
        // Default send at
        if ($sendAt == null) {
            $sendAt = Carbon::now()->subDays(2);
        }

        // Default sender email
        if ($senderEmail == null) {
            $senderEmail = 'noreply.invitations@trustpilotmail.com';
        }

        $this->post('/email-invitations', [], array_filter([
            'referenceNumber' => $referenceId,
            'consumerName' => $customerName,
            'consumerEmail' => $customerEmail,
            'senderName' => $senderName,
            'senderEmail' => $senderEmail,
            'replyTo' => $replyTo,
            'locale' => $locale,
            'locationId' => $locationId,
            'serviceReviewInvitation' => array_filter([
                'preferredSendTime' => $sendAt->format('Y-m-d\TH:i:s'),
                'redirectUri' => $redirectUrl,
                'tags' => $tags,
                'templateId' => $templateId,
            ]),
            'productReviewInvitation' => $productReviewInvitation,
        ]), true);
    }

    /**
     * Generate a review invitation link.
     *
     * @param string $referenceId
     * @param string $name
     * @param string $email
     * @param null|string $redirectUrl
     * @param array $tags
     * @param string $locale
     * @param null|string $locationId
     * @return string
     */
    public function generateLink(string $referenceId, string $name,
        string $email, ?string $redirectUrl = null, array $tags = [],
        string $locale = 'en-GB', ?string $locationId = null
    ): string {
        return $this->post('/invitation-links', [], array_filter([
            'referenceId' => $referenceId,
            'name' => $name,
            'email' => $email,
            'redirectUri' => $redirectUrl,
            'tags' => $tags,
            'locale' => $locale,
            'locationId' => $locationId,
        ]), true)->url;
    }

    /**
     * Delete all information data related to the e-mails.
     *
     * @param array $emails
     * @return void
     */
    public function deleteByEmails(array $emails): void
    {
        $this->post('/invitation-data/delete', [], [
            'customerEmails' => $emails,
        ], true);
    }

    /**
     * Delete all information data before the given date.
     *
     * @param \DateTime $date
     * @return void
     */
    public function deleteBeforeDate(DateTime $date): void
    {
        $this->post('/invitation-data/delete', [], [
            'deleteOlderThan' => $date->format('Y-m-d\TH:i:s'),
        ], true);
    }

    /**
     * Get a list of invitation templates.
     *
     * @return \Illuminate\Support\Collection
     */
    public function templates(): Collection
    {
        $response = $this->get('/templates', [], true);
        return collect($response->templates)->map(function ($template) {
            return (new Template())->data($template);
        });
    }
}
