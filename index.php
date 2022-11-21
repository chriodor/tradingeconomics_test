<?php
include_once "config/config.php";

include_once "{$alapMainDir}modules/uri_classes.php";

$Uri = new URI();

$uriLocationSegment = trim($Uri->getSegment(2));

$privacyInclude = "";

$loadContent = "";
switch ($uriLocationSegment) {

    case "services":

        break;

    default:
        if ($uriLocationSegment != "") {
            // header("Location: $alapMainHttp");
        }
        break;
}

$loadCssHtml = "";
if ($loadContent != "") {
    if (is_file("{$alapMainDir}{$loadContent}css/style.css")) {
        $loadCssHtml = "<link href='{$alapMainHttp}{$loadContent}css/style.css' rel='stylesheet' />";
    }
}

$needGdprCheck = true;
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Trading Economics Test" />
        <meta name="author" content="Zajkás Máté Gábor" />
        <title>Trading Economics Test</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css" integrity="sha512-CpIKUSyh9QX2+zSdfGP+eWLx23C8Dj9/XmHjZY2uDtfkdLGo0uY12jgcnkX9vXOgYajEKb/jiw67EYm+kBf+6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <meta name='DC.description' content='Trading Economics Test' />
        <meta name='DC.identifier' content='tradingeconomics.starterp.hu' />
        <meta name='DC.format' content='text/html' />
        <meta name='DC.coverage' content='Hungary' />
        <meta name="DC.language" content="hun" />
        <meta name="DC.publisher" content="tradingeconomics.starterp.hu" />
        <meta name="DC.title" content="Trading Economics Test" />
        <meta name='DC.type' content='Text' />

        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#ffffff" />

        <meta property="og:locale" content="hu_HU" />
        <meta property='og:url' content='tradingeconomics.starterp.hu' />
        <meta property='og:type' content='website' />
        <meta property='og:title' content='Trading Economics Test' />
        <meta property='og:description' content='Trading Economics Test' />
        <meta property='og:image' content='https://starterp.hu/assets/img/startERP.png' />

        <link href="<?= $alapMainHttp ?>css/styles.css" rel="stylesheet" />

        <?= $loadCssHtml ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.umd.js" integrity="sha512-gQhCDsnnnUfaRzD8k1L5llCCV6O9HN09zClIzzeJ8OJ9MpGmIlCxm+pdCkqTwqJ4JcjbojFr79rl2F1mzcoLMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/js/bootstrap.bundle.js" integrity="sha512-xjoqjQib2IXIQrii6z9W6tt4AaXmqE+qkFIgTHI0Hoj+6eTcrJG3u7HgN/N8WCA+iNoqKYQWJrzJZfez8YqhMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    </head>
    <body id="page-top">
        <div class="container-fluid">
            <h1>Trading Economics Test</h1>
            <h2>Zajkás Máté</h2>
            <div class='row'>
                <div class='col'>
                    <select class="form-select" aria-label="Select data type" id='dataTypeSelect' onchange='compareData(event)'>
                        <option value=''>Select data type</option>
                        <option value="GDP">Compare GDP</option>
                        <!--option value="COVID">Compare Covid Cases</option-->
                        <option value="EXP/IMP">Compare Import/Export</option>
                        <option value="CREDIT">Credit Ratings</option>
                    </select>
                </div>
                <div class='col'>
                    <select class="form-select" aria-label="Select first country" id='countrySelect_first' onchange='compareData(event)'>
                        <option value=''>Select first country</option>
                        <option value="MEXI">Mexico</option>
                        <option value="NEWZ">New Zealand</option>
                        <option value="SWED">Sweden</option>
                        <option value="THAI">Thailand</option>
                        <option value="All">All</option>
                    </select>
                </div>
                <div class='col'>                
                    <select class="form-select" aria-label="Select second country" id='countrySelect_sec' onchange='compareData(event)'>
                        <option value=''>Select second country</option>
                        <option value="MEXI">Mexico</option>
                        <option value="NEWZ">New Zealand</option>
                        <option value="SWED">Sweden</option>
                        <option value="THAI">Thailand</option>
                        <option value="All">All</option>
                    </select>
                </div>
                <div class='col' style='display:none;'>                
                    <select class="form-select" aria-label="Select ratings type" id='selectRatingsType' onchange='compareData(event)'>
                        <option value=''>Select ratings type</option>
                        <option value="SP">SP</option>
                        <option value="SP_Outlook">SP Outlook</option>
                        <option value="Moodys">Moodys</option>
                        <option value="Moodys_Outlook">Moodys Outlook</option>
                        <option value="Fitch">Fitch</option>
                        <option value="Fitch_Outlook">Fitch Outlook</option>
                        <option value="DBRS">DBRS</option>
                        <option value="DBRS_Outlook">DBRS Outlook</option>
                    </select>
                </div>
            </div>
            <canvas id="chart_canvas" width="400" height="100" aria-label="" role="img" style='max-height: 750px;'>ChartJs couldn't be loaded</canvas>
                <?php
                ?>

            <script>
                var alapMainHttp = "<?= $alapMainHttp ?>";
            </script>

            <script src="<?= $alapMainHttp ?>js/functions.js"></script>
            <script src="<?= $alapMainHttp ?>js/scripts.js"></script>

            <script type='application/ld+json'> 
                {
                "@context": "http://www.schema.org",
                "@type": "WebSite",
                "name": "tradingeconomics.starterp.hu",
                "alternateName": "Trading Economics Test",
                "url": "https://tradingeconomics.starterp.hu"
                }
            </script>
        </div>

    </body>
</html>
