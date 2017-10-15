<?php

namespace DomainBundle\Entity;

use Dontdrinkandroot\RestBundle\Metadata\Annotation as REST;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @REST\RootResource()
 * @ORM\Entity(repositoryClass="Dontdrinkandroot\Service\DoctrineCrudService")
 *
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
