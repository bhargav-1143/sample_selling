<?php
session_start();
$ROOT = $_SERVER["DOCUMENT_ROOT"];
require $ROOT."/sampleSelling-master/util/path_config/global_link_files.php";
$style_path = GlobalLinkFiles::getDirectoryPath("style");
$resouces_path = GlobalLinkFiles::getDirectoryPath("resources");
$site_header = GlobalLinkFiles::getFilePath("site_header_php");
require_once "../query/Sample_query_functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$style_path ?>bootstrap.css">


    <link rel="stylesheet" href="<?=$style_path ?>showsamples.css">
    <link rel="stylesheet" href="<?=$style_path?>navbar.css">

    <title>BeatSample</title>
</head>


<body>

    <div id="loadingScreen" class=" d-none loadingScreenDiv">
        <div class="loadingThing"></div>
    </div>

    <div class="container-fluid">
        <div class="col-12">
            <div class="row">
                <div class="maindiv col-12">
                    <div class="row">
    
                        <?php
                        require_once $site_header;
                        ?>



                        <div style="position: relative;" class="thecontentdiv  col-12 ">
                            <div class="row">
                                <div class="col-12 pt-4">
                                    <div class="row">
                                        <div class="col-lg-7 col-5 text-start   text-lg-end">
                                            <h1 class="sampleheading text-white">Samples & Drums</h1>
                                        </div>
                                        <div class="col-lg-4 col-7 text-start text-lg-end">

                                            <div class=" row">
                                                <div id="searchBoxDiv" class="col-lg-10 col-7  ">
                                                    <input id="searchBox" class="text-dark px-2 py-1 " type="text">
                                                </div>
                                                <div class="col-lg-2 col-5 text-lg-start text-center">
                                                    <img id="searchButton" class="searchIconImage" src="<?=$resouces_path?>icons/search.png" alt="" srcset="">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div id="mainsampleDiv" class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <hr class="HRTAG ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 ">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-lg-1 col-md-2 col-3 py-2 text-center">
                                                            <span class="fs-5 fw-bolder">Filter By</span>
                                                        </div>
                                                        <div class="col-lg-11 col-md-10 col-9 text-start">
                                                            <select name=""  class="selectTAG py-3 px-1" id="subSampleDrumID">
                                                                <?php
                                                              
                                                                $query_object = new Sample_query_functions();
                                                                $subsamples = $query_object->listSubSampleTypes("melodies");
                                                                $arrsize = count($subsamples);
                                                                if (!$subsamples > 0) {
                                                                ?>
                                                                    <option class="text-white"> NOPE</option>
                                                                <?php

                                                                } else {
                                                                ?>
                                                                    <option value="ALL" class="text-white"> All</option>
                                                                    <?php
                                                                    for ($i = 0; $i < $arrsize; $i++) {
                                                                        $sampleName = $subsamples[$i]['subsampleName'];
                                                                        $sampleID = $subsamples[$i]['subsampleID'];

                                                                    ?>
                                                                        <option value="<?php echo $sampleID; ?>" class="text-white"> <?php echo $sampleName; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div id="sampleTypeMelody" style="padding-left: 2.5%;padding-right: 2.5%;" class="col-12 pb-5 pt-3">

                                        </div>


                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <hr class="HRTAG">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 ">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-lg-1 col-md-2 col-3 py-2 text-center">
                                                            <span class="fs-5 fw-bolder">Filter By</span>
                                                        </div>
                                                        <div class="col-lg-11 col-md-10 col-9 text-start">
                                                            <select name="" class="selectTAG py-2 px-1" id="subSampleDrumID">
                                                                <?php
         
                                                                $subsamples = $query_object->listSubSampleTypes("drums");
                                                                $arrsize = count($subsamples);
                                                                if (!$subsamples > 0) {
                                                                ?>
                                                                    <option class="text-white"> NOPE</option>
                                                                <?php

                                                                } else {
                                                                ?>
                                                                    <option value="ALL" class="text-white"> All</option>
                                                                    <?php
                                                                    for ($i = 0; $i < $arrsize; $i++) {
                                                                        $sampleName = $subsamples[$i]['subsampleName'];
                                                                        $sampleID = $subsamples[$i]['subsampleID'];

                                                                    ?>
                                                                        <option value="<?php echo $sampleID; ?>" class="text-white"> <?php echo $sampleName; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 " id="sampleTypeDrums">

                                        </div>

                                    </div>
                                </div>
                                <div id="bySearch" style="padding-left: 5%;padding-right: 5%;" class="col-12 py-5">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="newDivId"></div>
    <script src="script.js"></script>

</body>

</html>