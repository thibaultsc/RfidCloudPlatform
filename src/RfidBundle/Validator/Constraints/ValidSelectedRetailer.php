<?php
namespace RfidBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
/**
 * Validates that the current user is able to select the given retailer.
 *
 * @Annotation
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
class ValidSelectedRetailer extends Constraint
{
    public $message = 'You are not authorized to select this retailer.';
    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    public function validatedBy()
    {
        return 'valid_selected_retailer';
    }
}