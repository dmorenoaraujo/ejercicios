<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <div class="container">
            <h1>SELECTOR PROVINCIAS DESDE MYSQL</h1>
            <form action="selector_provincias.php" method="post">
                <label for="provincias">Seleccionar provincia</label>   

            <?php

                $conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
                //var_dump($conn);
                $sql = "SELECT * FROM provincia";
                //var_dump($sql);
                $result = $conn->query($sql);
                //var_dump($result);
                echo '<select id="provincias" name="provincia">
                        <option selected disabled>Elija</option>'
                ;
                            while ($opcion=$result->fetch_assoc()){
                                echo '<option value="'.$opcion['id'].'">'.$opcion['nombre'].'</option>';
                            }
                echo   '</select>';
                //$conn->close();

            ?>

                <br>
                <input type="submit" value="Enviar">
            </form>
            <?php

                var_dump($_POST);

            ?>
        </div>
    </body>
</html>