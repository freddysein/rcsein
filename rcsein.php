<?php

class rcsein extends rcube_plugin
{
    public function init()
    {
        $this->load_config();
        $rcmail = rcmail::get_instance();

        // Verifica que las claves de reCAPTCHA estén configuradas
        if ($rcmail->config->get('recaptcha_public_key') && $rcmail->config->get('recaptcha_secret_key')) {
            $this->add_hook('template_object_loginform', [$this, 'add_recaptcha_to_login']);
            $this->add_hook('authenticate', [$this, 'verify_recaptcha']);
        }
    }

public function add_recaptcha_to_login($loginform)
{
    $rcmail = rcmail::get_instance();
    $public_key = $rcmail->config->get('recaptcha_public_key');

    // Incluye el script de reCAPTCHA y configura el modo invisible
    $recaptcha_html = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    $recaptcha_html .= '<div class="g-recaptcha" data-sitekey="' . $public_key . '" data-size="invisible" data-callback="onSubmit"></div>';
    $recaptcha_html .= '<script>
        function onSubmit() {
            document.getElementById("login-form").submit();
        }
        function executeRecaptcha(event) {
            event.preventDefault();
            grecaptcha.execute();
        }
        document.getElementById("login-form").onsubmit = executeRecaptcha;
    </script>';

    // Inserta el reCAPTCHA invisible en el formulario de inicio de sesión
    $loginform['content'] .= $recaptcha_html;

    return $loginform;
}
    public function verify_recaptcha($args)
    {
        $rcmail = rcmail::get_instance();
        $secret_key = $rcmail->config->get('recaptcha_secret_key');
        $response = filter_input(INPUT_POST, 'g-recaptcha-response');

        if (!$response) {
            $rcmail->output->show_message('Por favor, verifica que no eres un robot.', 'error');
            $args['abort'] = true;
            return $args;
        }

        // Verifica el token de reCAPTCHA con Google
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret_key,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents($recaptcha_url, false, $context);
        $captcha_success = json_decode($verify);

        if (!$captcha_success->success) {
            $rcmail->output->show_message('La verificación de reCAPTCHA falló. Inténtalo de nuevo.', 'error');
            $args['abort'] = true;
        }

        return $args;
    }
}
