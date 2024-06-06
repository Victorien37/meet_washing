<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\VehiculeType;

class VehiculeTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cat_a = new VehiculeType();
        $cat_a->setCategory('A');
        $cat_a->setName('mini citadine');

        $cat_b = new VehiculeType();
        $cat_b->setCategory('B');
        $cat_b->setName('citadine');

        $cat_c = new VehiculeType();
        $cat_c->setCategory('C');
        $cat_c->setName('compacte');

        $cat_d = new VehiculeType();
        $cat_d->setCategory('D');
        $cat_d->setName('familiale');

        $cat_e = new VehiculeType();
        $cat_e->setCategory('E');
        $cat_e->setName('berline');

        $cat_f = new VehiculeType();
        $cat_f->setCategory('F');
        $cat_f->setName('luxe');

        $cat_j = new VehiculeType();
        $cat_j->setCategory('J');
        $cat_j->setName('suv');

        $cat_m = new VehiculeType();
        $cat_m->setCategory('M');
        $cat_m->setName('monospace');

        $cat_s = new VehiculeType();
        $cat_s->setCategory('S');
        $cat_s->setName('sport');

        $vehicule_types = [$cat_a, $cat_b, $cat_c, $cat_d, $cat_e, $cat_f, $cat_j, $cat_m, $cat_s];
        foreach ($vehicule_types as $vehicule_type) {
            $manager->persist($vehicule_type);
        }
        $manager->flush();
        
    }
}
