## PHARMIX - DISTRIBUIDORA.
Solución de software web para la distribución farmacéutica masiva. Permite a los depósitos mayoristas gestionar clientes, registrar pedidos telefónicos de manera ágil a través de un panel administrativo y garantizar el cumplimiento legal mediante la integración de facturación electrónica instantánea al procesar pagos y envíos.

# ESTRUCTURA.
Se hace un desarrollo con el MVC clásico agregandole una capa extra a la arquitectura del proyecto el cual son los servicios, los cuales se encargan de interactuar directamente con los modelos, dejando que los controladores solamente reciban las peticiones y se las remitan al servicio para que haga la lógica de negocio, con esto ganamos separar responsabilidades, legibilidad de código y facilidad para optimización y mantenimiento. 

Usamos Request para validar lo que nos llega por medio de la petición y así poder retornar un mensaje directo, esto con el fin de mantener limpio nuestro controlador y mantener las responsabilidades separadas, aparte de facilitarnos la validación de la información que nos llega por medio de la API por parte de nuestro Front-end.

# INTEGRACIÓN DE API-FACTUS.
En este desarrollo se tiene previsto hacer la integración de la API de Factus de HallTec para generar facturación electrónica a los pedidos realizados por medio de nuestro sistema. Este proceso aún está en desarrollo ya que se está empezando con las demás partes del sistema, en este apartado se encontrará la información de la integración, consumo y demás cuándo el módulo se encuentre realizado. 

# CLONAR REPOSITORIO.
Para clonar este repositorio simplemente es necesario tener Git instalado y configurado en nuestra máquina, situarse en la ruta de su preferencia a través de la terminal y ejecutar el siguiente comando:
```bash
git clone https://github.com/DuvanFH11/Pharmix-back-end.git
```
Esto descargará automáticamente todo el código disponible en una nueva carpeta.  
**NOTA: Para subir código al repositorio es necesario ser colaborador del mismo.**

# EXPLICACIÓN DE FUNCIONAMIENTO - DESARROLLADOR.
La estructura y forma de desarrollo y comunicación de esta app es usando Laravel Sanctum, con la cookies SPA Authentication.
Ya que el Front-end que está desarrollado en React y el Back-end del proyecto en el momento del desarrollo se encuentran bajo un mismo dominio superior, que es LocalHost aunque se despliegan  en distintos puertos. Sanctum está diseñado especificamente para aprovechar esto.
Y cuándo nuestro Front-end primero llamando la ruta /sanctum/csrf-cookie y luego al login, laravel responde enviando una cookie de sesión encriptada. El navegador guarda esta cookie y la envía automáticamente en cada petición posterior que hacemos desde React a Laravel.
Luego el Middleware se encarga de todo, porque cuándo una petición llega desde React a nuestras rutas protegidas, el middleware de Sanctum revisa la petición, detecta que viene una cookie de sesión de Laravel válida.
Autentíca al usuario usando las sesiones tradicionales de la web. Al resolver a través de cookies y sesiones, Sanctum jamás intenta buscar o validar tokens en la base de datos.

# MIGRACIONES Y SEEDERS
Las migraciones se encuentran ordenadas correctamente por su nombre, el cual va indicando cual debe ejecutarse primero para que evitar errores en las relaciones de las tablas. Las seeders igualmente se encuentran ordenadas en la seed DatabaseSeeder y si se siguen creando más se recomienda y aconseja ponerlas en orden, al igual que las migraciones.

# VARIABLES DE ENTORNO.
En nuestro archivo .env.example encontramos la configuración de nuestras variables de entorno, donde se encuentra toda la configuración de nuestra aplicación y conexión con el Front-end. Cómo estamos manejando migraciones de Laravel no se está dejando información en los campos DB_USERNAME, DB_PASSWORD para que el desarrollador que haga la clonación del proyecto pueda poner las credenciales de su base de datos y así migrar todas las tablas y ejecutar los seeders como mejor le parezca, de esta forma cumplimos con la portabilidad del desarrollo.

# PRONOSTICO DE DESPLIEGUE.
Para garantizar que el sistema funcione de forma ágil, segura y profesional, la aplicación no se aloja en un hosting tradicional, sino que se monta en una infraestructura moderna en la nube estructurada bajo un mismo dominio principal:
* **Servidor en la Nube (AWS + Ubuntu):** Todo el sistema se aloja de forma gratuita en una instancia de AWS (Amazon Web Services) corriendo sobre un sistema operativo Ubuntu Server. En lugar de usar servicios independientes separados (como subir React a Vercel/Netlify o Laravel a un VPS tradicional vía Coolify/Forge), centralizamos todo el entorno para obtener un control total y estabilidad de nivel empresarial.
* **Tecnología de Contenedores (Docker):** El proyecto está completamente "empaquetado" usando Docker y Docker Compose. Esto significa que tanto el Front-end (React), el Back-end (Laravel) como la base de datos corren dentro de contenedores independientes y aislados en el mismo servidor. Así, nos aseguramos de que la aplicación funcione exactamente igual en internet que en la computadora de desarrollo, evitando errores inesperados.
* **Gestión de Dominio y Cookies:** Para mantener la autenticación nativa por cookies (Laravel Sanctum), los contenedores se vinculan bajo un mismo dominio principal (ej. React en miweb.com y Laravel en api.miweb.com). Al compartir este origen común, el navegador intercambia las cookies de sesión de manera transparente y 100% segura con los respectivos ajustes en los archivos CORS y .env.
* **Conexión Segura (Nginx):** Un contenedor interno de Nginx actúa como proxy inverso. Se encarga de recibir a los usuarios bajo el dominio configurado, redirigir el tráfico hacia el contenedor del Front-end o del Back-end según corresponda, y activar los candados de seguridad (certificados SSL automáticos) para garantizar una navegación completamente cifrada.

