<?php

class Bd
{
 private static ?PDO $pdo = null;

 static function conexion(): PDO
 {
  if (self::$pdo === null) {

   self::$pdo = new PDO(
    "sqlite:" . __DIR__ . "/srvbd.db",
    null,
    null,
    [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
   );

   $stmt = self::$pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='USUARIOS'");
   $tablaExiste = $stmt->fetch();

   if (!$tablaExiste) {
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS USUARIOS (
          USU_ID INTEGER PRIMARY KEY AUTOINCREMENT,
          USU_NOMBRE TEXT NOT NULL,
          USU_APELLIDO_PATERNO TEXT NOT NULL,
          USU_APELLIDO_MATERNO TEXT,
          USU_MATRICULA TEXT NOT NULL UNIQUE,
          USU_GRUPO TEXT NOT NULL,
          CONSTRAINT CHK_USU_NOM CHECK(LENGTH(USU_NOMBRE) > 0),
          CONSTRAINT CHK_USU_APELLIDO_PATERNO CHECK(LENGTH(USU_APELLIDO_PATERNO) > 0),
          CONSTRAINT CHK_USU_MATRICULA CHECK(LENGTH(USU_MATRICULA) > 0),
          CONSTRAINT CHK_USU_GRUPO CHECK(LENGTH(USU_GRUPO) > 0)
        )"
      );
      if (self::$pdo->errorCode() !== '00000') {
        error_log('Error creating USUARIOS table: ' . implode(' ', self::$pdo->errorInfo()));
      }
   }

      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS ADMINS (
          ADM_ID INTEGER PRIMARY KEY AUTOINCREMENT,
          ADM_NOMBRE TEXT NOT NULL,
          ADM_APELLIDO_PATERNO TEXT NOT NULL,
          ADM_APELLIDO_MATERNO TEXT,
          ADM_CORREO TEXT NOT NULL UNIQUE,
          ADM_EDAD INTEGER NOT NULL, 
          ADM_PASSWORD_HASH TEXT NOT NULL,
          ADM_ROL TEXT NOT NULL CHECK (ADM_ROL IN ('admin', 'user')) ,
          CONSTRAINT CHK_ADM_NOM CHECK(LENGTH(ADM_NOMBRE) > 0),
          CONSTRAINT CHK_ADM_APELLIDO_PATERNO CHECK(LENGTH(ADM_APELLIDO_PATERNO) > 0),
          CONSTRAINT CHK_ADM_PASSWORD_HASH CHECK(LENGTH(ADM_PASSWORD_HASH) > 0)
        )"
      );
      if (self::$pdo->errorCode() !== '00000') {
        error_log('Error creating ADMINS table: ' . implode(' ', self::$pdo->errorInfo()));
      }

      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS LOGS (
          LOG_ID INTEGER PRIMARY KEY AUTOINCREMENT,
          LOG_TIMESTAMP TEXT NOT NULL,
          LOG_IP TEXT NOT NULL,
          LOG_USER TEXT NOT NULL,
          LOG_VIEW TEXT NOT NULL,
          LOG_ACTION TEXT NOT NULL,
          LOG_DETAILS TEXT
        )"
      );
      if (self::$pdo->errorCode() !== '00000') {
        error_log('Error creating LOGS table: ' . implode(' ', self::$pdo->errorInfo()));
      }
  }

  return self::$pdo;
 }
}