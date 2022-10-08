<?php

require "../PDOPHP/connectDB.php";
class SampleUniqueiDProcess extends DBh
{
    public function genRandomUniqueId(): string
    {


        $bytes = random_bytes(8);

        $encoded = base64_encode($bytes);


        $stripped = str_replace(['=', '+', '/'], 'R', $encoded);
        $uniqueNumComb = uniqid();



        return $stripped . $uniqueNumComb;
    }

    public function isGeneratedIdUnique($ranUniId): bool
    {
        $uniqueIdGenerated = TRUE;

        $query = "SELECT * FROM `samples` ";
        $statement = $this->connect()->prepare($query);
        $statement->execute([]);
        $resultSet = $statement->fetchAll();
        $rows = count($resultSet);

        if ($rows > 0) {
            for ($i = 0; $i < $rows; $i++) {
                $uid = $resultSet[$i]["UniqueId"];

                if ($uid == $ranUniId) {

                    $uniqueIdGenerated = FALSE;
                    break;
                }
            }
        }
        return $uniqueIdGenerated;
    }

    public function getCheckedRandomUniqueId(): string
    {
        $ok = true;
        while ($ok) {

            $uniqueId = $this->genRandomUniqueId();

            $state = $this->isGeneratedIdUnique($uniqueId);

            if ($state) {

                $ok = false;
                return $uniqueId;
            }
        }
    }
}
?>