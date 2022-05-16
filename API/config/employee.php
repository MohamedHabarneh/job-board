<?php
include_once("user.php");

class Employee extends User
{
    public $employeeID;
    public $eduLevel;
    public $appliedPosts;
    public $savedPosts;

    public function __toString()
    {
        $json = array(
            "employeeID" => $this->employeeID,
            "eduLevel" => $this->eduLevel,
            "appliedPosts" => $this->appliedPosts,
            "savedPosts" => $this->savedPosts,
        );
        return json_encode($json);
    }
    function addEmployee()
    {
        $this->table_name = "Employee";

        $query = "INSERT INTO " . $this->table_name . "
        SET
            EducationLevel = :eduLevel,
            TimeStamp = CURRENT_TIMESTAMP,
            UserID = :userId";

        $stmt = $this->conn->prepare($query);

        $this->eduLevel = htmlspecialchars(strip_tags($this->eduLevel));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // bind the values
        $stmt->bindParam(':userId', $this->id);
        $stmt->bindParam(':eduLevel', $this->eduLevel);
        if ($stmt->execute()) {
            $this->employeeId = $this->conn->lastInsertId();
            return true;
        }
        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        $this->error = "Server Error";
        return false;
    }

    function applyToPost($id)
    {
        $this->table_name = "AppliedPosts";

        $query = "INSERT INTO " . $this->table_name . "
        SET
            EmployeeID = :employeeID,
            TimeStamp = CURRENT_TIMESTAMP,
            AppStatusID = 1,
            JobPostID = :postID
            ";

        $stmt = $this->conn->prepare($query);
        // bind the values
        $stmt->bindParam(':employeeID', $this->id);
        $stmt->bindParam(':postID', $id);
        if ($stmt->execute()) {
            return true;
        }
    }

    function getAllPosts()
    {
        $this->table_name = "JobPosts";
        $query = "SELECT * FROM " . $this->table_name;

        $this->table_name = "JobPosts";
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        $posted = [];
        foreach ($posts as $p) {
            $post = new JobPost($this->conn);
            $post->id = $p["JobPostID"];
            $post->desc = $p["JobDescription"];
            $post->address = $p["AddressID"];
            $post->title = $p["JobPostTitle"];
            $post->qualifications = $p["Qualifications"];
            $post->responsibilities = $p["Responsibilities"];
            $post->education = $p["EducationID"];
            $post->type = $p["JobTypeID"];
            $post->employer = $p["ContactDetails"];
            $post->experience = $p["ExpReqID"];
            $post->salary = $p["SalaryID"];
            $post->datePosted = $p["DatePosted"];
            $post->endDate = $p["Deadline"];
            $post->benefits = $post->getBenefits();
            $post->applied = $post->getApplied();

            array_push($posted, $post);
        }
        return $posted;
    }

    function getSavedPosts()
    {
        $this->table_name = "JobPosts";
        $query = "SELECT JobPosts.JobPostID, EducationID, AddressID, ExpReqID, SalaryID, JobPostTitle, JobDescription, Responsibilities, Qualifications, DatePosted, Deadline, ContactDetails FROM JobPosts JOIN SavedPosts ON JobPosts.JobPostID = SavedPosts.JobPostID WHERE EmployeeID = " . $this->id;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        $posted = [];
        foreach ($posts as $p) {
            $post = new JobPost($this->conn);
            $post->id = $p["JobPostID"];
            $post->desc = $p["JobDescription"];
            $post->address = $p["AddressID"];
            $post->title = $p["JobPostTitle"];
            $post->qualifications = $p["Qualifications"];
            $post->responsibilities = $p["Responsibilities"];
            $post->education = $p["EducationID"];
            $post->type = $p["JobTypeID"];
            $post->employer = $p["ContactDetails"];
            $post->experience = $p["ExpReqID"];
            $post->salary = $p["SalaryID"];
            $post->datePosted = $p["DatePosted"];
            $post->endDate = $p["Deadline"];
            $post->benefits = $post->getBenefits();
            $post->applied = $post->getApplied();

            array_push($posted, $post);
        }
        return $posted;
    }
    function getAppliedPosts()
    {
        $this->table_name = "JobPosts";
        $query = "SELECT JobPosts.JobPostID, EducationID, AddressID, ExpReqID, SalaryID, JobPostTitle, JobDescription, Responsibilities, Qualifications, DatePosted, Deadline, ContactDetails FROM JobPosts JOIN AppliedPosts ON JobPosts.JobPostID = SavedPosts.JobPostID WHERE EmployeeID = " . $this->id;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        $posted = [];
        foreach ($posts as $p) {
            $post = new JobPost($this->conn);
            $post->id = $p["JobPostID"];
            $post->desc = $p["JobDescription"];
            $post->address = $p["AddressID"];
            $post->title = $p["JobPostTitle"];
            $post->qualifications = $p["Qualifications"];
            $post->responsibilities = $p["Responsibilities"];
            $post->education = $p["EducationID"];
            $post->type = $p["JobTypeID"];
            $post->employer = $p["ContactDetails"];
            $post->experience = $p["ExpReqID"];
            $post->salary = $p["SalaryID"];
            $post->datePosted = $p["DatePosted"];
            $post->endDate = $p["Deadline"];
            $post->benefits = $post->getBenefits();
            $post->applied = $post->getApplied();

            array_push($posted, $post);
        }
        return $posted;
    }
}