import {
 configuraSubmitAccion
} from "../libclienteweb/configuraSubmitAccion.js"
import { descargaVista } from "../libclienteweb/descargaVista.js"

descargaDatos()

async function descargaDatos() {
 await descargaVista("api/vista-login.php")
 const formulario = document.querySelector("form")
 if (formulario) {
  configuraSubmitAccion("api/login.php", formulario, "perfil.html")
 }
}