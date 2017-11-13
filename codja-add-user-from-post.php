<?php

    /**
     * Plugin Name: CODJA Add User From Post
     * Description: Allow to add wordpress user from edit post page
     * Version: 1.0.0
     * Author: CODJA
     * Text Domain: cj-aufp
     * Domain Path: /languages/
     */

    if (!defined('ABSPATH')) {
        exit;
    }

    if (!class_exists('Codja_Add_User_From_Post')) {
        define('CJ_AUFP_VERSION', '1.0');
        define('CJ_AUFP_DIR', plugin_dir_path(__FILE__));
        define('CJ_AUFP_URL', plugin_dir_url(__FILE__));

        register_activation_hook(__FILE__, array('Codja_Add_User_From_Post', 'activation'));
        register_deactivation_hook(__FILE__, array('Codja_Add_User_From_Post', 'deactivation'));
        register_uninstall_hook(__FILE__, array('Codja_Add_User_From_Post', 'uninstall'));

        class Codja_Add_User_From_Post {

            private static $instance = null;

            public static function getInstance() {
                if ( null === self::$instance ) {
                    self::$instance = new self();
                }

                return self::$instance;
            }

            private function __clone() { }

            private function __construct() {
                if (is_admin()) {
                    add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
                    add_action('add_meta_boxes', array($this, 'addMetaBox'));

                    add_action('wp_ajax_cj_aufp_AddUser', array($this, 'addUser'));
                }
            }

            public function addUser() {
                if (!current_user_can('edit_users') || !wp_verify_nonce($_POST['nonce'], 'cj_add_user')) {
                    $this->jsonDie(array('status' => 'access_error'));
                }

                $login = isset($_POST['login']) ? sanitize_user($_POST['login'], true) : '';
                $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
                $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
                $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
                $password = isset($_POST['password']) ? $_POST['password'] : '';

                if ($login == false) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('Please, enter login', 'cj-aufp')));
                } elseif (!validate_username($login)) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('Bad login', 'cj-aufp')));
                } elseif (username_exists($login)) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('User with this login already exist', 'cj-aufp')));
                }

                if ($first_name == false) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('Please, enter first name', 'cj-aufp')));
                }

                if ($last_name == false) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('Please, enter last name', 'cj-aufp')));
                }

                if (!is_email($email)) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('Bad email', 'cj-aufp')));
                } elseif (email_exists($email)) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('User with this email already exist', 'cj-aufp')));
                }

                if ($password == false) {
                    $this->jsonDie(array('status' => 'error', 'message' => __('Please, enter password', 'cj-aufp')));
                }

                $userdata = array(
                    'user_login' => $login,
                    'user_pass' => wp_hash_password($password),
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'user_email' => $email,
                    'role' => 'editor'
                );

                $user_id = wp_insert_user($userdata);

                if (!is_wp_error($user_id)) {
                    $link = get_edit_user_link($user_id);

                    $this->jsonDie(
                        array(
                            'status' => 'success',
                            'link' => $link,
                            'user_id' => $user_id,
                            'message' => __('User successfully created', 'cj-aufp')
                        )
                    );
                } else {
                    $this->jsonDie(array('status' => 'error', 'message' => $user_id->get_error_message()));
                }
            }

            public function addMetaBox($post_type) {
                if (current_user_can('edit_users')) {
                    $post_types = $this->getPostTypes();

                    if (in_array($post_type, $post_types)) {
                        add_meta_box(
                            'cj_add_user_from_post_metabox',
                            __('Add User', 'cj-aufp'),
                            array($this, 'render_meta_box'),
                            $post_type,
                            'side',
                            'default'
                        );
                    }
                }
            }

            public function render_meta_box($post) {
                require(CJ_AUFP_DIR . 'templates/metabox.php');
            }

            public function enqueueScripts($hook_suffix) {
                $post_types = $this->getPostTypes();
                if (in_array(get_current_screen()->id, $post_types)) {
                    wp_enqueue_style('cj-aufp-styles', CJ_AUFP_URL . 'assets/css/cj-aufp.css');
                    wp_enqueue_script('cj-aufp-script', CJ_AUFP_URL . 'assets/js/cj-aufp.js', array('jquery'), false, true);
                }
            }

            private function getPostTypes() {
                $post_types = apply_filters('cj_aufp_post_types', array('post'));

                return $post_types;
            }

            private function jsonDie($array = array()) {
                wp_die(json_encode($array));
            }

            public static function activation() {}

            public static function deactivation() {}

            public static function uninstall() {}
        }

        Codja_Add_User_From_Post::getInstance();
    }