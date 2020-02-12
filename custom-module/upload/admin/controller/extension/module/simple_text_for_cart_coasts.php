<?php

class ControllerExtensionModuleSimpleTextForCartCoasts extends Controller
{

    public function index()
    {

        // Загружаем "модель" модуля
        $this->load->model('extension/module/simple_text_for_cart_coasts');

        // Сохранение настроек модуля, когда пользователь нажал "редактировать"
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            // Вызываем метод "модели" для сохранения настроек
            $this->model_extension_module_simple_text_for_cart_coasts->SaveSettings();
            // Выходим из настроек с выводом сообщения
            $this->session->data['success'] = 'Настройки сохранены';
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        // Загружаем настройки через метод "модели"
        $data = array();
        $data['module_simple_text_for_cart_coasts_status'] = $this->model_extension_module_simple_text_for_cart_coasts->LoadSettings();
        // Загружаем языковой файл
        $data += $this->load->language('extension/module/simple_text_for_cart_coasts');
        // Загружаем "хлебные крошки"
        $data += $this->GetBreadCrumbs();

        // Кнопки действий
        $data['action'] = $this->url->link('extension/module/simple_text_for_cart_coasts', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
        // Загрузка шаблонов для шапки, колонки слева и футера
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // Выводим в браузер шаблон
        $this->response->setOutput($this->load->view('extension/module/simple_text_for_cart_coasts', $data));

    }

    // Хлебные крошки
    private function GetBreadCrumbs()
    {
        $data = array();
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/simple_text_for_cart_coasts', 'user_token=' . $this->session->data['user_token'], true)
        );
        return $data;
    }

    // При установке модуля
    public function install()
    {
        // Модель модуля
        $this->load->model('extension/module/simple_text_for_cart_coasts');

        // Метод создаст поле в БД магазина в таблице oc_product_description
        $this->model_extension_module_simple_text_for_cart_coasts->CreateFieldInProductDescriptionTable();
    }

    // При удалении
    public function uninstall()
    {
        // Загружаем "модель" модуля
        $this->load->model('extension/module/simple_text_for_cart_coasts');

        if (isset($this->request->get['route=marketplace/installer'])) {
            // Вызывать метод модели (удалить дополнительное поле а таблице oc_product_description)
            $this->model_extension_module_simple_text_for_cart_coasts->DeleteFieldInProductDescriptionTable();
        } else {
            $this->model_extension_module_simple_text_for_cart_coasts->DeleteFieldInProductDescriptionTable();
        }
    }

}

?>