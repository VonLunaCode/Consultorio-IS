# 🏥 Consultorio-IS Backend

Este es el proyecto backend para el Consultorio-IS, desarrollado en **Laravel** con el panel de administración **Filament** (v3.x).

---

## 🚀 Instalación y Puesta en Marcha (Local)

Para que tu entorno funcione correctamente, sigue estos 6️⃣ pasos cruciales en orden. Asumimos que estás utilizando **Laragon**.

### ⚙️ 1. Configuración Inicial y Dependencias

| Acción | Comando / Descripción |
| :--- | :--- |
| **Clonar Repositorio** | Clona el proyecto en tu carpeta de Laragon (`www`): `git clone https://github.com/VonLunaCode/Consultorio-IS.git` |
| **Crear .env** | Navega a la carpeta y crea tu archivo de configuración local: `cp .env.example .env` |
| **Instalar PHP** | Descarga las librerías de Composer: `composer install` |
| **Instalar JS** | Instala las dependencias de Node.js: `npm install` |

### 🔑 2. Seguridad y Base de Datos (DB)

Es vital completar estos pasos para evitar errores 500 y problemas de conexión.

1.  **Generar Clave de Cifrado (APP\_KEY):**
    * Genera la clave de cifrado (¡CRÍTICO para evitar el error 500!).
    ```bash
    php artisan key:generate
    ```
2.  **Configurar DB:** Edita el archivo **`.env`** con tus credenciales de Laragon (generalmente `root` sin contraseña) y el nombre de la DB (`consultorio_is`).
3.  **Ejecutar Migraciones:** Crea las tablas iniciales en la base de datos (incluyendo la de usuarios).
    ```bash
    php artisan migrate --seed
    ```

### ✨ 3. Compilación de Assets y Arranque

1.  **Compilar Assets de Frontend:** Genera los archivos CSS y JS necesarios para que Filament cargue correctamente.
    ```bash
    npm run build
    ```
2.  **Limpiar Caché:** Asegura que Laravel cargue la nueva configuración.
    ```bash
    php artisan optimize:clear
    ```
3.  **Crear Usuario Administrador (Filament):**
    * Crea el primer usuario que podrá acceder al panel de administración.
    ```bash
    php artisan make:filament-user
    ```

### 🟢 **Iniciar el Servidor:**
    ```bash
    php artisan serve
    ```
    El panel de administración está disponible en: `http://127.0.0.1:8000/admin`

---



  ## 📝 Convención de Commits (Conventional Commits)

Utilizaremos la convención de Commits Convencionales para mantener un historial limpio.

El formato es: `<tipo>(<ámbito opcional>): <descripción>`

| Tipo | Descripción |
| :--- | :--- |
| **feat** | Una nueva característica para el usuario (se traduce en un cambio de versión MINOR). |
| **fix** | Una corrección de un error (se traduce en un cambio de versión PATCH). |
| **chore** | Cambios en herramientas de construcción, librerías, o configuración. |
| **docs** | Cambios en la documentación (*README*, comentarios). |
| **style** | Cambios de formato que no afectan el significado del código (espacios, puntos y comas). |
| **refactor** | Cambio de código que no añade funcionalidad ni corrige un bug. |
| **test** | Adición o corrección de pruebas. |

**Ejemplo:**
`git commit -m "feat(users): Añadir campo 'phone' al modelo User"`