<?php
namespace SDL;

class SecondDefaultLanguage
{
    /** @var null|string */
    private $firstLanguage;

    /** @var null|string */
    private $secondLanguage;

    public function __construct()
    {
        add_filter('admin_init', array($this, 'adminInit'));
        add_filter('load_textdomain_mofile', array($this, 'loadTextdomainMoFile'), 90);
    }

    /**
     * @return string
     */
    private function getFirstLanguage()
    {
        $this->firstLanguage =
            $this->firstLanguage === null
                ? get_locale()
                : $this->firstLanguage;

        return $this->firstLanguage;
    }

    /**
     * @return string
     */
    private function getSecondLanguage()
    {
        $this->secondLanguage =
            $this->secondLanguage === null
                ? get_option('site_second_language', '')
                : $this->secondLanguage;

        return $this->secondLanguage;
    }

    /**
     * @internal
     */
    public function adminInit()
    {
        register_setting('general', 'site_second_language', 'esc_attr');
        add_settings_field('site_second_language', '<label for="site_second_language">' . __('Site second language', 'sdl') . '</label>', array($this, 'renderField'), 'general');
    }

    /**
     * @internal
     */
    public function renderField()
    {
        wp_dropdown_languages(array(
            'name'                        => 'site_second_language',
            'id'                          => 'site_second_language',
            'selected'                    => $this->getSecondLanguage(),
            'languages'                   => get_available_languages(),
            'translations'                => wp_get_available_translations(),
            'show_available_translations' => current_user_can('install_languages') && wp_can_install_language_pack()
        ));
    }

    /**
     * @internal
     * @param string $file Path to *.mo
     * @return string Fixed path to *.mo
     */
    public function loadTextdomainMoFile($file)
    {
        if(!is_readable($file)) {

            $firstLanguage = $this->getFirstLanguage();
            $secondLanguage = $this->getSecondLanguage();

            if(!empty($firstLanguage) && !empty($secondLanguage)) {
                $file = str_replace($firstLanguage, $secondLanguage, $file);
            }
        }
        
        return $file;
    }
}