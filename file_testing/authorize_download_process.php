<?php

$ROOT = $_SERVER["DOCUMENT_ROOT"];
require_once $ROOT . "/sampleSelling-master/util/path_config/global_link_files.php";
$folder_creation_path = GlobalLinkFiles::getFilePath("folder_creation");
$home_page_shortend = GlobalLinkFiles::getRelativePath("home_page_shortend");
require_once "DownloadLink.php";
require_once "DirectoryZip.php";
require_once "Validation.php";

$query_object = new DownloadLink();
$link = "http://localhost/sampleSelling-master/file_testing/authenticate.php?unique_id=6374abd38d577&dnt=2022-11-16%2010:22:27";

//error states to display error messages in html
$input_received = true;
$input_validation = true;
$one_time_download_completed = false;
$no_matches_found = false;
$file_is_made = true;
$directory_is_made = false;

if (!isset($_POST["unique_id"]) || !isset($_POST["dnt"])) {
    $input_received = false;
    HeaderUrl::headerFunction($home_page_shortend);
    die();
}
if (!Validation::isCustomerPurchaseIdValid($_POST["unique_id"]) || !Validation::isDateTimeValid($_POST["dnt"])) {
    $input_validation = false;
}
$unique_id = $_POST["unique_id"];
$dnt = $_POST["dnt"];


$download = new DownloadLink();
//one time download checking if there is a row found enter to the else block
if (!$download->checkDownloadStatus($unique_id, $dnt)) {

    //set a unique folder name
    $folder_name = $folder_creation_path . uniqid() . "folder_rag";

    //make folder
    $directory_is_made = mkdir($folder_name);

    //if directory is made then continue
    if ($directory_is_made) {

        //confirm the unique id and datetime matches in the customerpurchase table
        $status = $download->confirmCustomerPurchase($unique_id, $dnt);
        if ($status == 1) {

            //query customer purchase history table to get the products and the qtys
            $products = $download->get_products($unique_id, $dnt);
            $row_count = count($products);


            for ($i = 0; $i < $row_count; $i++) {
                # code...
                $qty = $products[$i]["qty"];
                //create zip files for each product if the qty is 2 then create 2 zip files
                for ($j = 0; $j < $qty; $j++) {

                    //orginal zip file path exact location 
                    $product = $ROOT . $products[$i]["samplePath"];
                    //unique name is created to create a copy of the zip file
                    $unique_name = $products[$i]["UniqueId"] . uniqid() . $products[$i]["Sample_Name"];
                    //generate file path for the copy of original zip file 
                    $folder_path = $folder_name . "/" . $unique_name . ".zip";
                    //original product will be copied to this $folder_path
                    copy($product, $folder_path);
                }
            }


            //to zip out the entire folder which contains the zip files as products
            $folder_path_to_be_zipped = $ROOT . "/" . "sampleSelling-master/downloadable_zip_files/" . uniqid() . ".zip";
            echo $folder_path_to_be_zipped;
            $zip = new DirectoryZip($folder_path_to_be_zipped, $folder_name);
            $zip_creation_status = $zip->makeDirectory();
            echo "<br>";
            echo $zip_creation_status;
            echo "<br>";
            echo $zip->getZipCreationStatus();
            $file_is_made = file_exists($folder_path_to_be_zipped);
            if ($file_is_made) {
                echo " yess this file exits";
                //add a row to the download history table so next time there won't be a chance to download again
                $download->updateDownloadStatus($unique_id, $dnt);


                //download section 


                ob_clean();
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($folder_path_to_be_zipped) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($folder_path_to_be_zipped));
                flush(); // Flush system output buffer
                readfile($folder_path_to_be_zipped);
                unlink($folder_path_to_be_zipped);
                unlink($folder_name);
                HeaderUrl::headerFunction($home_page_shortend);
                exit();
            }else{
                //if file is failed to created
            }
        } else {
            //no matching rows found in customer purchase table for the values of unique id and dnt
            $no_matches_found = true;
        }
    }else{
        //directory was not made
    }
} else {
    $one_time_download_completed = true;
    // HeaderUrl::headerFunction($home_page_shortend);
    // die();
}
