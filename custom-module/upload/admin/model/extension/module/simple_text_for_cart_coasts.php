<?php

class ModelExtensionModuleSimpleTextForCartCoasts extends Model
{
    // Создать поле в таблице
    public function CreateFieldInProductDescriptionTable()
    {
        $this->db->query(
            "ALTER TABLE " . DB_PREFIX . "product_description ADD `simple_text` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Простое текстовое поле' AFTER `name`;"
        );
    }

    // Удалить поле в таблице
    public function DeleteFieldInProductDescriptionTable()
    {
        $this->db->query(
            "ALTER TABLE " . DB_PREFIX . "oc_product_description DROP `simple_text`;"
        );
    }

    // Запись настроек в базу данных
    public function SaveSettings()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('module_simple_text_for_cart_coasts', $this->request->post);
    }

    // Загрузка настроек из базы данных
    public function LoadSettings()
    {
        return $this->config->get('module_simple_text_for_cart_coasts_status');
    }

}

?>