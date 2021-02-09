<?php

class IndexController extends Controller {

	private $pageTpl = '/views/main.tpl.php';
	private $taskModal = '/views/task.modal.php';
	private $loginModal = '/views/login.modal.php';
    private $itemPerPage = 3;


	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}

	public function index() {
		$this->pageData['title'] = "Задачник";
        $page = isset($_GET['page']) ? $_GET['page'] : 0;

        $this->pageData['taskList'] = $this->model->getTaskList($page, $this->itemPerPage);
        $this->pageData['taskCount'] = $this->model->getTaskCount();
        $this->pageData['pageCount'] = ceil($this->pageData['taskCount'] / $this->itemPerPage);

		$this->view->render($this->pageTpl, $this->pageData);
	}

	public function login() {
		$this->view->render($this->loginModal, $this->pageData);
	}

	public function loginAct() {
		$response['ok'] = true;
		$response['msg'] = [];

		if ($this->model->findUser($_POST['u_name'], md5($_POST['u_pass'])) > 0) {
			$_SESSION['loginOk'] = true;
		} else {
			$_SESSION['loginOk'] = false;
			$response['ok'] = false;
			$response['msg'][] = 'Вы ввели неправильное имя пользователя или пароль.';
		}

		echo json_encode($response);
	}

	public function logout() {
		$_SESSION['loginOk'] = false;
		unset($_SESSION['orderAD']);
		unset($_SESSION['orderField']);
		echo '1';
	}

    public function task() {
        if (isset($_POST['t_id']) && $_POST['t_id'] > 0)
            $this->pageData['task'] = $this->model->getTaskById($_POST['t_id']);

		$this->view->render($this->taskModal, $this->pageData);
	}

    public function saveTask() {
		$response['ok'] = true;
		$response['msg'] = [];

		if (!isset($_POST['t_username']) || $_POST['t_username'] == '') {
			$response['ok'] = false;
			$response['msg'][] = 'Введите имя пользователя.';
		}

		if (!isset($_POST['t_email']) || $_POST['t_email'] == '') {
			$response['ok'] = false;
			$response['msg'][] = 'Введите E-mail.';
		} elseif (!filter_var($_POST['t_email'], FILTER_VALIDATE_EMAIL)) {
			$response['ok'] = false;
			$response['msg'][] = 'E-mail некорректен.';
		}

		if (!isset($_POST['t_text']) || $_POST['t_text'] == '') {
			$response['ok'] = false;
			$response['msg'][] = 'Введите текст задачи.';
		}

		if ($response['ok']) {
			if (isset($_POST['t_id']) && $_POST['t_id'] > 0) {
				if ($_SESSION['loginOk']) {
					$done = isset($_POST['t_done']) ? $_POST['t_done'] : 0;
					$this->model->updateTask($_POST['t_id'], htmlspecialchars($_POST['t_username']), htmlspecialchars($_POST['t_email']), htmlspecialchars($_POST['t_text']), $done);
				} else {
					$response['ok'] = false;
					$response['msg'][] = 'Отказано в доступе.';
				}
			}
			else
				$this->model->setNewTask(htmlspecialchars($_POST['t_username']), htmlspecialchars($_POST['t_email']), htmlspecialchars($_POST['t_text']));
		}

		echo json_encode($response);
	}

	public function orderChange() {
		$fieldName = $_POST['fieldName'];
		if (isset($_SESSION['orderField']) && $_SESSION['orderField'] == $fieldName)
			$_SESSION['orderAD'] = !$_SESSION['orderAD'];
		else {
			$_SESSION['orderAD'] = true;
		}
		$_SESSION['orderField'] = $fieldName;
	}

	public static function getOrderBtn($fieldName) {
		$style = isset($_SESSION['orderField']) && $_SESSION['orderField'] == $fieldName ? 'btn-outline-info' : 'btn-outline-light';
		$icon = @$_SESSION['orderAD'] ? 'chevron-down' : 'chevron-up';

		$html = '<button type="button" class="btn '. $style .' btn-sm orderChange" data-name="'. $fieldName .'"><i data-feather="'. $icon .'"></i></button>';
		return $html;
	}

}