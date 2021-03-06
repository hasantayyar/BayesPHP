<?php

namespace BayesPHP;

/**
 * Test class for Stemer.
 * Generated by PHPUnit on 2011-05-25 at 13:23:38.
 */
class StemerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Stemer
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Stemer;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testLowerCasingOn()
    {
        $this->object->setLowerCasing(true);

        $string = 'loWER case THIS';

        $stemedString = $this->object->process($string);

        $this->assertEquals('lower case this', $stemedString);
    }

    public function testLowerCasingOff()
    {
        $this->object->setLowerCasing(false);

        $string = 'loWER case THIS';

        $stemedString = $this->object->process($string);

        $this->assertEquals('loWER case THIS', $stemedString);
    }

    public function testLowerCasingUnicode()
    {
        $string = "Τάχιστη";
    
        $stemedString = $this->object->process($string);

        $this->assertEquals('τάχιστη', $stemedString);
    }

    public function punctuationProvider()
    {
        return array(
            array('simple!, removal-', 'simple removal', array('-', '!', ',')),
            array('simple!!!!, removal-', 'simple removal', array('-', '!', ',')),
            array('middle of a w-!or@d', 'middle of a word', array('-', '!', '@')),
            array('multi characters: :)', 'multi characters: ', array(':)') ),
            array('multi characters: :)', 'multi characters ', array(':)', ':')),
            array('multi characters: :)', 'multi characters ', array(':', ':)'))
        );
    }

    /**
     * @dataProvider punctuationProvider
     */
    public function testPunctuationRemoveOn($originalStr, $expectedStr, array $punctuation)
    {
        $this->object->setPunctuation($punctuation);

        $stemedString = $this->object->process($originalStr);

        $this->assertEquals($expectedStr, $stemedString);
    }

    public function testPunctuationRemoveOff()
    {
        $originalStr = '!!no way!!';

        $stemedString = $this->object->process($originalStr);

        $this->assertEquals($stemedString, $originalStr);
    }

    public function trimmingProvider()
    {
        return array(
            array(' left trim', 'left trim'),
            array('middle    trim', 'middle trim'),
            array('right trim  ', 'right trim'),
            array('  lots   of different   types  of trim ', 'lots of different types of trim')
        );
    }

    /**
     *@dataProvider trimmingProvider
     */
    public function testTrimming($originalStr, $expectedStr)
    {
        $stemedStr = $this->object->process($originalStr);

        $this->assertEquals($expectedStr, $stemedStr);
    }

    public function testRemoveWords()
    {
        $blacklist = array('I', 'he', 'you');
        
        $this->object->setWordBlacklist($blacklist);

        $sample = 'I hate that he loves you';

        $stemedResult = $this->object->process($sample);
        
        $this->assertEquals('hate that loves', $stemedResult);

    }

}

?>
