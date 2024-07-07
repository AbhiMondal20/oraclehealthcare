<?php
include ('../../../db_conn.php');

if (isset($_POST['servname'])) {
    $servname = $_POST['servname'];

    $sql = "SELECT servname, cateVal FROM servmaster WHERE servname = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die(json_encode(array('error' => mysqli_error($conn))));
    }

    mysqli_stmt_bind_param($stmt, 's', $servname);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    
    $servmasters = array();
    while ($row_servmasters = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $servmasters[] = array('servname' => $row_servmasters['servname'], 'servrate' => $row_servmasters['cateVal']);
    }

    echo json_encode($servmasters);
    exit;
}
?>
