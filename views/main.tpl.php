<?php 

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title><?= $pageData['title'] ?></title>
  </head>
  <body>

    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <div class="container container-sm">
                <div class="row">
                    <div class="col">
                        <span class="navbar-brand mb-0 h1">Задачник</span>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-success loadTask" data-bs-toggle="modal" data-bs-target="#taskModal">
                            <i data-feather="plus"></i>
                        </button>
                    </div>
                    <div class="col-1">
                        <?php if (isset($_SESSION['loginOk']) && $_SESSION['loginOk']): ?>
                        <button type="button" class="btn btn-danger float-end logout">
                            Выйти
                        </button>
                        <?php else: ?>
                        <button type="button" class="btn btn-primary float-end tryToLogin" data-bs-toggle="modal" data-bs-target="#taskModal">
                            Войти
                        </button>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <div class="container container-sm">

        <!-- Task list -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cтатус <?= IndexController::getOrderBtn('t_done') ?></th>
                    <th scope="col">Имя пользователя <?= IndexController::getOrderBtn('t_username') ?></th>
                    <th scope="col">E-mail <?= IndexController::getOrderBtn('t_email') ?></th>
                    <th scope="col">Текст задачи <?= IndexController::getOrderBtn('t_text') ?></th>
                    <?php if (isset($_SESSION['loginOk']) && $_SESSION['loginOk']): ?>
                        <th scope="col">Ред.</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(count($pageData['taskList']) == 0): ?>
                    <tr><td colspan="5" class="text-center">Данные отсутствуют.</td></tr>
                <?php endif; ?>

                <?php foreach($pageData['taskList'] as $task): ?>
                <tr>
                    <th scope="row">
                        <?= $task['t_done'] ?
                        '<span class="badge bg-success">Выполнено</span>' :
                        '<span class="badge bg-danger">Не выполнено</span>' ?>
                        <?= $task['t_edited'] == 1 ? 
                            '<br /><span class="badge bg-info">Отредактировано администратором</span>' : 
                            '' ?>
                    </th>
                    <td><?= $task['t_username'] ?></td>
                    <td><?= $task['t_email'] ?></td>
                    <td><?= $task['t_text'] ?></td>
                    <?php if (isset($_SESSION['loginOk']) && $_SESSION['loginOk']): ?>
                        <td> 
                            <button type="button" data-id="<?= $task['t_id'] ?>" class="btn btn-light loadTask" data-bs-toggle="modal" data-bs-target="#taskModal">
                            <i data-feather="edit-2"></i>
                            </button>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for($i = 0; $i < $pageData['pageCount']; $i++): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i + 1 ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>

    <!-- Modal task -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body taskBody">
                
            </div>
            <div class="modal-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <div class="alert alert-danger error_msg visually-hidden" role="alert"></div>
                        </div>
                        <div class="col-3 p-0 modalActBtn">
                            <button type="submit" class="btn btn-primary float-end saveForm">Сохранить</button>
                        </div>
                        <div class="col-3 p-0">
                            <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Отмена</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="./assets/js/jquery-3.5.1.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="./assets/js/task.js"></script>
    <script src="./assets/js/login.js"></script>
  </body>
</html>