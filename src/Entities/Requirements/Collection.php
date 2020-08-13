<?php
declare(strict_types=1);

namespace AppJobs\Entities\Requirements;

class Collection implements RequirementInterface
{
    const OR_TYPE = 'OR';
    const AND_TYPE = 'AND';

    /** @var RequirementInterface[] */
    private $requirements;

    /** @var string */
    private $type;

    /**
     * Collection constructor.
     * @param array $requirements
     * @param string $type
     */
    public function __construct(array $requirements, string $type)
    {
        $this->requirements = $requirements;
        $this->type = $type;
    }

    /**
     * @param array $assets
     * @return bool
     */
    public function isValid(array $assets): bool
    {
        foreach ($this->requirements as $requirement) {
            $valid = $requirement->isValid($assets);
            if ($valid && $this->type === self::OR_TYPE) {
                return true;
            }

            if (!$valid && $this->type === self::AND_TYPE) {
                return false;
            }
        }

        if ($this->type === self::OR_TYPE) {
            return false;
        }

        return true;
    }
}
