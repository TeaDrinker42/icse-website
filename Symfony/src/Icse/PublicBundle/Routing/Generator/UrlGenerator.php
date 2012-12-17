<?php 
namespace Icse\PublicBundle\Routing\Generator;
// Taken from http://stackoverflow.com/questions/8877806/symfony2-use-object-to-set-route-parameters/9016324#9016324 
 
use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;
 
use Doctrine\Common\Util\Inflector;
 
/**
 * UrlGenerator generates URL based on a set of routes.
 *
 * @api
 */
class UrlGenerator extends BaseUrlGenerator
{
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute)
    {
        if (is_object($parameters)) {
            $object = $parameters;
            $parameters = array();
        }
 
        if (isset($parameters['object']) && is_object($parameters['object'])) {
            $object = $parameters['object'];
        }
 
        if (isset($object)) {
            $parameters = $this->getParametersFromObject($variables, $object);
        }
 
        return parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute);
    }
 
    protected function getParametersFromObject($keys, $object)
    {
        $parameters = array();
 
        foreach ($keys as $key) {
            $relation = $object;
 
            $method = 'get' . Inflector::classify($key);
 
            if (method_exists($relation, $method)) {
                $relation = $relation->$method();
            } else {
                $segments = explode('_', $key);
 
                if (count($segments) > 1) {
                    foreach ($segments as $segment) {
                        $method = 'get' . Inflector::classify($segment);
 
                        if (method_exists($relation, $method)) {
                            $relation = $relation->$method();
                        } else {
                            $relation = $object;
                            break;
                        }
                    }
                }
            }
 
            if ($object !== $relation) {
                $parameters[$key] = $relation;
            }
        }
 
        return $parameters;
    }
}