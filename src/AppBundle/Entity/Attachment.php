<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Attachment
 *
 * @ORM\Table(name="attachment")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Attachment
{
    use Traits\TimestampableTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var File
     * 
     * @Vich\UploadableField(mapping="file_map", fileNameProperty="fileName")
     */
    private $file;
    
    /**
     * @var string
     *
     * @ORM\Column(name="realFileName", type="string", length=255)
     */
    private $realFileName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", length=255)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="file_uploaded_at", type="datetime")
     */
    private $fileUploadedAt;
    
    /**
     * @var Agreement 
     * @ORM\ManyToOne(targetEntity="Agreement", inversedBy="attachments")
     */
    private $agreement;

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
     * Set realFileName
     *
     * @param string $realFileName
     *
     * @return Attachment
     */
    public function setRealFileName($realFileName)
    {
        $this->realFileName = $realFileName;

        return $this;
    }

    /**
     * Get realFileName
     *
     * @return string
     */
    public function getRealFileName()
    {
        return $this->realFileName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Attachment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;

        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->fileUploadedAt = new \DateTime('now');
            
            if($file instanceof UploadedFile) {
                $this->realFileName = $file->getClientOriginalName();
            }
        }
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileUploadedAt
     *
     * @param \DateTime $fileUploadedAt
     *
     * @return Attachment
     */
    public function setFileUploadedAt($fileUploadedAt)
    {
        $this->fileUploadedAt = $fileUploadedAt;

        return $this;
    }

    /**
     * Get fileUploadedAt
     *
     * @return \DateTime
     */
    public function getFileUploadedAt()
    {
        return $this->fileUploadedAt;
    }

    /**
     * Set agreement
     *
     * @param \AppBundle\Entity\Agreement $agreement
     *
     * @return Attachment
     */
    public function setAgreement(\AppBundle\Entity\Agreement $agreement = null)
    {
        $this->agreement = $agreement;

        return $this;
    }

    /**
     * Get agreement
     *
     * @return \AppBundle\Entity\Agreement
     */
    public function getAgreement()
    {
        return $this->agreement;
    }
}
