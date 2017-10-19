<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dontdrinkandroot\RestBundle\Metadata\Annotation as REST;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @REST\RootResource(
 *     controller="DomainBundle:User",
 *     methods="{'GET', 'LIST'}",
 *     listRight=@REST\Right(expression="has_role('ROLE_ADMIN')")
 * )
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
