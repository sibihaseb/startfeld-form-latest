<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    @font-face {
        font-family: 'avenir-next-lt-pro-regular';
        font-style: normal;
        font-weight: 400;
        src: local('avenir-next-lt-pro-regular'), local('avenir-next-lt-pro-regular'), url('fonts/regular/avenir-next-lt-pro-regular.ttf') format('truetype');
    }

    @font-face {
        font-family: 'avenir-next-lt-pro-bold';
        font-style: normal;
        font-weight: 700;
        src: local('avenir-next-lt-pro-bold'), local('avenir-next-lt-pro-bold'), url('fonts/bold/avenir-next-lt-pro-bold.ttf') format('truetype');
    }

    body {
        font-family: "avenir-next-lt-pro-regular", Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
        padding: 0px;
        margin: 0px;
    }

    h3 {
        margin-block-start: 0em;
        margin-block-end: 0em;
    }

    p {
        margin-block-start: 0em;
        margin-block-end: 0em;
    }

    .header {
        margin-top: 50%;
        margin-bottom: 50%;
        text-align: center;
    }

    .header .title {
        font-size: 30px;
    }

    .row {
        display: flex;
    }

    .col-1 {
        display: flex;
        text-align: left;
        width: 50%;
        flex-direction: column;
    }

    .col-2 {
        text-align: right;
        width: 50%;
    }

    .col-item {
        display: flex;
        align-items: center;
        text-align: center;
        justify-content: center;
    }

    .question-paper {
        background-color: #fff;
        max-width: 1000px;
        margin: 50px auto;
    }

    .page-break {
        page-break-after: always;
    }

    label {
        display: inline-block;
    }

    .question-answer {
        page-break-inside: auto;
    }

    .question-answer-all {
        page-break-inside: avoid;
    }

    header {
        z-index: 0;
        position: fixed;
        top: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
        font-size: 10px !important;
        line-height: 35px;
        margin-top: 15px;
    }

    footer {
        position: fixed;
        bottom: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
        font-size: 10px !important;
        text-align: center;
        line-height: 35px;
        margin-bottom: 15px;
    }

    .left {
        float: left;
    }

    .right {
        float: right;
    }

    .first-page-header {
        z-index: 1;
        top: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
        background: #ffffff;
    }

    .section-title {
        text-align: center;
    }
</style>

<body>
    <div>
        @yield('content')
    </div>


    <script type="text/php">

        $font = $fontMetrics->getFont("avenir-next-lt-pro-regular", "regular");
        $copyrightText = __("pdf.footer.copyright", ["current_year" => date("Y")]);
        $headerText = __("pdf.header.title");
        if($PAGE_NUM === 1)
        {
            $pdf->page_text(20, 820, "Sibi",$font, 7, array(0, 0, 0));
        }
        else{
            $pdf->page_text(20, 20, $headerText,$font, 7, array(0, 0, 0));
            $pdf->page_text(20, 820, $copyrightText,$font, 7, array(0, 0, 0));
            $pdf->page_text(540, 820, "Page {PAGE_NUM}/{PAGE_COUNT}",$font, 7, array(0, 0, 0));
        }

        </script>
</body>

</html>
