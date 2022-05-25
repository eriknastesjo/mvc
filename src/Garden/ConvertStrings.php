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
    public function fromSwe(
        String $string
    ): String {

        $stringTest = "ernä";

        $RemoveChars[] = '/å/';
        $RemoveChars[] = '/ä/';
        $RemoveChars[] = '/ö/';
        $RemoveChars[] = '/Å/';
        $RemoveChars[] = '/Ä/';
        $RemoveChars[] = '/Ö/';

        $ReplaceWith[] = 'a';
        $ReplaceWith[] = 'a';
        $ReplaceWith[] = 'o';
        $ReplaceWith[] = 'A';
        $ReplaceWith[] = 'A';
        $ReplaceWith[] = 'O';

        $acronymNameDecoded  = preg_replace($RemoveChars, $ReplaceWith, $string);

        return $acronymNameDecoded;
    }

}
