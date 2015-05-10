<?php
/**
 * Inteface for the files
 *
 */

interface CoffeeCircleFilesInterface
{

    /**
     * This function most to be in all the proccess
     * but maybe with different validations.
     * @param array $file
     * @return mixed
     */
    public function validateFile(Array $file);

}
