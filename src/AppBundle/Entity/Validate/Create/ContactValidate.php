<?php

namespace AppBundle\Entity\Validate\Create;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContactValidate
 */
class ContactValidate
{

    /**
     * @var string
     *
     * @Assert\NotBlank(message="The Contact name is required.")
     * @Assert\Type(
     *     type="string",
     *     message="The value of Contact name ({{ value }}) is not a valid {{ type }}."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Your Contact name must be at least {{ limit }} characters long",
     *      maxMessage = "Your Contact name cannot be longer than {{ limit }} characters"
     * )
     *
     * @Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="The Contact email is required.")
     * @Assert\Email(
     *     message = "The email value ({{ value }}) is not valid.",
     *     checkMX = true
     * )
     *
     * @Type("string")
     */
    private $email;


    /**
     * @var string
     *
     * @Assert\NotBlank(message="The Contact Phone is required.")
     * @Assert\Type(
     *     type="string",
     *     message="The value of Contact Phone ({{ value }}) is not a valid {{ type }}."
     * )
     *
     * @Type("string")
     */
    private $phone;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }
}
