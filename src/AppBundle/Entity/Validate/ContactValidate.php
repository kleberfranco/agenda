<?php

namespace AppBundle\Entity\Validate;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CreateContactValidate
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
     * @Type("string")
     *
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
     * @Assert\Regex(pattern="/^\(\d{2}\) (9|)[6789]\d{3}-\d{4}$/", message="Number Invalid (XX) XXXXX-XXXX.")
     * @Type("string")
     */
    private $phone;

	/**
	 * @var string
	 *
	 * @Assert\Type(
	 *     type="string",
	 *     message="The value of Contact status ({{ value }}) is not a valid {{ type }}."
	 * )
	 * @Assert\Length(
	 *      max = 1,
	 *      maxMessage = "Your Contact status cannot be longer than {{ limit }} characters"
	 * )
	 * @Assert\Choice(
	 *     choices = { "A", "I" },
	 *     message = "Status invalid ( A, I )."
	 * )
	 * @Type("string")
	 */
	private $status;

    /**
     * @return string
     */
    public function getName()
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
    public function getEmail()
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
    public function getPhone()
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

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus( string $status ) {
		$this->status = $status;
	}
}
