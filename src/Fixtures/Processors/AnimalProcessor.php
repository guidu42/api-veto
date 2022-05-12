<?php

namespace App\Fixtures\Processors;


use App\Entity\Animal;
use Fidry\AliceDataFixtures\ProcessorInterface;
use function PHPUnit\Framework\isEmpty;

class AnimalProcessor implements ProcessorInterface
{

    public function preProcess(string $id, $object): void
    {
        if(!($object instanceof Animal)){
            return;
        }
//        $allBreeds = $object->getSpecies()->getBreeds()->toArray();
//        if(!isEmpty($allBreeds)){
//            $breeds = array_rand($allBreeds, rand(1, count($allBreeds)));
//            foreach ($breeds as $breed){
//                $object->addBreed($breed);
//            }
//        }
        dump($object);
    }

    public function postProcess(string $id, $object): void
    {
        if(!($object instanceof Animal)){
            return;
        }
        $allBreeds = $object->getSpecies()->getBreeds()->toArray();
        if(!isEmpty($allBreeds)){
            $breeds = array_rand($allBreeds, rand(1, count($allBreeds)));
            foreach ($breeds as $breed){
                $object->addBreed($breed);
            }
        }
    }
}