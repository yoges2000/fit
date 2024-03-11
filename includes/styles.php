<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />

<!-- CSS files -->

<link rel="stylesheet" type="text/css" href="../assets/datatables/css/datatables.min.css" />
<link href="../assets/css/fontawesome-all.min.css" rel="stylesheet" />
<link href="../assets/css/tabler-icons.min.css" rel="stylesheet" />
<link href="../assets/css/dl.css" rel="stylesheet" />
<link href="../assets/css/select2.min.css" rel="stylesheet" />
<link href="../assets/css/datepicker.css" rel="stylesheet" />

<style>
  /* RESPONSIVE TABLE STARTS HERE */

  table {
    margin: 0 auto 2rem;
  }

  .responsiveTbl {

    text-align: center;
  }

  .responsiveTbl tr:nth-of-type(even) {
    background: #d1d5d9;
  }

  .responsiveTbl th {
    background-color: #708090;
    color: white;
    font-weight: bold;
    padding: 0.5em 0.375em;
    text-align: center;
    border: 1px solid #aaa;
    text-align: center;
  }

  table.dataTable thead th,
  table.dataTable thead td,
  table.dataTable tfoot th,
  table.dataTable tfoot td {
    text-align: center
  }

  .responsiveTbl {
    border-collapse: collapse;
  }

  .responsiveTbl td {
    padding: 0.25em;
    border: 1px solid #aaa;
    text-align: center;
    white-space: nowrap;
  }


  @media only screen and (max-width: 760px) {

    .responsiveTbl,
    .responsiveTbl table,
    .responsiveTbl tbody,
    .responsiveTbl tr,
    .responsiveTbl th,
    .responsiveTbl td,
    .tableHead {
      display: block;

    }



    .responsiveTbl tr {

      margin: 0 auto;
      border-top: 1px solid #555;
      border-right: 1px solid #555;
      border-left: 1px solid #555;
    }

    td {
      border: none;
      position: relative;
      padding-left: 12.5rem;
      border-bottom: 1px solid #eee;
      margin-left: 10rem;
    }

    td:before {
      position: absolute;
      top: 0.25rem;
      left: 1rem;
      /* Change the width to fit your largest label */
      width: 8rem;
      white-space: nowrap;
      margin-left: -9rem;
    }


  }

  /* RESPONSIVE TABLE END HERE */
</style>