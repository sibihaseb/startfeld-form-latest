<?php


if (!function_exists('generateRandomKey')) {
    /**
     * Generate random key
     *
     * @return string
     *
     * @throws Exception
     */
    function generateRandomKey()
    {
        $permittedCharacters = 'abcdefghijklmnpqrstuvwxyz0123456789';
        $permittedCharactersLength = strlen($permittedCharacters);

        $randomStringLength = 9;
        $randomString = '';
        for ($i = 0; $i < $randomStringLength; $i++) {
            $randomCharacter = $permittedCharacters[random_int(0, $permittedCharactersLength - 1)];
            $randomString .= $randomCharacter;
        }

        return $randomString;
    }
}
