<?php

/**
 * Module with ConvertStrings class.
 */

namespace App\Garden;

/**
 * Holds methods to convert strings
 */
class ConvertStrings
{
    /**
     * Adds a new row to the table User. Return the entity of the row.
     */
    public function createAcronym(
        string $firstName,
        string $lastName
    ): string {
        $newAcronym = substr($this->fromSwe(strtolower($firstName)), 0, 2)
            . substr($this->fromSwe(strtolower($lastName)), 0, 2);

        return $newAcronym;
    }
    /**
     * Adds a new row to the table User. Return the entity of the row.
     */
    private function fromSwe(
        string $string
    ): string {
        $removeChars = [];
        $removeChars[] = '/å/';
        $removeChars[] = '/ä/';
        $removeChars[] = '/ö/';
        $removeChars[] = '/Å/';
        $removeChars[] = '/Ä/';
        $removeChars[] = '/Ö/';

        $replaceWith = [];
        $replaceWith[] = 'a';
        $replaceWith[] = 'a';
        $replaceWith[] = 'o';
        $replaceWith[] = 'A';
        $replaceWith[] = 'A';
        $replaceWith[] = 'O';

        $acronymNameDecoded  = preg_replace($removeChars, $replaceWith, $string);

        return $acronymNameDecoded;
    }
}
