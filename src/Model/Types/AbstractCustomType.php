<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\BadGetterException;
use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Exception\UnsupportableTypeException;
use SigmaNet\SDK\Utils\AccessorUtil;

abstract class AbstractCustomType
{
    /**
     * @var object
     */
    protected $object;

    /**
     * AbstractCustomType constructor.
     *
     * @param object $object
     *
     * @throws UnsupportableTypeException
     */
    public function __construct($object)
    {
        $this->object = $object;

        if (!$this->isAccept()) {
            throw new UnsupportableTypeException('Object does not support validation ');
        }
    }

    /**
     * @param string $field
     *
     * @return bool
     *
     * @throws BadGetterException
     * @throws InvalidPropertyException
     */
    abstract public function validate($field);

    /**
     * @return bool
     */
    abstract public function isAccept();

    /**
     * @return mixed
     */
    abstract public function getBaseType();

    /**
     * @param string $field
     *
     * @return mixed
     * @throws BadGetterException
     */
    protected function getValue($field)
    {
        $getter = $method = AccessorUtil::getter($field);

        if (!method_exists($this->object, $getter)) {
            $isser = $method = AccessorUtil::isser($field);

            if (!method_exists($this->object, $isser)) {
                throw new BadGetterException('Getter %s or %s for object does not exists', $getter, $isser);
            }
        }

        return $this->object->{$method}();
    }
}
