<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dontdrinkandroot\RestBundle\Metadata\Annotation as REST;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @REST\RootResource(
 *     controller="DomainBundle\Controller\UserController",
 *     methods= {
 *         @REST\Method(name="LIST", right=@REST\Right({"ROLE_ADMIN"})),
 *         @REST\Method(name="GET"),
 *     }
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
