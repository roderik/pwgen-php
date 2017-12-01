<?php

namespace PWGen\Tests;

use PWGen\PWGen;
use PHPUnit\Framework\TestCase;

class PWGenTest extends TestCase
{
    public function testConstruct()
    {
        $pwgen = new PWGen();
        $this->assertInstanceOf('PWGen\\PWGen', $pwgen);
    }

    public function testSetAmbiguous()
    {
        $pwgen = new PWGen();
        $pwgen->setAmbiguous(true);
        $this->assertTrue($pwgen->hasAmbiguous());
    }

    public function testSetCapitalize()
    {
        $pwgen = new PWGen();
        $pwgen->setCapitalize(true);
        $this->assertTrue($pwgen->hasCapitalize());
    }

    // TODO: add more tests for set length (<5, <2 and <1)
    public function testSetLength()
    {
        $pwgen = new PWGen();
        $pwgen->setLength(20);
        $this->assertEquals(20, $pwgen->getLength());
    }

    public function testSetNoVovels()
    {
        $pwgen = new PWGen();
        $pwgen->setNoVovels(true);
        $this->assertTrue($pwgen->hasNoVovels());
    }

    public function testSetNumerals()
    {
        $pwgen = new PWGen();
        $pwgen->setNumerals(true);
        $this->assertTrue($pwgen->hasNumerals());
    }

    public function testSetSecure()
    {
        $pwgen = new PWGen();
        $pwgen->setSecure(true);
        $this->assertTrue($pwgen->isSecure());
    }

    public function testSetSymbols()
    {
        $pwgen = new PWGen();
        $pwgen->setSymbols(true);
        $this->assertTrue($pwgen->hasSymbols());
    }

    public function testGenerateSecure()
    {
        $pwgen = new PWGen(20, true);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->isSecure());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertRegExp('/[A-Z]/', $pass); // Alpha upper
        $this->assertRegExp('/\\d/', $pass); // Numerals
    }

    public function testGenerateNumerals()
    {
        $pwgen = new PWGen(20, false, true);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->hasNumerals());
        $this->assertTrue($pwgen->hasCapitalize());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertRegExp('/[A-Z]/', $pass); // Alpha upper
        $this->assertRegExp('/\\d/', $pass); // Numerals
    }

    public function testGenerateNumeralsNoUppers()
    {
        $pwgen = new PWGen(20, false, true, false);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->hasNumerals());
        $this->assertFalse($pwgen->hasCapitalize());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertNotRegExp('/[A-Z]/', $pass); // Alpha NOT upper
        $this->assertRegExp('/\\d/', $pass); // Numerals
    }

    public function testGenerateCapitalize()
    {
        $pwgen = new PWGen(20, false, false, true);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->hasCapitalize());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertRegExp('/[A-Z]/', $pass); // Alpha upper
        $this->assertNotRegExp('/[\\d]/', $pass); // NO numerals!
    }

    public function testGenerateAmbiguous()
    {
        $pwgen = new PWGen(20, false, false, true, true);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->hasAmbiguous());
        $this->assertTrue($pwgen->hasCapitalize());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertRegExp('/[A-Z]/', $pass); // Alpha NOT upper
        $this->assertNotRegExp('/[\\d]/', $pass); // NO numerals!
    }

    public function testGenerateNoVovels()
    {
        $pwgen = new PWGen(20, false, false, false, false, true);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->hasNoVovels());
        $this->assertTrue($pwgen->hasNumerals());
        $this->assertTrue($pwgen->hasCapitalize());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertRegExp('/[A-Z]/', $pass); // Alpha upper
        $this->assertRegExp('/[\\d]/', $pass); // numerals
        $this->assertNotRegExp('/[' . preg_quote($pwgen->getVovels(), '/') . ']/', $pass); // No Vovels
    }

    public function testGenerateSymbols()
    {
        $pwgen = new PWGen(20, false, false, false, false, false, true);

        $this->assertEquals(20, $pwgen->getLength());
        $this->assertTrue($pwgen->hasSymbols());

        $pass = $pwgen->generate();

        $this->assertTrue(is_string($pass));
        $this->assertEquals(20, strlen($pass));
        $this->assertRegExp('/[a-z]/', $pass); // Alpha lower
        $this->assertNotRegExp('/[A-Z]/', $pass); // Alpha NOT upper
        $this->assertNotRegExp('/[\\d]/', $pass); // NO numerals!
        $this->assertRegExp('/[' . preg_quote($pwgen->getSymbols(), '/') . ']/', $pass); // Symbols
    }

    // TODO: ALL possible combinations should be tested!!!
}
