<?php

require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/ROL_ID_ADMINISTRADOR.php";
require_once __DIR__ . "/../libservidorphp/rolBusca.php";
require_once __DIR__ . "/../libservidorphp/rolAgrega.php";
require_once __DIR__ . "/../libservidorphp/usuRolAgrega.php";
require_once __DIR__ . "/usuarioBuscaSan.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Bd
{

  private static ?PDO $pdo = null;

  static function pdo(): PDO
  {
    if (self::$pdo === null) {

      self::$pdo = new PDO(
        "sqlite:" . __DIR__ . "/srvaut.db",
        null,
        null,
        [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );

      self::$pdo->exec(
        'CREATE TABLE IF NOT EXISTS USUARIO (
      USU_ID INTEGER,
      USU_SAN TEXT NOT NULL,
      USU_SEN TEXT NOT NULL,
      CONSTRAINT USU_PK
       PRIMARY KEY(USU_ID),
      CONSTRAINT USU_SAN_UNQ
       UNIQUE(USU_SAN),
      CONSTRAINT USU_SAN_NV
       CHECK(LENGTH(USU_SAN) > 0)
     )'
      );

      self::$pdo->exec(
        'CREATE TABLE IF NOT EXISTS ROL (
      ROL_ID TEXT NOT NULL,
      ROL_DESCRIPCION TEXT NOT NULL,
      CONSTRAINT ROL_PK
       PRIMARY KEY(ROL_ID),
      CONSTRAINT ROL_ID_NV
       CHECK(LENGTH(ROL_ID) > 0),
      CONSTRAINT ROL_DESCR_UNQ
       UNIQUE(ROL_DESCRIPCION),
      CONSTRAINT ROL_DESCR_NV
       CHECK(LENGTH(ROL_DESCRIPCION) > 0)
     )'
      );

      self::$pdo->exec(
        'CREATE TABLE IF NOT EXISTS USU_ROL (
       USU_ID INTEGER NOT NULL,
       ROL_ID TEXT NOT NULL,
       CONSTRAINT USU_ROL_PK
        PRIMARY KEY(USU_ID, ROL_ID),
       CONSTRAINT USU_ROL_USU_FK
        FOREIGN KEY (USU_ID) REFERENCES USUARIO(USU_ID),
       CONSTRAINT USU_ROL_ROL_FK
        FOREIGN KEY (ROL_ID) REFERENCES ROL(ROL_ID)
      )'
      );

      self::$pdo->exec(
        'CREATE TABLE IF NOT EXISTS CONTACTO (
      CON_ID INTEGER,
      USU_ID INTEGER NOT NULL,
      CON_NOMBRE TEXT NOT NULL,
      CON_DESCRIPCION TEXT NOT NULL,
      CON_EMAIL TEXT NOT NULL,
      CONSTRAINT CON_PK
       PRIMARY KEY(CON_ID),
      CONSTRAINT CON_USU_FK
       FOREIGN KEY (USU_ID) REFERENCES USUARIO(USU_ID),
      CONSTRAINT CON_NOMBRE_NV
       CHECK(LENGTH(CON_NOMBRE) > 0),
      CONSTRAINT CON_DESCRIPCION_NV
       CHECK(LENGTH(CON_DESCRIPCION) > 0),
      CONSTRAINT CON_EMAIL_NV
       CHECK(LENGTH(CON_EMAIL) > 0)
     )'
      );

      self::$pdo->beginTransaction();

      if (rolBusca(self::$pdo, "Administrador") === false) {
        rolAgrega(
          bd: self::$pdo,
          id: "Administrador",
          descripcion: "Administra el sistema."
        );
      }

      if (rolBusca(self::$pdo, "Cliente") === false) {
        rolAgrega(
          bd: self::$pdo,
          id: "Cliente",
          descripcion: "Realiza compras."
        );
      }

      $usuarioAgrega = self::$pdo->prepare(
        "INSERT INTO USUARIO (
      USU_SAN, USU_SEN
     ) VALUES (
      :USU_SAN, :USU_SEN
     )"
      );

      if (usuarioBuscaSan(self::$pdo, "admin") === false) {
        $usuarioAgrega->execute([
          ":USU_SAN" => "admin",
          ":USU_SEN" => password_hash("Admin@12345", PASSWORD_DEFAULT),
        ]);
        $usuId = self::$pdo->lastInsertId();
        usuRolAgrega(self::$pdo, $usuId, [ROL_ID_ADMINISTRADOR]);
      }

      if (usuarioBuscaSan(self::$pdo, "cliente01") === false) {
        $usuarioAgrega->execute([
          ":USU_SAN" => "cliente01",
          ":USU_SEN" => password_hash("Cliente@12345", PASSWORD_DEFAULT),
        ]);
        $usuId = self::$pdo->lastInsertId();
        usuRolAgrega(self::$pdo, $usuId, [ROL_ID_CLIENTE]);
      }

      if (usuarioBuscaSan(self::$pdo, "soporte") === false) {
        $usuarioAgrega->execute([
          ":USU_SAN" => "soporte",
          ":USU_SEN" => password_hash("Soporte@12345", PASSWORD_DEFAULT),
        ]);
        $usuId = self::$pdo->lastInsertId();
        usuRolAgrega(self::$pdo, $usuId, [ROL_ID_CLIENTE, ROL_ID_ADMINISTRADOR]);
      }

      self::$pdo->commit();
    }

    return self::$pdo;
  }
}
