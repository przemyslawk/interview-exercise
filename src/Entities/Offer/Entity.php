<?php

declare(strict_types=1);

namespace AppJobs\Entities\Offer;

use AppJobs\Entities\Requirements\Collection;

class Entity
{
    /** @var string */
    private $name;

    /** @var Collection */
    private $requirements;

    /**
     * Entity constructor.
     * @param string $name
     * @param array $requirements
     */
    public function __construct(string $name, Collection $requirements)
    {
        $this->name = $name;
        $this->requirements = $requirements;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getRequirements(): Collection
    {
        return $this->requirements;
    }
}
