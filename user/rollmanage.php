<?php

require_once 'session.php';


$title = 'Roll Management';


?>
<!doctype html>

<html lang="en">

<head>

    <?php include '../includes/styles.php'; ?>
    <title><?php echo $title; ?></title>
    <style>
        table.responsiveTbl {
            font-size: 30px;
        }

        table.responsiveTbl td,
        table.responsiveTbl th {
            padding: 30px;
        }
    </style>

</head>

<body>
    <div class="page">
        <?php include '../includes/navmenu.php'; ?>
        <div class="page-wrapper">

            <div class="page-body">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">
                                <?php echo $title; ?>
                            </strong>
                        </div>
                        <div class="card-body">
                            <?php include '../includes/alert.php'; ?>


                            <table id="example" class="responsiveTbl">


                                <thead>
                                    <tr>
                                        <th>rolldoff</th>
                                        <th>approved</th>
                                        <th>warehouse</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = "SELECT
                                    COUNT(CASE WHEN roll_end = 0 THEN 1 END) AS RollDoff,
                                    COUNT(CASE WHEN roll_end = 1 THEN 1 END) AS Warehouse,
                                    COUNT(CASE WHEN roll_approve = 1 THEN 1 END) AS Approved
                                FROM  roll";

                                    $res = mysqli_query($fit, $qry);
                                    if ($res && mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            echo '<tr>';
                                            echo '<td>' . $row['RollDoff'] . '</td>';
                                            echo '<td>' . $row['Approved'] . '</td>';
                                            echo '<td>' . $row['Warehouse'] . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">No Data Available</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>