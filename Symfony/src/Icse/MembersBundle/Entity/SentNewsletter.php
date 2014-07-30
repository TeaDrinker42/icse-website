<?php

namespace Icse\MembersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SentNewsletter 
 */
class SentNewsletter
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;

    const UNDEFINED_NEWSLETTER = 0;
    const MEMBERS_NEWSLETTER = 1;
    const PUBLIC_NEWSLETTER = 2;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var \DateTime
     */
    private $sent_at;

    /**
     * @var \Icse\MembersBundle\Entity\Member
     */
    private $sent_by;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return SentNewsletter 
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return SentNewsletter 
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return SentNewsletter 
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set sent_at
     *
     * @param \DateTime $sentAt
     * @return SentNewsletter 
     */
    public function setSentAt($sentAt)
    {
        $this->sent_at = $sentAt;

        return $this;
    }

    /**
     * Get sent_at
     *
     * @return \DateTime 
     */
    public function getSentAt()
    {
        return $this->sent_at;
    }

    /**
     * Set sent_by
     *
     * @param \Icse\MembersBundle\Entity\Member $sentBy
     * @return SentNewsletter 
     */
    public function setSentBy(\Icse\MembersBundle\Entity\Member $sentBy = null)
    {
        $this->sent_by = $sentBy;

        return $this;
    }

    /**
     * Get sent_by
     *
     * @return \Icse\MembersBundle\Entity\Member 
     */
    public function getSentBy()
    {
        return $this->sent_by;
    }
}
