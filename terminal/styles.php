<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta name="description" content="">
<meta name="author" content="">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- Fontawesome -->
<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
<!-- jquery-ui -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<!-- Custom -->
<link rel="stylesheet" type="text/css" href="css/custom.css">


<style>
    html,
    body {
        font-family: "Verdana, Roboto, Helvetica, Arial, sans-serif";
        font-size: 16px;
        overflow: auto !important;
        background-color: #888888;
        background-image: url("images/bg1.jpg");
        height: 100vh;
    }

    .full_container {
        display: table;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden !important;
        height: 100vh !important;
        width: 100%;
    }

    .fixed_container {
        display: table-row;
        width: 100%;
        height: 60px !important;
        vertical-align: middle;
        overflow: hidden !important;
    }

    .ui_container {
        display: table-row;
        height: calc(100vh - 60px) !important;
        width: 100%;
        overflow: hidden !important;
    }

    .vertical_center {
        display: table-cell;
        vertical-align: middle;
    }

    .card-body {
        background-color: #e3f2fd;
    }

    .form-group {
        color: #0b73c6;
    }

    .form-control {
        background-color: #B9E2FD;
    }

    .form-control:active,
    .form-control:focus {
        background-color: #8ed1f2;
    }

    /* screen Header Style Start */
    .screen_title {
        text-align: center;
        color: #E51A25;
        font-weight: bold;
        font-size: 20px;
        vertical-align: middle;
        padding-top: 5px;
        text-transform: uppercase;
    }

    .section_number_wrapper {
        text-align: center;
        color: #000;
        font-weight: bold;
        font-size: 30px;
    }

    .section_number {
        text-shadow: -0.06em 0 red, 0.06em 0 cyan;
        font-family: Helvetica, Geneva, sans-serif;
    }

    .section_number:focus {
        outline: none;
    }

    .section_number span {
        line-height: 24px;
        transition: font-size 2s cubic-bezier(0, 1, 0, 1);
    }

    /* screen Header Style End */


    /* Additinal CSS Start */
    .table td,
    .table th {
        padding: .25rem .75rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    .borderless_table td,
    .borderless_table th {
        border: none;
        color: #fff;
        text-align: left;
    }

    /* Additinal CSS End */
</style>




<style>
    /* Home Screen css start */
    .complete_panel {
        margin: 0px;
        padding: 0px;
    }

    .total_sections_area {
        margin: 0px;
        padding: 0px;
        color: #fff;
        text-align: center;
        text-transform: uppercase;
    }

    .single_section_area {
        padding: 0px;
        /* height: 100vh; */
        background-image: url("images/bg1.jpg");
    }

    .info_container {
        height: 100px;
    }

    .info_content {
        padding: 2px 10px;
    }

    .action_container {
        padding: 2px 10px;
    }

    .action_content {
        padding: 0px;
    }

    .length_container {
        background-color: #444444;
        border-radius: 20px;
        height: 100px;
        background-image: url("images/bg2.jpg");
    }

    .length_content {
        padding: 2px;
        vertical-align: middle;
    }

    .length_title {
        font-size: 16px;
        line-height: 40px;
    }

    .length_value {
        font-size: 30px;
        line-height: 40px;
    }

    .batch_container {
        background-color: #444444;
        border-radius: 5px;
        height: 100px;
        background-image: url("images/bg2.jpg");
    }

    .batch_content {
        padding: 7px;
        font-size: 11px;
    }

    .defect_container {
        background-color: #444444;
        border-radius: 5px;
        margin: 5px 0px;
        overflow-x: hidden;
        overflow-y: auto;
        height: 300px;
        background-image: url("images/bg2.jpg");
    }

    .defect_content {
        padding: 2px;
        font-size: 14px;
    }

    .option_key {
        color: #fff;
        background-color: #007bff;
        margin: 1px 0px;
        border-color: #007bff;
        border-radius: 10px;
        width: 100%;
        min-height: 70px;
        max-height: 75px;
    }

    .option_key_text {
        text-transform: uppercase;
        vertical-align: middle;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }

    .option_key:active {
        background-color: #0052a3;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }

    .home_option_key {
        color: #fff;
        background-color: #007bff;
        margin: 1px 0px;
        border-color: #007bff;
        border-radius: 10px;
        width: 100%;
        height: 80px;
    }

    .home_option_key_text {
        text-transform: uppercase;
        vertical-align: middle;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }

    .home_option_key:active {
        background-color: #0052a3;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }

    /* Home Screen css End */

    .defect_key_container {
        padding: 10px 25px;
        margin: 5px;
        border-radius: 20px;
        border: 1px solid #444444;
    }

    .defect_key_content {
        padding: 3px;
        text-align: center;
    }

    .defect_key {
        color: #fff;
        background-color: #007bff;
        margin: 3px 0px 3px 0px;
        padding: 0px;
        border-color: #007bff;
        border-radius: 10px;
        min-width: 120px;
        max-width: 120px;
        min-height: 70px;
        max-height: 80px;
        text-transform: uppercase;
    }

    .defect_abbrv {
        text-transform: uppercase;
        vertical-align: middle;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }

    .defect_name {
        vertical-align: middle;
        text-align: center;
        font-size: 10px;
        font-weight: bold;
    }


    a.disabled {
        pointer-events: none;
        cursor: default;
    }

    .input-append .add-on:last-child,
    .input-append .btn:last-child {
        border-radius: 0px;
        padding: 6px 5px 2px;
    }

    .input-prepend input,
    .input-append input,
    .input-prepend input[class*="span"],
    .input-append input[class*="span"] {
        width: none;
    }

    .input-append input,
    .input-append select,
    .input-prepend span,
    .input-prepend input {
        border-radius: 0px !important;
    }



    /* -- quantity box -- */
    .quantity {
        display: inline-block;
    }

    .quantity .input-text.qty {
        width: 100px;
        height: 39px;
        padding: 0 5px;
        text-align: center;
        background-color: transparent;
        border: 1px solid #efefef;
    }

    .quantity.buttons_added {
        text-align: left;
        position: relative;
        white-space: nowrap;
        vertical-align: top;
    }

    .quantity.buttons_added input {
        display: inline-block;
        margin: 0;
        vertical-align: top;
        box-shadow: none;
    }

    .quantity.buttons_added .minus,
    .quantity.buttons_added .plus {
        padding: 7px 16px 8px;
        height: 41px;
        background-color: #ffffff;
        border: 1px solid #efefef;
        cursor: pointer;
    }

    .quantity.buttons_added .minus {
        border-right: 0;
    }

    .quantity.buttons_added .plus {
        border-left: 0;
    }

    .quantity.buttons_added .minus:hover,
    .quantity.buttons_added .plus:hover {
        background: #eeeeee;
    }

    .quantity input::-webkit-outer-spin-button,
    .quantity input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        margin: 0;
    }

    .quantity.buttons_added .minus:focus,
    .quantity.buttons_added .plus:focus {
        outline: none;
    }



    .col-1,
    .col-10,
    .col-11,
    .col-12,
    .col-2,
    .col-3,
    .col-4,
    .col-5,
    .col-6,
    .col-7,
    .col-8,
    .col-9 {
        padding-right: 5px;
        padding-left: 5px;
    }

    .new_roll_container {
        height: 100%;
        vertical-align: middle;
        padding: 10px;
    }

    .new_roll_section_number {
        text-transform: uppercase;
        font-family: verdana;
        font-size: 5em;
        font-weight: 700;
        color: #f5f5f5;
        text-shadow: 1px 1px 1px #919191,
            1px 2px 1px #919191,
            1px 3px 1px #919191,
            1px 4px 1px #919191,
            1px 5px 1px #919191,
            1px 6px 1px #919191,
            1px 7px 1px #919191,
            1px 8px 1px #919191,
            1px 9px 1px #919191,
            1px 10px 1px #919191,
            1px 18px 6px rgba(16, 16, 16, 0.4),
            1px 22px 10px rgba(16, 16, 16, 0.2),
            1px 25px 35px rgba(16, 16, 16, 0.2),
            1px 30px 60px rgba(16, 16, 16, 0.4);
    }

    .new_roll_btn_container {
        text-align: center;
        padding: 10px;
    }

    .new_roll_btn {
        position: relative;
        margin: 0.5em;
        border: solid 0.125em transparent;
        padding: 0;
        width: 200px;
        height: 80px;
        border-radius: 1em;
        color: #fff;
        text-shadow: 1px 1px var(--c-sh-txt rgba(0, 0, 0, .5));
        transition: 0.2s ease-out;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        box-shadow: inset 0 -0.5em 0.5em #0569b7, inset 0 -0.5em 0.125rem 0.5em #1680cf;
        background: linear-gradient(#3ba1e9, #3996db 50%) content-box, linear-gradient(#317bb5, #2499e6) border-box;
    }

    .new_roll_btn:before {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0.1875em;
        background: radial-gradient(closest-side, #30a2dd, rgba(48, 162, 221, 0)) 50%/ 75% 100% no-repeat;
        content: '';
    }





    /* Defect Radio Button Style Start */

    @keyframes click-wave {
        0% {
            height: 40px;
            width: 40px;
            opacity: 0.35;
            position: relative;
        }

        100% {
            height: 300px;
            width: 300px;
            margin-left: -80px;
            margin-top: -80px;
            opacity: 0;
        }
    }

    .defect_radio_option {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        position: relative;
        top: 13.33333px;
        right: 0;
        bottom: 0;
        left: 0;
        transition: all 0.15s ease-out 0s;
        background: #cbd1d8;
        border: none;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        margin-right: 0.5rem;
        outline: none;
        position: relative;
        z-index: 1000;
    }

    .defect_radio_option:hover {
        background: #9faab7;
    }

    .defect_radio_option:checked {
        background: #40e0d0;
    }

    .defect_radio_option:checked::before {
        position: absolute;
        content: '✔';
        display: inline-block;
        font-size: 26.66667px;
        text-align: center;
        line-height: 57px;
    }

    .defect_radio_option:checked::after {
        -webkit-animation: click-wave 0.65s;
        -moz-animation: click-wave 0.65s;
        animation: click-wave 0.65s;
        background: #40e0d0;
        content: '';
        display: block;
        position: relative;
        z-index: 100;
    }

    .defect_radio_option.defect_radio_input {
        border-radius: 50%;
    }

    .defect_radio_option.defect_radio_input::after {
        border-radius: 50%;
    }

    .point1 {
        height: 50px;
        width: 50px;
    }

    .point1:checked::before {
        height: 50px;
        width: 50px;
    }

    .point2 {
        height: 53px;
        width: 53px;
    }

    .point2:checked::before {
        height: 53px;
        width: 53px;
    }

    .point3 {
        height: 57px;
        width: 57px;
    }

    .point3:checked::before {
        height: 57px;
        width: 57px;
    }

    .point4 {
        height: 60px;
        width: 60px;
    }

    .point4:checked::before {
        height: 60px;
        width: 60px;
    }



    #keypad {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    #keypad li {
        float: left;
        margin: 0 5px 5px 0;
        width: 90px;
        height: 90px;
        font-size: 24px;
        line-height: 90px;
        text-align: center;
        background: #000;
        color: #fff;
        border: 1px solid #f9f9f9;
        border-radius: 5px;
    }

    #keypad li:hover {
        position: relative;
        top: 1px;
        left: 1px;
        border-color: #e5e5e5;
        cursor: pointer;
    }

    /* Defect Radio Button Style End */
</style>

<style>
    /* Fixed Block Style */
    .fixedblock_contents {
        background-image: url('images/bg3.jpg');
        margin: 3px 10px;
        padding: 5px 10px 0px 10px;
        border-radius: 10px;
        color: #fff;
        text-align: center;
    }

    .fixedblock_small_text {
        font-size: 9pt;
    }

    .fixedblock_big_text {
        font-size: 13pt;
    }

    .hms {
        font-size: 13pt;
    }

    .ampm {
        font-size: 9pt;
    }

    .wrong_input {
        text-align: center;
        color: #007BFF;
        font-size: 20px;
        font-weight: bold;
    }
</style>

<style>
    .apparent-message {
        width: 100%;
        border-style: solid;
        border-width: 2px;
        margin-bottom: 50px;
    }

    .apparent-message .apparent-message-icon {
        flex: 0 0 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #fff;
        text-shadow: 1px 1px 10px #000;
    }

    .apparent-message .apparent-message-icon .fa-2x {
        box-shadow: 1px 1px 0px rgba(0, 0, 0, 0.45);
    }

    .message-container {
        display: flex;
    }

    .message-container .content-container {
        flex-basis: 0;
        flex-grow: 1;
        max-width: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        height: 75px;
        padding-left: 15px;
        background-color: #fff;

        position: relative;
    }

    .message-container .content-container .message-header {
        font-size: 22px;
        color: #f39b0e;
        font-weight: bold;
    }

    .message-container .content-container .message-body {
        margin-top: 10px;
        font-size: 16px;
        color: #515151;
        font-weight: bold;
    }

    .message-container .content-container .message-action {
        position: absolute;
        bottom: 10px;
        right: 30px;
    }

    .warning-message {
        background-color: #f39b0e;
        border-color: #f39b0e;
    }
	
	
::-webkit-Scrollbar{
	width:5px;
	
}
::-webkit-Scrollbar-track{
	background-color: #1c2331;
	
	
}
::-webkit-Scrollbar-thumb{
	background-color: #dddddd;
	
	
}
::-webkit-Scrollbar-thumb-hover{
	background-color: #cccccc;
	
	
}
</style>