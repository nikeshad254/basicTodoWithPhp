<?php
include("../inc/userAfterLoginHeader.php");
include("../inc/db.php");

// var_dump($_SESSION['role']);
// exit;

// if (isset($_SESSION['role']) || $_SESSION['role'] != "user") {
//     header("Location:../");
//     exit;
// }

$currentUser = $_SESSION['id'];
if (isset($_POST['addTodo'])) {
    try {
        $task = trim($_POST['task']);
        if (strlen($task) < 1) {
            throw new Exception("Task is needed!");
        }

        $sql = "INSERT INTO todo (task, user_id) values('$task', '$currentUser')";
        $conn = getDB();

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Failed to Add, Please try again.");
        }
        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

if (isset($_POST['updBtn']) && $_POST['updBtn'] == 'edit') {
    try {
        $task = $_POST['task'];
        $todoId = $_POST['todoId'];
        $sql = "UPDATE todo SET task='$task' WHERE id='$todoId' AND user_id='$currentUser';";
        $conn = getDB();
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("failed to update.");
        }
        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

if (isset($_POST['updBtn']) && $_POST['updBtn'] == 'delete') {
    try {
        $todoId = $_POST['todoId'];
        $sql = "DELETE FROM todo WHERE id='$todoId' AND user_id='$currentUser';";
        $conn = getDB();
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("failed to delete.");
        }
        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
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
            <form action="" method="POST">
                <input type="checkbox" name="isComplete">
                <input type="text" name="task" placeholder="Task...">
                <button name="updBtn" value="edit">📝</button>
                <button name="updBtn" value="delete">❌</button>
            </form>
        </li>
    </ul>
</div>

<script>
    const todosContainer = document.querySelector(".todosContainer");

    function getTodos() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const todos = JSON.parse(this.responseText);
                let inHtml = "";
                todos.forEach((todo) => {
                    inHtml += `
                            <li>
                                <form action="" method="POST" data-todoid="${todo.id}">
                                    <input type="checkbox" class="isComplete" name="isComplete" ${todo.isComplete ==="1"? 'checked': ''}>
                                    <input type="hidden" name="todoId" value="${todo.id}">
                                    <input type="text" name="task" placeholder="Task..." value="${todo.task}">
                                    <button name="updBtn" value="edit">📝</button>
                                    <button name="updBtn" value="delete">❌</button>
                                </form>
                            </li>
                    `;
                })

                todosContainer.innerHTML = inHtml;
            }
        };
        xmlhttp.open("GET", "../api/todo.php", true);
        xmlhttp.send();
    }

    getTodos();

    todosContainer.addEventListener("click", e => {
        if (!e.target.classList.contains("isComplete")) {
            return;
        }
        const parentNode = e.target.parentNode;
        const isComplete = e.target.checked ? 1 : 0;
        const todoId = parentNode.dataset.todoid;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        };
        xmlhttp.open("POST", "../api/todo.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`updateCheckBox=1&isComplete=${isComplete}&todoId=${todoId}`);
        getTodos();
    })
</script>

<?php include("../inc/footer.php"); ?>