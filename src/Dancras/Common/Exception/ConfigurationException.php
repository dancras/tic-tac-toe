<?php

namespace Dancras\Common\Exception;

use LogicException;

/**
 * Use this to indicate a misconfiguration. Occurences of this exception should require changes to
 * the code, the composition of dependencies, or configuration values.
 */
class ConfigurationException extends LogicException
{
    const FQCN = '\Dancras\Common\Exception\ConfigurationException';
}
