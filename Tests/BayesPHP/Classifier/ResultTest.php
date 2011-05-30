<?php

namespace BayesPHP\Classifier;

require_once dirname(__FILE__) . '/../../../BayesPHP/Classifier/Result.php';

/**
 * Test class for Result.
 * Generated by PHPUnit on 2011-05-30 at 00:46:27.
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Result
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Result('Test String', 0.07, 0.87);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    public function testGetProbabilitiesBoth()
    {
        $result = $this->object->getProbabilities(Result::RESULT_BOTH);

        $this->assertEquals(array('p' => 0.07, 'n' => 0.87), $result);
    }

    public function testGetProbabilitiesPositive()
    {
        $result = $this->object->getProbabilities(Result::RESULT_POSITIVE);

        $this->assertEquals(0.07, $result);
    }

    public function testGetProbabilitiesNegative()
    {
        $result = $this->object->getProbabilities(Result::RESULT_NEGATIVE);

        $this->assertEquals(0.87, $result);
    }

    /**
     * @expectedException \BayesPHP\Exception\BadArgument
     */
    public function testGetProbabilitiesBadArg()
    {
        $result = $this->object->getProbabilities(85);
    }


    public function resultProvider()
    {
        return array(
            array(0.2, 0.71, Result::RESULT_TYPE_NEG),
            array(0.71, 0.2, Result::RESULT_TYPE_POS),
            array(0.8, 0.8, Result::RESULT_TYPE_INCONCLUSIVE),
        );
    }

    /**
     * @dataProvider resultProvider
     */
    public function testGetResult($pos, $neg, $expected)
    {
        $result = new Result('Test Sample', $pos, $neg);

        $this->assertEquals($expected, $result->getResult());
    }


    public function resultThresholdProvider()
    {
        return array(
            array(0.69, 0.69, Result::RESULT_TYPE_INCONCLUSIVE),
            array(0.69, 0.5, Result::RESULT_TYPE_INCONCLUSIVE),
        );
    }

    /**
     * @dataProvider resultThresholdProvider
     */
    public function testGetResultThreshold($pos, $neg, $expected)
    {
        $result = new Result('Test Sample', $pos, $neg);

        $this->assertEquals($expected, $result->getResult());      
    }


}

?>
