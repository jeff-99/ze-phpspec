<?php


namespace ZEPHPSpec\Matcher;

use function class_exists;
use function get_class;
use function is_string;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\BasicMatcher;
use PhpSpec\Matcher\Matcher;
use Psr\Http\Message\ResponseInterface;

class ResponseMatcher extends BasicMatcher
{
    private $presenter;

    /**
     * Keys constructor.
     * @param $presenter
     */
    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }


    public function supports($name, $subject, array $arguments)
    {
        return $name === 'returnResponse'
            && count($arguments) === 3
            && class_exists($arguments[0]
            && is_int($arguments[1])
        );
    }


    protected function matches($subject, array $arguments)
    {
        list($expectedType, $expectedStatusCode, $expectedBody) = $arguments;

        if(!$subject instanceof ResponseInterface){
            return false;
        }

        if(!$subject instanceof $expectedType){
            return false;
        }

        if($subject->getStatusCode() !== $expectedStatusCode){
            return false;
        }

        if($subject->getBody() !== $expectedBody){
            return false;
        }

        return true;
    }


    protected function getFailureException($name, $subject, array $arguments)
    {
        return new FailureException(sprintf(
            'Expected %s to contain the following parameters %s, but it does not.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments)
        ));
    }

    protected function getNegativeFailureException($name, $subject, array $arguments)
    {
        return new FailureException(sprintf(
            'Expected %s to NOT the following parameters %s, but it does.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments)
        ));
    }
}

