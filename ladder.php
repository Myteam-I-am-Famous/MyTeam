<?php session_start();
$title = "Ladder";

include 'includes/head.php';
include 'includes/header.php';


?>

<main>


    <div class="ladder-container">


        <!-- //TODO TABLE LADDER avec clé étrangère vers user. -->

        <div class="ladder-banner">
            <h1>MYTEAM LADDER</h1>
        </div>

        <div class="ladder-table-container">

            <table id="ladder-table" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Rank</th>
                        <th>Team Overall</th>
                        <th>MT_POINTS tot.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $users = getDataFrom('users', 'team_overall');
                    $position = 1;

                    foreach ($users as $user) {
                        echo
                        '
                        <tr class="ladder-table-row">
                            <td id="second-ladder">' . $position . '</td>
                            <td>' . $user['pseudo'] . '</td>
                            <td>' . $user['rank'] . '</td>
                            <td>' . $user['team_overall'] . '</td>
                            <td>' . $user['total_mt_points'] . '</td>
                        </tr>
                            ';
                        $position++;
                    }


                    ?>
                    <tr class="ladder-table-row">
                        <td id="second-ladder">2</td>
                        <td>Naturoooo</td>
                        <td>37</td>
                        <td>88</td>
                        <td>57 451</td>
                    </tr>
                    <tr class="ladder-table-row">
                        <td id="third-ladder">3</td>
                        <td>Saskeeee</td>
                        <td>42</td>
                        <td>91</td>
                        <td>65 134</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>


</main>

<?php include 'includes/footer.php'; ?>