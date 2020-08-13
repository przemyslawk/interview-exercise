<?php namespace Tests\UnitTest;

use AppJobs\Entities\Offer\Entity as Offer;
use AppJobs\Entities\Requirements\Collection;
use AppJobs\Repositories\Offers\RepositoryInterface;
use AppJobs\Services\OfferService;
use PHPUnit\Framework\TestCase;
use AppJobs\Entities\Requirements\Entity as Requirement;

class OfferServiceTest extends TestCase
{
    /** @var OfferService */
    private $service;

    public function setUp()
    {
        $offerRepository = \Mockery::mock(RepositoryInterface::class);
        $this->service = \Mockery::mock(OfferService::class, [$offerRepository])->makePartial();

        $data = $this->getMockOffers();
        $offerRepository->shouldReceive('getOffers')->andReturn($data);
    }

    /**
     * @param $assets
     * @param $expected
     * @dataProvider dataProvider
     */
    public function testGetMatches($assets, $expected)
    {
        $matches = $this->service->getMatches($assets);
        foreach ($expected as $index => $expect) {
            $this->assertEquals($expect, $matches[$index]->getName());
        }
    }

    /***
     * @return array
     */
    private function getMockOffers(): array
    {
        return [
            new Offer(
                'Company A',
                new Collection([
                    new Collection([
                        new Requirement('an apartment'),
                        new Requirement('a house'),
                    ], Collection::OR_TYPE),
                    new Requirement('property insurance'),
                ], Collection::AND_TYPE)
            ),
            new Offer(
                'Company B',
                new Collection([
                    new Collection([
                        new Requirement('5 door car'),
                        new Requirement('4 door car'),
                    ], Collection::OR_TYPE),
                    new Requirement('a driver\'s license'),
                    new Requirement('car insurance'),
                ], Collection::AND_TYPE)
            ),
            new Offer(
                'Company C',
                new Collection([
                    new Requirement('a social security number'),
                    new Requirement('a work permit'),
                ], Collection::AND_TYPE)
            ),
            new Offer(
                'Company D',
                new Collection([
                    new Requirement('an apartment'),
                    new Requirement('a flat'),
                    new Requirement('a house'),
                ], Collection::OR_TYPE)
            ),
            new Offer(
                'Company E',
                new Collection([
                    new Requirement('a driver\'s license'),
                    new Collection([
                        new Requirement('2 door car'),
                        new Requirement('3 door car'),
                        new Requirement('4 door car'),
                        new Requirement('5 door car'),
                    ], Collection::OR_TYPE),
                ], Collection::AND_TYPE)
            ),
            new Offer(
                'Company F',
                new Collection([
                    new Requirement('a scooter'),
                    new Requirement('a bike'),
                    new Collection([
                        new Requirement('a motorcycle'),
                        new Requirement('a driver\'s license'),
                        new Requirement('motorcycle insurance'),
                    ], Collection::AND_TYPE),
                ], Collection::OR_TYPE)
            ),
            new Offer(
                'Company G',
                new Collection([
                    new Requirement('a massage qualification certificate'),
                    new Requirement('a liability insurance'),
                ], Collection::AND_TYPE)
            ),
            new Offer(
                'Company H',
                new Collection([
                    new Requirement('a storage place'),
                    new Requirement('a garage'),
                ], Collection::OR_TYPE)
            ),
            new Offer(
                'Company J',
                new Collection([
                    new Requirement('')
                ], Collection::OR_TYPE)
            ),
            new Offer(
                'Company K',
                new Collection([
                    new Requirement('a PayPal account')
                ], Collection::OR_TYPE)
            ),
        ];
    }


    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [
                ['a house', 'property insurance'],
                ['Company A', 'Company D', 'Company J']
            ],
            [
                ['a driver\'s license', '5 door car', 'car insurance'],
                ['Company B', 'Company E', 'Company J']
            ],
            [
                ['a social security number', 'a work permit'],
                ['Company C', 'Company J']
            ],
            [
                ['a flat'],
                ['Company D', 'Company J']
            ],
            [
                ['a driver\'s license', '2 door car'],
                ['Company E', 'Company J']
            ],
            [
                ['a motorcycle', 'a driver\'s license', 'motorcycle insurance'],
                ['Company F', 'Company J']
            ],
            [
                ['a massage qualification certificate', 'a liability insurance'],
                ['Company G', 'Company J']
            ],
            [
                ['a storage place'],
                ['Company H', 'Company J']
            ],
            [
                [''], ['Company J']
            ],
            [
                ['a PayPal account'],
                ['Company J', 'Company K']
            ],
            [
                ['a driver\'s license', 'a bike'],
                ['Company F', 'Company J']
            ],
        ];
    }
}
