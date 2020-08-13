<?php

declare(strict_types=1);

namespace AppJobs\Services;

use AppJobs\Repositories\Offers\RepositoryInterface;

class OfferService
{
    /** @var RepositoryInterface */
    private $offerRepository;

    /**
     * OfferService constructor.
     * @param RepositoryInterface $offerRepository
     */
    public function __construct(RepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @param array $assets
     * @return array
     */
    public function getMatches(array $assets): array
    {
        $offers = [];

        foreach ($this->getOffers() as $offer) {
            $requirements = $offer->getRequirements();

            if ($requirements->isValid($assets)) {
                $offers[] = $offer;
            }
        }

        return $offers;
    }

    /**
     * @return array
     */
    private function getOffers(): array
    {
        return $this->offerRepository->getOffers();
    }
}
