
<?php

$dbConnect = mysqli_connect( "localhost", "root", "21kajol21", "area" );

if ( $dbConnect === false ) {
    die( "Not connected." . mysqli_connect_error() );
}

$resultArray = array();

if ( isset( $_REQUEST["term"])) {
    $query = "SELECT * FROM cities WHERE city LIKE ?";
    if ( $statement = mysqli_prepare( $dbConnect, $query ) ) {
        mysqli_stmt_bind_param( $statement, "s", $param_term );
        $param_term = $_REQUEST["term"] . '%';
        
        if ( mysqli_stmt_execute( $statement ) ) {
            $result = mysqli_stmt_get_result( $statement );
            
            if ( mysqli_num_rows( $result ) > 0 ) {
                while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
                    array_push($resultArray, $row);
                }
            } else {
                echo "<p>No city found</p>";
            }
        } else{
            echo "Can not execute query. " . mysqli_error( $dbConnect );
        }    
        mysqli_stmt_close( $statement ); 
        echo json_encode($resultArray);
    }   
}
 
mysqli_close( $dbConnect );
?>
