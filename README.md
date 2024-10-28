rcsein - reCAPTCHA by SEIN for Roundcube

rcsein es un plugin para Roundcube que integra Google reCAPTCHA v2 Invisible en el formulario de inicio de sesión, brindando una capa adicional de seguridad contra ataques automatizados. Este plugin es compatible con Roundcube 1.6.9, Ubuntu 22.04.5 LTS, MariaDB 10.6.18, y PHP 8.1.30.

Requisitos

	•	Sistema Operativo: Ubuntu 22.04.5 LTS
	•	Base de Datos: MariaDB 10.6.18
	•	PHP: 8.1.30
	•	Roundcube: 1.6.9
	•	Google reCAPTCHA v2 Invisible keys: Puedes generarlas en Google reCAPTCHA.

Características

	•	Integración de reCAPTCHA v2 Invisible en el formulario de inicio de sesión de Roundcube.
	•	Configuración rápida de las claves de reCAPTCHA.
	•	Compatible con Roundcube 1.6.9 y versiones superiores de PHP y MariaDB.

Instalación

1. Clonar el Repositorio

Primero, clona este repositorio en el directorio de plugins de Roundcube:

cd /su/ruta/de/roundcube/plugins
git clone https://github.com/freddysein/rcsein.git rcsein

2. Configurar las Claves de reCAPTCHA

	1.	Navega al directorio del plugin:

cd rcsein


	2.	Copia el archivo de configuración de ejemplo y crea el archivo de configuración principal:

cp config.inc.php.dist config.inc.php


	3.	Edita config.inc.php para agregar tus claves de reCAPTCHA:

<?php
$config['recaptcha_public_key'] = 'TU_SITE_KEY';
$config['recaptcha_secret_key'] = 'TU_SECRET_KEY';

Reemplaza 'TU_SITE_KEY' y 'TU_SECRET_KEY' con las claves proporcionadas por Google reCAPTCHA.

3. Habilitar el Plugin en Roundcube

Abre el archivo de configuración principal de Roundcube (config/config.inc.php) y agrega rcsein a la lista de plugins:

$config['plugins'] = ['rcsein', /* otros plugins */];


