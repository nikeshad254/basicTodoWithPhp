<?php
include("../inc/userAfterLoginHeader.php");

if (isset($_SESSION['role']) || $_SESSION['role'] != "user") {
    header("Location:../");
    exit;
}
?>


<link rel="stylesheet" href="../assets/css/todos.css">
<div class="sectionContainer">
    <h1>Todos</h1>
    <form class="addForm" action="" method="post">
        <input type="text" name="task" placeholder="Add Task ..." class="input">
        <button class="btn" type="submit" name="addTodo">Add TODO</button>
    </form>

    <p class="todosContainerTitle">All Todos</p>
    <ul class="todosContainer">
        <li>
            <form action="">
                <input type="text" placeholder="Task...">
                <button>📝</button>
                <button>❌</button>
            </form>
        </li>
    </ul>
</div>

<?php include("../inc/footer.php"); ?>