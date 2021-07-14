<!DOCTYPE html>
<html>
   <head>
      <title>ToDoList</title>
      <link rel="stylesheet" type="text/css" href="style.css">
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
      <script>
         function deleteAllCookies() {
         var cookies = document.cookie.split(";");
         
        function deleteAllCookies() {
            var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
        }
          function myFunction() {
              alert("Task modified successfully");
            }
      </script>
   </head>
   <body>
      <form method="post" action="">
         <?php $db = mysqli_connect("localhost", "root","", "todo") or die("query failed" .mysqli_error($db)); ?>
         <?php
            if (isset($_POST['submit'])) {
                $task = $_POST['task'];
                $query = "INSERT INTO tasks (task) VALUES ('$task')";
                $run_query = mysqli_query($db, $query);
            }
            ?>
         <div class="header">
            <h1>ToDoList</h1>
         </div>
         <div class="input-group">
            <input type="text" name="task" class="task" id="task" placeholder="Add a new Task">
            <button type="submit" name="submit" class="btn">Add Task</button>
         </div>
          
         <?php if(isset($_GET['edit'])) :
             $edit = $_GET['edit'];
             $query = "SELECT * FROM tasks WHERE id = $edit ";
             $result = mysqli_query($db, $query);
             while($row = mysqli_fetch_assoc($result)) {
                  $id = $row['id'];
         ?>
                 <div class="input-group" >
                    <input type="text" class="edit" id="edit" name="edit" placeholder="Modify Task">
                    <button type="submit" name="update" class="btn" onclick="myFunction()">Update</button>
                 </div>

              <?php
                 if (isset($_POST['update'])) {
                     $task = $_POST['edit'];
                     $query = "update tasks set task = '$task' where id = '$id' ";
                     $run_query = mysqli_query($db, $query);
                     
                      header('location: index.php');
                  
                 }
         } endif; ?>
      </form>
      
      <table>
         <thead>
            <tr>
               <th>Task</th>
               <th>Edit</th>
               <th>Delete</th>
               <th>Time</th>
            </tr>
         </thead>
         <tbody>
            <?php
               $run_task = mysqli_query($db, "SELECT * FROM tasks LIMIT 20");
               while ($row = mysqli_fetch_assoc($run_task)) {
                   $id = $row[ 'id'];
                   $task1 = $row[ 'task'];
                   $time = $row['time'];
               ?>
            <tr>
               <td><?php echo $task1; ?></td>
               <td class="edit"><a href="index.php?edit=<?php echo $id; ?>"><i style='font-size:24px' class='far'>&#xf044;</i></a></td>
               <td class="delete"><a href="index.php?delete=<?php echo $id; ?>">x</a></td>
               <td><?php echo $time; ?></td>
            </tr>
            <?php } ?>
         </tbody>
         <?php
            if (isset($_GET['delete'])) {
                $delete = $_GET['delete'];
                $query = "DELETE FROM tasks WHERE id = '$delete'";
                $run = mysqli_query($db, $query);
                header('location: index.php');
             }
            ?>
      </table>
   </body>
</html>