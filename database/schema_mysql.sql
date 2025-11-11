-- ========================================
-- SCHEMA BASE DE DATOS - SISTEMA ELECTORAL
-- ========================================
-- Base de datos: elecciones_db
-- Motor: MySQL 8.0+
-- Charset: utf8mb4
-- Collation: utf8mb4_unicode_ci
-- ========================================

-- Configuración inicial
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- 1. TABLAS DEL SISTEMA LARAVEL (BASE)
-- ========================================

-- Tabla de usuarios generales (Laravel default)
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de tokens de reseteo de contraseña
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de sesiones
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `ip_address` VARCHAR(45) NULL DEFAULT NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `sessions_user_id_index` (`user_id`),
  INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de cache
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de jobs (colas)
CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT NULL,
  `cancelled_at` INT NULL DEFAULT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL UNIQUE,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 2. TABLAS DE AUTENTICACIÓN Y USUARIOS
-- ========================================

-- Administradores del sistema
CREATE TABLE `admin_users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuarios del sistema (Admin y Voluntarios)
CREATE TABLE `usuarios` (
  `id_usuario` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `rol` ENUM('ADMIN', 'VOLUNTARIO') NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `creado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 3. TABLAS DE PERSONAS Y GESTIÓN COMÚN
-- ========================================

-- Registro de personas
CREATE TABLE `personas` (
  `id_persona` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ci` VARCHAR(20) NOT NULL UNIQUE,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NULL DEFAULT NULL,
  `correo` VARCHAR(100) NULL DEFAULT NULL,
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `ciudad` VARCHAR(100) NULL DEFAULT NULL,
  `estado` ENUM('VIVO', 'FALLECIDO') NOT NULL DEFAULT 'VIVO',
  `foto_carnet` VARCHAR(255) NULL DEFAULT NULL,
  `creado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_persona`),
  INDEX `personas_ci_index` (`ci`),
  INDEX `personas_estado_index` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Historial de roles de personas
CREATE TABLE `historial_personas` (
  `id_historial` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_persona` BIGINT UNSIGNED NOT NULL,
  `tipo_rol` VARCHAR(50) NOT NULL,
  `id_partido` BIGINT UNSIGNED NULL DEFAULT NULL,
  `fecha_inicio` DATE NULL DEFAULT NULL,
  `fecha_fin` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  INDEX `historial_personas_id_persona_index` (`id_persona`),
  CONSTRAINT `fk_historial_persona` FOREIGN KEY (`id_persona`) 
    REFERENCES `personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 4. TABLAS DE UBICACIÓN GEOGRÁFICA ELECTORAL
-- ========================================

-- Departamentos
CREATE TABLE `departamentos` (
  `id_departamento` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Provincias (pertenecen a departamentos)
CREATE TABLE `provincias` (
  `id_provincia` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `id_departamento` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_provincia`),
  INDEX `provincias_id_departamento_index` (`id_departamento`),
  CONSTRAINT `fk_provincia_departamento` FOREIGN KEY (`id_departamento`) 
    REFERENCES `departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Municipios (pertenecen a provincias)
CREATE TABLE `municipios` (
  `id_municipio` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `id_provincia` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_municipio`),
  INDEX `municipios_id_provincia_index` (`id_provincia`),
  CONSTRAINT `fk_municipio_provincia` FOREIGN KEY (`id_provincia`) 
    REFERENCES `provincias` (`id_provincia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Asientos electorales (pertenecen a municipios)
CREATE TABLE `asientos` (
  `id_asiento` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `id_municipio` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_asiento`),
  INDEX `asientos_id_municipio_index` (`id_municipio`),
  CONSTRAINT `fk_asiento_municipio` FOREIGN KEY (`id_municipio`) 
    REFERENCES `municipios` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Recintos electorales (pertenecen a asientos)
CREATE TABLE `recintos` (
  `id_recinto` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `direccion` VARCHAR(200) NULL DEFAULT NULL,
  `id_asiento` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_recinto`),
  INDEX `recintos_id_asiento_index` (`id_asiento`),
  CONSTRAINT `fk_recinto_asiento` FOREIGN KEY (`id_asiento`) 
    REFERENCES `asientos` (`id_asiento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mesas electorales (pertenecen a recintos)
CREATE TABLE `mesas` (
  `id_mesa` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` INT NOT NULL,
  `id_recinto` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_mesa`),
  UNIQUE KEY `mesas_id_recinto_numero_unique` (`id_recinto`, `numero`),
  INDEX `mesas_id_recinto_index` (`id_recinto`),
  CONSTRAINT `fk_mesa_recinto` FOREIGN KEY (`id_recinto`) 
    REFERENCES `recintos` (`id_recinto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 5. TABLAS DE PARTIDOS E INSTITUCIONES
-- ========================================

-- Partidos políticos
CREATE TABLE `partidos` (
  `id_partido` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sigla` VARCHAR(20) NOT NULL UNIQUE,
  `nombre` VARCHAR(100) NOT NULL,
  `estado` ENUM('ACTIVO', 'INACTIVO') NOT NULL DEFAULT 'ACTIVO',
  `logo_url` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_partido`),
  INDEX `partidos_estado_index` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar clave foránea a historial_personas (ahora que partidos existe)
ALTER TABLE `historial_personas`
  ADD CONSTRAINT `fk_historial_partido` FOREIGN KEY (`id_partido`) 
    REFERENCES `partidos` (`id_partido`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Instituciones observadoras
CREATE TABLE `instituciones` (
  `id_institucion` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `sigla` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id_institucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 6. TABLAS DE ROLES ELECTORALES
-- ========================================

-- Jurados de mesa
CREATE TABLE `jurados` (
  `id_jurado` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_persona` BIGINT UNSIGNED NOT NULL,
  `id_mesa` BIGINT UNSIGNED NOT NULL,
  `cargo` ENUM('PRESIDENTE', 'SECRETARIO', 'VOCAL', 'SUPLENTE') NOT NULL,
  `verificado` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_jurado`),
  INDEX `jurados_id_persona_index` (`id_persona`),
  INDEX `jurados_id_mesa_index` (`id_mesa`),
  CONSTRAINT `fk_jurado_persona` FOREIGN KEY (`id_persona`) 
    REFERENCES `personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_jurado_mesa` FOREIGN KEY (`id_mesa`) 
    REFERENCES `mesas` (`id_mesa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Veedores (observadores electorales)
CREATE TABLE `veedores` (
  `id_veedor` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_persona` BIGINT UNSIGNED NOT NULL,
  `id_institucion` BIGINT UNSIGNED NOT NULL,
  `carta_respaldo` VARCHAR(255) NULL DEFAULT NULL,
  `estado` ENUM('PENDIENTE', 'APROBADO', 'RECHAZADO') NOT NULL DEFAULT 'PENDIENTE',
  `motivo_rechazo` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_veedor`),
  INDEX `veedores_id_persona_index` (`id_persona`),
  INDEX `veedores_id_institucion_index` (`id_institucion`),
  INDEX `veedores_estado_index` (`estado`),
  CONSTRAINT `fk_veedor_persona` FOREIGN KEY (`id_persona`) 
    REFERENCES `personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_veedor_institucion` FOREIGN KEY (`id_institucion`) 
    REFERENCES `instituciones` (`id_institucion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Delegados de partidos políticos
CREATE TABLE `delegados` (
  `id_delegado` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_persona` BIGINT UNSIGNED NOT NULL,
  `id_partido` BIGINT UNSIGNED NOT NULL,
  `id_mesa` BIGINT UNSIGNED NULL DEFAULT NULL,
  `habilitado` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_delegado`),
  UNIQUE KEY `delegados_persona_partido_mesa_unique` (`id_persona`, `id_partido`, `id_mesa`),
  INDEX `delegados_id_persona_index` (`id_persona`),
  INDEX `delegados_id_partido_index` (`id_partido`),
  INDEX `delegados_id_mesa_index` (`id_mesa`),
  CONSTRAINT `fk_delegado_persona` FOREIGN KEY (`id_persona`) 
    REFERENCES `personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_delegado_partido` FOREIGN KEY (`id_partido`) 
    REFERENCES `partidos` (`id_partido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_delegado_mesa` FOREIGN KEY (`id_mesa`) 
    REFERENCES `mesas` (`id_mesa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 7. TABLAS DE ASISTENCIA
-- ========================================

-- Control de asistencia de jurados
CREATE TABLE `asistencia` (
  `id_asistencia` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_jurado` BIGINT UNSIGNED NOT NULL,
  `id_mesa` BIGINT UNSIGNED NOT NULL,
  `estado` ENUM('PRESENTE', 'AUSENTE') NOT NULL DEFAULT 'AUSENTE',
  `registrado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_asistencia`),
  INDEX `asistencia_id_jurado_index` (`id_jurado`),
  INDEX `asistencia_id_mesa_index` (`id_mesa`),
  CONSTRAINT `fk_asistencia_jurado` FOREIGN KEY (`id_jurado`) 
    REFERENCES `jurados` (`id_jurado`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_asistencia_mesa` FOREIGN KEY (`id_mesa`) 
    REFERENCES `mesas` (`id_mesa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 8. TABLAS DE CREDENCIALES
-- ========================================

-- Credenciales generadas (PDFs con QR)
CREATE TABLE `credenciales` (
  `id_credencial` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_persona` BIGINT UNSIGNED NOT NULL,
  `rol` VARCHAR(50) NOT NULL COMMENT 'JURADO, VEEDOR, DELEGADO',
  `tipo` VARCHAR(50) NOT NULL DEFAULT 'CREDENCIAL',
  `nombre_archivo` VARCHAR(255) NOT NULL,
  `ruta_archivo` VARCHAR(500) NOT NULL,
  `estado` VARCHAR(50) NOT NULL DEFAULT 'GENERADO' COMMENT 'GENERADO, DESCARGADO, EXPIRADO',
  `contenido_qr` TEXT NULL DEFAULT NULL,
  `generado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descargado_en` TIMESTAMP NULL DEFAULT NULL,
  `expira_en` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_credencial`),
  INDEX `credenciales_id_persona_rol_index` (`id_persona`, `rol`),
  INDEX `credenciales_estado_index` (`estado`),
  INDEX `credenciales_generado_en_index` (`generado_en`),
  CONSTRAINT `fk_credencial_persona` FOREIGN KEY (`id_persona`) 
    REFERENCES `personas` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 9. TABLAS DE ACADEMIA ELECTORAL (CAPACITACIÓN)
-- ========================================

-- Capacitaciones disponibles
CREATE TABLE `capacitaciones` (
  `id_capacitacion` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `rol_destino` VARCHAR(50) NOT NULL COMMENT 'JURADO, VEEDOR, DELEGADO',
  `estado` VARCHAR(20) NOT NULL DEFAULT 'ACTIVO' COMMENT 'ACTIVO, INACTIVO',
  `total_niveles` INT NOT NULL DEFAULT 3,
  `puntaje_minimo` INT NOT NULL DEFAULT 90 COMMENT 'Porcentaje mínimo para aprobar',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_capacitacion`),
  INDEX `capacitaciones_rol_destino_index` (`rol_destino`),
  INDEX `capacitaciones_estado_index` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Niveles de cada capacitación
CREATE TABLE `capacitacion_niveles` (
  `id_nivel` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_capacitacion` BIGINT UNSIGNED NOT NULL,
  `numero_nivel` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `contenido` TEXT NOT NULL,
  `tipo_contenido` VARCHAR(50) NOT NULL DEFAULT 'TEXTO' COMMENT 'TEXTO, VIDEO, PDF, IMAGEN',
  `archivo_url` VARCHAR(500) NULL DEFAULT NULL,
  `duracion_minutos` INT NULL DEFAULT NULL,
  `requiere_completar` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_nivel`),
  INDEX `capacitacion_niveles_id_capacitacion_numero_nivel_index` (`id_capacitacion`, `numero_nivel`),
  CONSTRAINT `fk_nivel_capacitacion` FOREIGN KEY (`id_capacitacion`) 
    REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Progreso de capacitación por persona
CREATE TABLE `progreso_capacitaciones` (
  `id_progreso` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_persona` BIGINT UNSIGNED NOT NULL,
  `id_capacitacion` BIGINT UNSIGNED NOT NULL,
  `nivel_actual` INT NOT NULL DEFAULT 1,
  `completado` TINYINT(1) NOT NULL DEFAULT 0,
  `puntaje_quiz` INT NULL DEFAULT NULL,
  `aprobado` TINYINT(1) NOT NULL DEFAULT 0,
  `fecha_inicio` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_completado` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_progreso`),
  UNIQUE KEY `progreso_capacitaciones_persona_capacitacion_unique` (`id_persona`, `id_capacitacion`),
  INDEX `progreso_capacitaciones_id_persona_id_capacitacion_index` (`id_persona`, `id_capacitacion`),
  INDEX `progreso_capacitaciones_completado_index` (`completado`),
  INDEX `progreso_capacitaciones_aprobado_index` (`aprobado`),
  CONSTRAINT `fk_progreso_persona` FOREIGN KEY (`id_persona`) 
    REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `fk_progreso_capacitacion` FOREIGN KEY (`id_capacitacion`) 
    REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Preguntas de quiz
CREATE TABLE `quiz_preguntas` (
  `id_pregunta` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_capacitacion` BIGINT UNSIGNED NOT NULL,
  `pregunta` TEXT NOT NULL,
  `tipo` VARCHAR(20) NOT NULL DEFAULT 'MULTIPLE' COMMENT 'MULTIPLE, VERDADERO_FALSO',
  `puntos` INT NOT NULL DEFAULT 1,
  `activa` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_pregunta`),
  INDEX `quiz_preguntas_id_capacitacion_activa_index` (`id_capacitacion`, `activa`),
  CONSTRAINT `fk_pregunta_capacitacion` FOREIGN KEY (`id_capacitacion`) 
    REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Respuestas de quiz
CREATE TABLE `quiz_respuestas` (
  `id_respuesta` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pregunta` BIGINT UNSIGNED NOT NULL,
  `opcion` TEXT NOT NULL,
  `es_correcta` TINYINT(1) NOT NULL DEFAULT 0,
  `orden` INT NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_respuesta`),
  INDEX `quiz_respuestas_id_pregunta_orden_index` (`id_pregunta`, `orden`),
  CONSTRAINT `fk_respuesta_pregunta` FOREIGN KEY (`id_pregunta`) 
    REFERENCES `quiz_preguntas` (`id_pregunta`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 10. TABLA DE CAPACITACIONES (LEGACY)
-- ========================================

-- Tabla legacy de capacitaciones (puede estar en desuso)
CREATE TABLE `capacitacions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- FINALIZACIÓN
-- ========================================

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- ========================================
-- NOTAS IMPORTANTES
-- ========================================
-- 1. Este schema mantiene la integridad referencial completa
-- 2. Las tablas están ordenadas respetando dependencias de claves foráneas
-- 3. Se incluyen índices para optimizar consultas frecuentes
-- 4. Los ENUM están definidos según la lógica de negocio
-- 5. Las tablas de Laravel (cache, jobs, sessions) están incluidas
-- 6. Charset utf8mb4 para soporte completo de caracteres Unicode
-- ========================================
