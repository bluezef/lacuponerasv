LaCuponeraSV - Instrucciones de Uso (Windows con XAMPP)

Prerrequisitos:
Sistema Operativo Windows
XAMPP Instalado
Git (opcional, para clonar repositorio)

Pasos para la instalación:
1 - Instala y configura XAMPP
  Descarga e instala XAMPP del sitio web oficial.
  Lanza el Panel de Control de XAMPP.
  Inicia los servicios de Apache y MySQL.
2 - Configura el proyecto:
  Opcion A: Clonar del repositorio
  git clone https://github.com/bluezef/lacuponerasv
  cd LaCuponeraSV
  Opcion B: Descargar el ZIP
  Descarga el ZIP
  Extraelo en el folder htdocs dentro del folder de XAMPP
3 - Configura la Basse de Datos:
  Abre phpMyAdmin en tu localhost http://localhost/phpmyadmin
  Crea una nueva base de datos llamada cuponera
  Usa el archivo SQL incluido en la descarga Database.sql
4 - Ejecuta la aplicación:
  Asegúrate que los servicios Apache y MySQL de XAMPP estén activos.
  Dirígete a http://localhost/LaCuponeraSV
