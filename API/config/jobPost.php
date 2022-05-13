<?php
class JobPost
{
    public $conn;
    private $table_name = "JobPosts";

    public $id;
    public $desc;
    public $address;
    public $title;
    public $qualifications;
    public $responsibilities;
    public $education;
    public $type;
    public $employer;
    public $experience;
    public $salary;
    public $benefits;
    public $datePosted;
    public $endDate;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function postJob()
    {
        $query = "INSERT INTO " . $this->table_name . "
        SET
            EducationID = :education,
            AddressID =  :address,
            JobTypeID = :type,
            ExpReqID = :experience,
            SalaryID = :salary,
            TimeStamp = CURRENT_TIMESTAMP,
            JobPostTitle = :title,
            JobDescription = :desc,
            Responsibilities = :responsibilities,
            Qualifications = :qualifications,
            DatePosted = CURRENT_TIMESTAMP,
            Deadline = :endDate,
            ContactDetails = :employer";

        $stmt = $this->conn->prepare($query);

        $this->education = htmlspecialchars(strip_tags($this->education));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->experience = htmlspecialchars(strip_tags($this->experience));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->desc = htmlspecialchars(strip_tags($this->desc));
        $this->responsibilities = htmlspecialchars(strip_tags($this->responsibilities));
        $this->qualifications = htmlspecialchars(strip_tags($this->qualifications));
        $this->endDate = htmlspecialchars(strip_tags($this->endDate));
        $this->employer = htmlspecialchars(strip_tags($this->employer));


        $stmt->bindParam(':education', $this->education);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':experience', $this->experience);
        $stmt->bindParam(':salary', $this->salary);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':desc', $this->desc);
        $stmt->bindParam(':responsibilities', $this->responsibilities);
        $stmt->bindParam(':qualifications', $this->qualifications);
        $stmt->bindParam(':endDate', $this->endDate);
        $stmt->bindParam(':employer', $this->employer);

        $date = date_create($this->endDate);
        $this->endDate = date_format($date, 'Y-m-d H:i:s');

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            if (!$this->postBenefits()) {
                echo "no benefits inserted";
            }
            return true;
        }

        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        $this->error = "Server Error";
        return false;
    }

    function postBenefits()
    {
        $benefitsArray = $this->benefits;
        $this->table_name = "JobBenefits";
        foreach ($benefitsArray as $value) {
            $query = "INSERT INTO " . $this->table_name . "
        SET
            BenefitID = :benefitID,
            JobPostID =  :postID";

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $value = htmlspecialchars(strip_tags($value));

            $stmt->bindParam(':benefitID', $value);
            $stmt->bindParam(':postID', $this->id);

            if (!$stmt->execute()) {
                echo "\nPDO::errorInfo():\n";
                print_r($stmt->errorInfo());
                $this->error = "Server Error";
            }
        }
    }
}